<?php

namespace App\Services;

use App\Models\Pembayaran;
use App\Models\PaymentMethod;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DuitkuPaymentService
{
    private string $merchantCode;
    private string $apiKey;
    private bool $sandboxMode;
    private array $urls;
    private string $callbackUrl;
    private string $returnUrl;
    private int $expiryPeriod;

    public function __construct()
    {
        $this->merchantCode = config('duitku.merchant_code');
        $this->apiKey = config('duitku.api_key');
        $this->sandboxMode = config('duitku.sandbox_mode');
        $this->urls = config('duitku.urls')[
            $this->sandboxMode ? 'sandbox' : 'production'
        ];
        $this->callbackUrl = config('duitku.callback_url');
        $this->returnUrl = config('duitku.return_url');
        $this->expiryPeriod = config('duitku.expiry_period');
    }

    /**
     * Generate signature untuk Duitku
     */
    public function generateSignature(string $merchantCode, string $orderId, int $amount, string $apiKey): string
    {
        return md5($merchantCode . $orderId . $amount . $apiKey);
    }

    /**
     * Get available payment methods dari Duitku
     */
    public function getPaymentMethods(int $amount): array
    {
        try {
            $datetime = now()->format('Y-m-d H:i:s');
            $signature = hash('sha256', $this->merchantCode . $amount . $datetime . $this->apiKey);

            $response = Http::post($this->urls['payment_method'], [
                'merchantcode' => $this->merchantCode,
                'amount' => $amount,
                'datetime' => $datetime,
                'signature' => $signature,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if ($data['responseCode'] === '00') {
                    return $data['paymentFee'] ?? [];
                }
            }

            Log::warning('Failed to get payment methods from Duitku', [
                'response' => $response->body()
            ]);

            return [];
        } catch (Exception $e) {
            Log::error('Error getting payment methods', [
                'message' => $e->getMessage()
            ]);
            return [];
        }
    }

    /**
     * Sync payment methods ke database
     */
    public function syncPaymentMethods(int $amount): bool
    {
        try {
            $methods = $this->getPaymentMethods($amount);

            if (empty($methods)) {
                return false;
            }

            foreach ($methods as $method) {
                PaymentMethod::updateOrCreate(
                    ['payment_method' => $method['paymentMethod']],
                    [
                        'payment_name' => $method['paymentName'],
                        'payment_image' => $method['paymentImage'] ?? null,
                        'total_fee' => $method['totalFee'] ?? 0,
                        'is_active' => true,
                    ]
                );
            }

            return true;
        } catch (Exception $e) {
            Log::error('Error syncing payment methods', [
                'message' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Create payment request ke Duitku
     */
    public function createPaymentRequest(Pembayaran $pembayaran, string $paymentMethod): array
    {
        try {
            $signature = $this->generateSignature(
                $this->merchantCode,
                $pembayaran->merchant_order_id,
                (int) $pembayaran->amount,
                $this->apiKey
            );

            $itemDetails = [
                [
                    'name' => 'Pembayaran Permohonan - ' . $pembayaran->permohonan->judul,
                    'price' => (int) $pembayaran->amount,
                    'quantity' => 1,
                ]
            ];

            $customerDetail = [
                'firstName' => $pembayaran->user->name ?? 'Customer',
                'lastName' => '',
                'email' => $pembayaran->user->email,
                'phoneNumber' => $pembayaran->user->no_hp ?? '',
                'billingAddress' => [
                    'firstName' => $pembayaran->user->name ?? 'Customer',
                    'lastName' => '',
                    'address' => $pembayaran->user->instansi ?? 'Indonesia',
                    'city' => 'Indonesia',
                    'postalCode' => '00000',
                    'phone' => $pembayaran->user->no_hp ?? '',
                    'countryCode' => 'ID'
                ]
            ];

            $payload = [
                'merchantCode' => $this->merchantCode,
                'paymentAmount' => (int) $pembayaran->amount,
                'paymentMethod' => $paymentMethod,
                'merchantOrderId' => $pembayaran->merchant_order_id,
                'productDetails' => 'Pembayaran Permohonan Pengujian',
                'additionalParam' => 'permohonan_id:' . $pembayaran->permohonan_id,
                'merchantUserInfo' => $pembayaran->user->email,
                'customerVaName' => substr($pembayaran->user->name ?? 'Customer', 0, 20),
                'email' => $pembayaran->user->email,
                'phoneNumber' => $pembayaran->user->no_hp ?? '',
                'itemDetails' => $itemDetails,
                'customerDetail' => $customerDetail,
                'callbackUrl' => $this->callbackUrl,
                'returnUrl' => $this->returnUrl,
                'signature' => $signature,
                'expiryPeriod' => $this->expiryPeriod,
            ];

            $response = Http::post($this->urls['inquiry'], $payload);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['statusCode']) && $data['statusCode'] === '00') {
                    // Update pembayaran dengan response dari Duitku
                    $pembayaran->update([
                        'duitku_reference' => $data['reference'] ?? null,
                        'va_number' => $data['vaNumber'] ?? null,
                        'payment_url' => $data['paymentUrl'] ?? null,
                        'payment_method' => $paymentMethod,
                        'status' => 'pending',
                    ]);

                    return [
                        'success' => true,
                        'data' => $data,
                    ];
                }
            }

            Log::warning('Failed to create payment request', [
                'response' => $response->body(),
                'pembayaran_id' => $pembayaran->id
            ]);

            return [
                'success' => false,
                'message' => 'Gagal membuat permintaan pembayaran',
            ];
        } catch (Exception $e) {
            Log::error('Error creating payment request', [
                'message' => $e->getMessage(),
                'pembayaran_id' => $pembayaran->id
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Verify callback signature dari Duitku
     */
    public function verifyCallbackSignature(array $data): bool
    {
        $signature = $data['signature'] ?? null;

        if (!$signature) {
            return false;
        }

        $params = $data['merchantCode'] . $data['amount'] . $data['merchantOrderId'] . $this->apiKey;
        $calculatedSignature = md5($params);

        return $signature === $calculatedSignature;
    }

    /**
     * Check transaction status dari Duitku
     */
    public function checkTransactionStatus(Pembayaran $pembayaran): array
    {
        try {
            $signature = $this->generateSignature(
                $this->merchantCode,
                $pembayaran->merchant_order_id,
                (int) $pembayaran->amount,
                $this->apiKey
            );

            $response = Http::post($this->urls['transaction_status'], [
                'merchantCode' => $this->merchantCode,
                'merchantOrderId' => $pembayaran->merchant_order_id,
                'signature' => $signature,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return [
                'statusCode' => '02',
                'statusMessage' => 'FAILED',
            ];
        } catch (Exception $e) {
            Log::error('Error checking transaction status', [
                'message' => $e->getMessage(),
                'pembayaran_id' => $pembayaran->id
            ]);

            return [
                'statusCode' => '02',
                'statusMessage' => 'ERROR',
            ];
        }
    }
}
