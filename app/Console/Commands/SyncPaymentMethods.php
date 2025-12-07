<?php

namespace App\Console\Commands;

use App\Models\Pembayaran;
use App\Services\DuitkuPaymentService;
use Illuminate\Console\Command;

class SyncPaymentMethods extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:sync-methods {amount=100000 : Amount untuk fetch payment methods}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi payment methods dari Duitku ke database';

    /**
     * Execute the console command.
     */
    public function handle(DuitkuPaymentService $duitkuService): int
    {
        $amount = (int)$this->argument('amount');

        $this->info("Sinkronisasi payment methods untuk amount: Rp " . number_format($amount, 0, ',', '.'));

        if ($duitkuService->syncPaymentMethods($amount)) {
            $this->info('✓ Sinkronisasi berhasil!');
            return Command::SUCCESS;
        } else {
            $this->error('✗ Sinkronisasi gagal. Check logs untuk detail error.');
            return Command::FAILURE;
        }
    }
}
