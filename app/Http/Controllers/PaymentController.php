<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Permohonan;
use App\Services\DuitkuPaymentService;
use App\Services\NotaPembayaranService;
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
     * 
     * IMPORTANT: Kita TRUST parameter dari return URL lebih daripada API check
     * Karena Duitku mengirim return URL langsung dari server pembayaran (lebih akurat)
     * Sementara API check mungkin ada delay propagation
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

        // Log return URL parameter
        Log::info('Payment Return URL Called', [
            'merchantOrderId' => $merchantOrderId,
            'resultCode' => $resultCode,
            'reference' => $reference,
            'pembayaran_id' => $pembayaran->id,
        ]);

        // STRATEGY: Trust return URL parameter lebih daripada API check
        // Return URL datang langsung dari Duitku payment server (real-time)
        // Sementara API check mungkin ada delay
        
        if ($resultCode === '00') {
            // ✅ PAYMENT SUCCESSFUL - dari parameter return URL
            $pembayaran->update([
                'status' => 'success',
                'result_code' => '00',
                'duitku_reference' => $reference,
                'paid_at' => now(),
            ]);

            // Update permohonan is_paid status
            $pembayaran->permohonan->update(['is_paid' => true]);

            Log::info('Payment marked as success via return URL parameter', [
                'pembayaran_id' => $pembayaran->id,
                'reference' => $reference,
                'resultCode' => $resultCode,
            ]);

            return redirect()->route('filament.admin.pages.dashboard')
                ->with('success', 'Pembayaran berhasil! Silahkan tunggu verifikasi sampel dari petugas.');
        } elseif ($resultCode === '01') {
            // ⏳ PAYMENT PENDING
            Log::info('Payment still pending', [
                'pembayaran_id' => $pembayaran->id,
                'resultCode' => $resultCode,
            ]);

            return redirect()->route('payment.show', $pembayaran->permohonan)
                ->with('warning', 'Pembayaran masih dalam proses. Tunggu beberapa saat kemudian coba lagi.');
        } else {
            // ❌ PAYMENT FAILED - dari return URL parameter
            $pembayaran->update([
                'status' => 'failed',
                'result_code' => $resultCode ?? '02',
                'duitku_reference' => $reference,
            ]);

            Log::warning('Payment failed via return URL parameter', [
                'pembayaran_id' => $pembayaran->id,
                'resultCode' => $resultCode,
                'reference' => $reference,
            ]);

            return redirect()->route('payment.show', $pembayaran->permohonan)
                ->with('error', 'Pembayaran gagal atau dibatalkan. Silahkan coba lagi atau gunakan metode pembayaran lain.');
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

    /**
     * Download nota pembayaran PDF
     */
    public function downloadNota(Pembayaran $pembayaran)
    {
        // Authorization check - user dapat download nota miliknya sendiri
        if (Auth::user()->id !== $pembayaran->user_id && !Auth::user()->hasAnyRole(['Admin', 'Petugas'])) {
            abort(403, 'Anda tidak memiliki akses untuk download nota ini');
        }

        // Generate dan download PDF nota pembayaran
        $pdf = NotaPembayaranService::generatePdf($pembayaran);
        $filename = 'NOTA-' . $pembayaran->merchant_order_id . '.pdf';

        return $pdf->download($filename);
    }
}
