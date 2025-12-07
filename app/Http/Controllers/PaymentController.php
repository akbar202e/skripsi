<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Permohonan;
use App\Services\DuitkuPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    private DuitkuPaymentService $duitkuService;

    public function __construct(DuitkuPaymentService $duitkuService)
    {
        $this->duitkuService = $duitkuService;
    }

    /**
     * Tampilkan halaman pembayaran untuk permohonan
     */
    public function show(Permohonan $permohonan)
    {
        // Authorization check
        if (Auth::user()->id !== $permohonan->user_id) {
            abort(403, 'Anda tidak memiliki akses ke permohonan ini');
        }

        // Check apakah permohonan status menunggu pembayaran dan sample
        if ($permohonan->status !== 'menunggu_pembayaran_sampel') {
            return redirect()->route('filament.admin.pages.dashboard')
                ->with('error', 'Permohonan tidak dalam status menunggu pembayaran');
        }

        // Get atau create pembayaran
        $pembayaran = Pembayaran::where('permohonan_id', $permohonan->id)
            ->orderByDesc('created_at')
            ->first();

        if (!$pembayaran) {
            $pembayaran = Pembayaran::create([
                'permohonan_id' => $permohonan->id,
                'user_id' => Auth::id(),
                'amount' => $permohonan->total_biaya,
                'merchant_order_id' => 'ORDER-' . $permohonan->id . '-' . Str::random(8),
                'status' => 'pending',
            ]);
        }

        // Sync payment methods dari Duitku
        $this->duitkuService->syncPaymentMethods((int) $pembayaran->amount);

        // Get available payment methods
        $paymentMethods = \App\Models\PaymentMethod::where('is_active', true)
            ->get();

        return view('payment.show', [
            'permohonan' => $permohonan,
            'pembayaran' => $pembayaran,
            'paymentMethods' => $paymentMethods,
        ]);
    }

    /**
     * Proses pembayaran - redirect ke Duitku
     */
    public function process(Request $request, Permohonan $permohonan)
    {
        // Authorization check
        if (Auth::user()->id !== $permohonan->user_id) {
            abort(403, 'Anda tidak memiliki akses');
        }

        $request->validate([
            'payment_method' => 'required|string|max:2',
        ]);

        $pembayaran = Pembayaran::where('permohonan_id', $permohonan->id)
            ->latest()
            ->first();

        if (!$pembayaran) {
            return redirect()->back()->with('error', 'Pembayaran tidak ditemukan');
        }

        // Create payment request ke Duitku
        $result = $this->duitkuService->createPaymentRequest(
            $pembayaran,
            $request->input('payment_method')
        );

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message'] ?? 'Gagal membuat permintaan pembayaran');
        }

        // Redirect ke payment URL
        return redirect()->away($result['data']['paymentUrl']);
    }

    /**
     * Callback dari Duitku
     */
    public function callback(Request $request)
    {
        // Log callback untuk debugging
        Log::info('Duitku Callback Received', $request->all());

        try {
            // Verify signature
            if (!$this->duitkuService->verifyCallbackSignature($request->all())) {
                Log::error('Invalid callback signature', $request->all());
                return response('INVALID_SIGNATURE', 400);
            }

            $merchantOrderId = $request->input('merchantOrderId');
            $resultCode = $request->input('resultCode');
            $reference = $request->input('reference');

            // Find pembayaran by merchant order id
            $pembayaran = Pembayaran::where('merchant_order_id', $merchantOrderId)->first();

            if (!$pembayaran) {
                Log::error('Pembayaran not found', ['merchantOrderId' => $merchantOrderId]);
                return response('NOT_FOUND', 404);
            }

            // Update pembayaran status
            if ($resultCode === '00') {
                // Payment successful
                $pembayaran->update([
                    'status' => 'success',
                    'result_code' => $resultCode,
                    'duitku_reference' => $reference,
                    'paid_at' => now(),
                ]);

                // Update permohonan is_paid status
                $pembayaran->permohonan->update(['is_paid' => true]);

                Log::info('Payment successful', ['pembayaran_id' => $pembayaran->id]);
            } else {
                // Payment failed
                $pembayaran->update([
                    'status' => 'failed',
                    'result_code' => $resultCode,
                    'duitku_reference' => $reference,
                ]);

                Log::warning('Payment failed', ['pembayaran_id' => $pembayaran->id, 'resultCode' => $resultCode]);
            }

            // Return success response (HTTP 200)
            return response('OK', 200);
        } catch (\Exception $e) {
            Log::error('Error processing callback', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response('ERROR', 500);
        }
    }

    /**
     * Return URL setelah payment
     */
    public function return(Request $request)
    {
        $merchantOrderId = $request->input('merchantOrderId');
        $resultCode = $request->input('resultCode');
        $reference = $request->input('reference');

        $pembayaran = Pembayaran::where('merchant_order_id', $merchantOrderId)->first();

        if (!$pembayaran) {
            return redirect()->route('filament.admin.pages.dashboard')
                ->with('error', 'Pembayaran tidak ditemukan');
        }

        // Check transaction status untuk mendapatkan status terbaru
        $status = $this->duitkuService->checkTransactionStatus($pembayaran);

        if ($status['statusCode'] === '00') {
            return redirect()->route('filament.admin.pages.dashboard')
                ->with('success', 'Pembayaran berhasil! Silahkan tunggu verifikasi sampel dari petugas.');
        } elseif ($status['statusCode'] === '01') {
            return redirect()->route('payment.show', $pembayaran->permohonan)
                ->with('warning', 'Pembayaran masih dalam proses');
        } else {
            return redirect()->route('payment.show', $pembayaran->permohonan)
                ->with('error', 'Pembayaran gagal atau dibatalkan');
        }
    }

    /**
     * Lihat riwayat pembayaran untuk permohonan
     */
    public function history(Permohonan $permohonan)
    {
        // Authorization check
        if (Auth::user()->id !== $permohonan->user_id) {
            abort(403, 'Anda tidak memiliki akses');
        }

        $pembayarans = Pembayaran::where('permohonan_id', $permohonan->id)
            ->orderByDesc('created_at')
            ->get();

        return view('payment.history', [
            'permohonan' => $permohonan,
            'pembayarans' => $pembayarans,
        ]);
    }

    /**
     * Download invoice pembayaran
     */
    public function invoice(Pembayaran $pembayaran)
    {
        // Authorization check
        if (Auth::user()->id !== $pembayaran->user_id) {
            abort(403, 'Anda tidak memiliki akses');
        }

        // Generate PDF invoice
        return view('payment.invoice', [
            'pembayaran' => $pembayaran,
            'permohonan' => $pembayaran->permohonan,
        ]);
    }
}
