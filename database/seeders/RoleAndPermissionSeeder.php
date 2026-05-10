<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create role Pimpinan if not exists
        $pimpinanRole = Role::firstOrCreate(
            ['name' => 'Pimpinan', 'guard_name' => 'web'],
            ['name' => 'Pimpinan', 'guard_name' => 'web']
        );

        // Create role Admin if not exists
        $adminRole = Role::firstOrCreate(
            ['name' => 'Admin', 'guard_name' => 'web'],
            ['name' => 'Admin', 'guard_name' => 'web']
        );

        // Create role Petugas if not exists
        $petugasRole = Role::firstOrCreate(
            ['name' => 'Petugas', 'guard_name' => 'web'],
            ['name' => 'Petugas', 'guard_name' => 'web']
        );

        // Create role Pemohon if not exists
        $pemohonRole = Role::firstOrCreate(
            ['name' => 'Pemohon', 'guard_name' => 'web'],
            ['name' => 'Pemohon', 'guard_name' => 'web']
        );

        // Create sample Pimpinan user if not exists
        if (!User::where('email', 'pimpinan@example.com')->exists()) {
            $pimpinanUser = User::create([
                'name' => 'Pimpinan UPT2',
                'email' => 'pimpinan@example.com',
                'password' => Hash::make('123'),
                'instansi' => 'UPT2',
                'no_hp' => '0821987654',
                'email_verified_at' => now(),
            ]);

            // Assign Pimpinan role
            $pimpinanUser->assignRole($pimpinanRole);

            $this->command->info('Pimpinan user created with email: pimpinan@example.com');
        }

        $this->command->info('Roles created successfully!');
    }
}
