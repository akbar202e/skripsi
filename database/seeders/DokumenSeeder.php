<?php

namespace Database\Seeders;

use App\Models\Dokumen;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@gmail.com')->first() ?? User::first();

        if (!$admin) {
            return;
        }

        // Dummy data - images akan di-upload manual via Filament atau bisa diganti dengan sample images
        $dokumens = [
            [
                'judul' => 'SOP Pengujian Kualitas Air',
                'deskripsi' => 'Standar Operasional Prosedur lengkap untuk pengujian kualitas air di laboratorium',
                'kategori' => 'peraturan',
            ],
            [
                'judul' => 'Prosedur Pengambilan Sampel',
                'deskripsi' => 'Panduan lengkap tentang cara pengambilan sampel yang baik dan benar',
                'kategori' => 'peraturan',
            ],
            [
                'judul' => 'Peraturan Keselamatan Kerja',
                'deskripsi' => 'Peraturan dan tata cara keselamatan kerja di laboratorium',
                'kategori' => 'peraturan',
            ],
            [
                'judul' => 'Tahapan Pengujian Fisika',
                'deskripsi' => 'Informasi tentang tahapan lengkap pengujian parameter fisika air',
                'kategori' => 'informasi',
            ],
            [
                'judul' => 'Panduan Alat Laboratorium',
                'deskripsi' => 'Informasi dan panduan penggunaan peralatan laboratorium modern',
                'kategori' => 'informasi',
            ],
            [
                'judul' => 'Sertifikasi dan Akreditasi',
                'deskripsi' => 'Informasi tentang sertifikasi dan akreditasi laboratorium kami',
                'kategori' => 'informasi',
            ],
        ];

        foreach ($dokumens as $dokumen) {
            Dokumen::create([
                'judul' => $dokumen['judul'],
                'deskripsi' => $dokumen['deskripsi'],
                'kategori' => $dokumen['kategori'],
                'image_path' => 'dokumen/placeholder.jpg', // Placeholder - akan diganti user saat upload
                'created_by' => $admin->id,
            ]);
        }
    }
}
