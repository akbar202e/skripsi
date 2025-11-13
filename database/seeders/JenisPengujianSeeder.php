<?php

namespace Database\Seeders;

use App\Models\JenisPengujian;
use Illuminate\Database\Seeder;

class JenisPengujianSeeder extends Seeder
{
    public function run(): void
    {
        $jenisPengujian = [
            [
                'nama_pengujian' => 'Pengujian Kadar Air',
                'biaya' => 150000,
                'deskripsi' => 'Pengujian untuk menentukan kadar air dalam sampel'
            ],
            [
                'nama_pengujian' => 'Pengujian pH',
                'biaya' => 100000,
                'deskripsi' => 'Pengujian tingkat keasaman sampel'
            ],
            [
                'nama_pengujian' => 'Pengujian Protein',
                'biaya' => 200000,
                'deskripsi' => 'Pengujian kandungan protein dalam sampel'
            ],
            [
                'nama_pengujian' => 'Pengujian Lemak',
                'biaya' => 200000,
                'deskripsi' => 'Pengujian kandungan lemak dalam sampel'
            ],
            [
                'nama_pengujian' => 'Pengujian Karbohidrat',
                'biaya' => 250000,
                'deskripsi' => 'Pengujian kandungan karbohidrat dalam sampel'
            ],
        ];

        foreach ($jenisPengujian as $pengujian) {
            JenisPengujian::create($pengujian);
        }
    }
}