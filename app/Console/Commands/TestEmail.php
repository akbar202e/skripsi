<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email {email} {--otp=123456}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email OTP functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $otp = $this->option('otp');

        $this->info("Sending OTP {$otp} to {$email}...");

        try {
            \App\Services\OtpService::sendOtp($email, $otp);
            $this->info('Email sent successfully!');
        } catch (\Exception $e) {
            $this->error('Failed to send email: ' . $e->getMessage());
        }
    }
}
