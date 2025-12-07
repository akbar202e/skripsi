<?php

namespace App\Console\Commands;

use App\Models\Pembayaran;
use App\Services\DuitkuPaymentService;
use Illuminate\Console\Command;

class CheckPaymentStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:check-status {pembayaran_id : ID pembayaran yang akan dicek}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek status pembayaran di Duitku dan update di database';

    /**
     * Execute the console command.
     */
    public function handle(DuitkuPaymentService $duitkuService): int
    {
        $pembayaranId = (int)$this->argument('pembayaran_id');

        $pembayaran = Pembayaran::find($pembayaranId);

        if (!$pembayaran) {
            $this->error("Pembayaran dengan ID $pembayaranId tidak ditemukan!");
            return Command::FAILURE;
        }

        $this->info("Cek status pembayaran: {$pembayaran->merchant_order_id}");

        $status = $duitkuService->checkTransactionStatus($pembayaran);

        $this->info("Status Code: {$status['statusCode']}");
        $this->info("Status Message: {$status['statusMessage']}");

        if (isset($status['fee'])) {
            $this->info("Fee: Rp " . number_format($status['fee'], 0, ',', '.'));
        }

        // Update pembayaran jika status sukses
        if ($status['statusCode'] === '00') {
            $pembayaran->update([
                'status' => 'success',
                'result_code' => '00',
                'paid_at' => now(),
            ]);

            $pembayaran->permohonan->update(['is_paid' => true]);

            $this->info('✓ Status pembayaran berhasil diupdate ke SUCCESS');
            return Command::SUCCESS;
        } elseif ($status['statusCode'] === '02') {
            $pembayaran->update([
                'status' => 'failed',
                'result_code' => '02',
            ]);

            $this->warn('⚠ Status pembayaran FAILED');
            return Command::SUCCESS;
        } else {
            $this->info('Status pembayaran masih dalam proses (PENDING)');
            return Command::SUCCESS;
        }
    }
}
