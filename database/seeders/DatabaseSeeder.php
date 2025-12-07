<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            JenisPengujianSeeder::class,
            PaymentMethodSeeder::class,
        ]);

        // Create Admin user if not exists
        if (!User::where('email', 'admin@example.com')->exists()) {
            $admin = User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('123'),
                'instansi' => 'UPT2',
                'no_hp' => '0812345678',
            ]);

            // Assign Admin role if exists
            if (Role::where('name', 'Admin')->exists()) {
                $admin->assignRole('Admin');
            }
        }
    }
}
