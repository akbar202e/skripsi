<?php

namespace App\Console\Commands;

use App\Models\Pembayaran;
use App\Services\DuitkuPaymentService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckPendingPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:check-pending {--limit=50 : Batas jumlah pembayaran yang akan di-check} {--retry=2 : Jumlah retry jika status tidak konsisten} {--delay=2 : Delay dalam detik antara pembayaran}';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Check status pembayaran pending ke Duitku API dan update status jika diperlukan';

    private DuitkuPaymentService $duitkuService;

    /**
     * Create a new command instance.
     */
    public function __construct(DuitkuPaymentService $duitkuService)
    {
        parent::__construct();
        $this->duitkuService = $duitkuService;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $limit = (int) $this->option('limit');
        $maxRetry = (int) $this->option('retry');
        $delaySeconds = (int) $this->option('delay');

        $this->info("Checking pending payments (limit: {$limit}, retry: {$maxRetry}, delay: {$delaySeconds}s)...");

        // Get pending payments yang dibuat dalam 24 jam terakhir
        $pendingPayments = Pembayaran::where('status', 'pending')
            ->where('created_at', '>=', now()->subHours(24))
            ->orderBy('created_at', 'asc')
            ->limit($limit)
            ->get();

        if ($pendingPayments->isEmpty()) {
            $this->info('No pending payments found.');
            return Command::SUCCESS;
        }

        $this->info("Found {$pendingPayments->count()} pending payments. Checking status...");

        $successCount = 0;
        $failedCount = 0;
        $stillPendingCount = 0;

        foreach ($pendingPayments as $pembayaran) {
            try {
                $statusCode = null;
                $statusData = null;
                
                // Try to get status with retry logic
                for ($attempt = 1; $attempt <= $maxRetry; $attempt++) {
                    $status = $this->duitkuService->checkTransactionStatus($pembayaran);
                    $statusCode = $status['statusCode'] ?? null;
                    $statusData = $status;

                    Log::info('Payment Status Check Attempt', [
                        'pembayaran_id' => $pembayaran->id,
                        'merchant_order_id' => $pembayaran->merchant_order_id,
                        'attempt' => $attempt,
                        'statusCode' => $statusCode,
                    ]);

                    if ($statusCode === '00') {
                        // Success found, break retry loop
                        break;
                    } elseif ($statusCode === '01' && $attempt < $maxRetry) {
                        // Still pending, retry after delay
                        $this->line("  Pembayaran #{$pembayaran->id} masih pending, retry dalam {$delaySeconds}s...");
                        sleep($delaySeconds);
                    }
                }

                if (isset($statusCode)) {
                    if ($statusCode === '00') {
                        // Payment successful
                        $pembayaran->update([
                            'status' => 'success',
                            'result_code' => '00',
                            'duitku_reference' => $statusData['reference'] ?? $pembayaran->duitku_reference,
                            'paid_at' => now(),
                        ]);

                        // Update permohonan
                        $pembayaran->permohonan->update(['is_paid' => true]);

                        $this->line("✓ Payment #{$pembayaran->id} marked as SUCCESS");
                        $successCount++;

                        Log::info('Payment marked as success', ['pembayaran_id' => $pembayaran->id]);
                    } elseif ($statusCode === '01') {
                        // Still pending after all retries
                        $this->line("⏳ Payment #{$pembayaran->id} still PENDING (after {$maxRetry} attempts)");
                        $stillPendingCount++;
                    } else {
                        // Failed or other status
                        $pembayaran->update([
                            'status' => 'failed',
                            'result_code' => $statusCode,
                            'duitku_reference' => $statusData['reference'] ?? $pembayaran->duitku_reference,
                        ]);

                        $this->line("✗ Payment #{$pembayaran->id} marked as FAILED (code: {$statusCode})");
                        $failedCount++;

                        Log::warning('Payment marked as failed', [
                            'pembayaran_id' => $pembayaran->id,
                            'statusCode' => $statusCode
                        ]);
                    }
                }
            } catch (\Exception $e) {
                $this->line("⚠ Error checking payment #{$pembayaran->id}: {$e->getMessage()}");
                $stillPendingCount++;

                Log::error('Error checking payment status', [
                    'pembayaran_id' => $pembayaran->id,
                    'message' => $e->getMessage(),
                ]);
            }

            // Small delay between checks
            usleep(100000); // 0.1 second
        }

        // Summary
        $this->newLine();
        $this->info('=== SUMMARY ===');
        $this->line("✓ Success: {$successCount}");
        $this->line("✗ Failed: {$failedCount}");
        $this->line("⏳ Still Pending: {$stillPendingCount}");
        $this->info("Total checked: {$pendingPayments->count()}");

        return Command::SUCCESS;
    }
}
