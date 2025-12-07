<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [
            // Virtual Account
            ['payment_method' => 'BC', 'payment_name' => 'BCA Virtual Account', 'total_fee' => 0],
            ['payment_method' => 'M2', 'payment_name' => 'Mandiri Virtual Account', 'total_fee' => 0],
            ['payment_method' => 'VA', 'payment_name' => 'Maybank Virtual Account', 'total_fee' => 0],
            ['payment_method' => 'I1', 'payment_name' => 'BNI Virtual Account', 'total_fee' => 0],
            ['payment_method' => 'B1', 'payment_name' => 'CIMB Niaga Virtual Account', 'total_fee' => 0],
            ['payment_method' => 'BT', 'payment_name' => 'Permata Bank Virtual Account', 'total_fee' => 0],
            ['payment_method' => 'DM', 'payment_name' => 'Danamon Virtual Account', 'total_fee' => 0],
            ['payment_method' => 'BV', 'payment_name' => 'BSI Virtual Account', 'total_fee' => 0],

            // Kartu Kredit
            ['payment_method' => 'VC', 'payment_name' => 'Kartu Kredit (Visa/Mastercard/JCB)', 'total_fee' => 0],

            // E-Wallet
            ['payment_method' => 'OV', 'payment_name' => 'OVO', 'total_fee' => 0],
            ['payment_method' => 'SA', 'payment_name' => 'ShopeePay Apps', 'total_fee' => 0],
            ['payment_method' => 'DA', 'payment_name' => 'DANA', 'total_fee' => 0],
            ['payment_method' => 'LF', 'payment_name' => 'LinkAja Apps (Fixed Fee)', 'total_fee' => 0],
            ['payment_method' => 'LA', 'payment_name' => 'LinkAja Apps (Percentage Fee)', 'total_fee' => 0],

            // QRIS
            ['payment_method' => 'SP', 'payment_name' => 'ShopeePay (QRIS)', 'total_fee' => 0],
            ['payment_method' => 'NQ', 'payment_name' => 'Nobu (QRIS)', 'total_fee' => 0],
            ['payment_method' => 'GQ', 'payment_name' => 'Gudang Voucher (QRIS)', 'total_fee' => 0],
            ['payment_method' => 'SQ', 'payment_name' => 'Nusapay (QRIS)', 'total_fee' => 0],

            // Paylater
            ['payment_method' => 'DN', 'payment_name' => 'Indodana Paylater', 'total_fee' => 0],
            ['payment_method' => 'AT', 'payment_name' => 'ATOME Paylater', 'total_fee' => 0],

            // E-Banking
            ['payment_method' => 'JP', 'payment_name' => 'Jenius Pay', 'total_fee' => 0],
        ];

        foreach ($methods as $method) {
            PaymentMethod::updateOrCreate(
                ['payment_method' => $method['payment_method']],
                [
                    'payment_name' => $method['payment_name'],
                    'total_fee' => $method['total_fee'],
                    'is_active' => true,
                ]
            );
        }

        $this->command->info('Payment methods seeded successfully!');
    }
}
