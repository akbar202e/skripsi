<?php

namespace Database\Seeders;

use App\Models\JenisPengujian;
use Illuminate\Database\Seeder;

class JenisPengujianSeeder extends Seeder
{
    public function run(): void
    {
        $jenisPengujian = [
            ['nama_pengujian' => 'Analisis Saringan Agregat Kasar / Halus', 'biaya' => 60000, 'deskripsi' => 'Pengujian analisis saringan agregat kasar atau halus'],
            ['nama_pengujian' => 'DMF Agregat Base A', 'biaya' => 1500000, 'deskripsi' => 'Desain campuran untuk agregat Base A'],
            ['nama_pengujian' => 'DMF Agregat Base B', 'biaya' => 1500000, 'deskripsi' => 'Desain campuran untuk agregat Base B'],
            ['nama_pengujian' => 'DMF Lapis Pondasi Tanpa Penutup Aspal', 'biaya' => 1500000, 'deskripsi' => 'Desain campuran lapis pondasi tanpa penutup aspal'],
            ['nama_pengujian' => 'DMF Agregat S', 'biaya' => 1500000, 'deskripsi' => 'Desain campuran agregat S'],
            ['nama_pengujian' => 'DMF BETON', 'biaya' => 1500000, 'deskripsi' => 'Desain campuran beton'],
            ['nama_pengujian' => 'DMF HRS BASE', 'biaya' => 1500000, 'deskripsi' => 'Desain campuran HRS Base'],
            ['nama_pengujian' => 'DMF HRS WC', 'biaya' => 1500000, 'deskripsi' => 'Desain campuran HRS WC'],
            ['nama_pengujian' => 'DMF AC WC', 'biaya' => 1500000, 'deskripsi' => 'Desain campuran Asphalt Concrete Wearing Course'],
            ['nama_pengujian' => 'DMF AC BC', 'biaya' => 1500000, 'deskripsi' => 'Desain campuran Asphalt Concrete Binder Course'],
            ['nama_pengujian' => 'DMF AC BASE', 'biaya' => 1500000, 'deskripsi' => 'Desain campuran Asphalt Concrete Base'],
            ['nama_pengujian' => 'DMF Latasir', 'biaya' => 1500000, 'deskripsi' => 'Desain campuran Latasir'],
            ['nama_pengujian' => 'DMF CTB', 'biaya' => 1500000, 'deskripsi' => 'Desain campuran CTB'],
            ['nama_pengujian' => 'DMF CTSB', 'biaya' => 1500000, 'deskripsi' => 'Desain campuran CTSB'],
            ['nama_pengujian' => 'DMF CTRB', 'biaya' => 1500000, 'deskripsi' => 'Desain campuran CTRB'],
            ['nama_pengujian' => 'DMF CTRSB', 'biaya' => 1500000, 'deskripsi' => 'Desain campuran CTRSB'],
            ['nama_pengujian' => 'DMF SOIL CEMENT', 'biaya' => 1500000, 'deskripsi' => 'Desain campuran soil cement'],
            ['nama_pengujian' => 'Kuat Tekan Paving Block', 'biaya' => 36000, 'deskripsi' => 'Pengujian kuat tekan paving block'],
            ['nama_pengujian' => 'Pengujian Kuat Tekan UCS', 'biaya' => 48000, 'deskripsi' => 'Pengujian kuat tekan UCS'],
            ['nama_pengujian' => 'Pengujian Kuat Tekan CTB', 'biaya' => 48000, 'deskripsi' => 'Pengujian kuat tekan CTB'],
            ['nama_pengujian' => 'Pengujian Kuat Tekan CTRB', 'biaya' => 48000, 'deskripsi' => 'Pengujian kuat tekan CTRB'],
            ['nama_pengujian' => 'DMF Sifat Fisis Aspal', 'biaya' => 1500000, 'deskripsi' => 'Desain campuran dan sifat fisis aspal'],
            ['nama_pengujian' => 'DMF Tanah Timbunan', 'biaya' => 1250000, 'deskripsi' => 'Desain campuran tanah timbunan'],
            ['nama_pengujian' => 'Marshall', 'biaya' => 60000, 'deskripsi' => 'Pengujian Marshall'],
            ['nama_pengujian' => 'Pengujian Abrasi', 'biaya' => 90000, 'deskripsi' => 'Pengujian keausan agregat (Abrasi)'],
            ['nama_pengujian' => 'Pengujian Berat Jenis Agregat / Tanah', 'biaya' => 60000, 'deskripsi' => 'Pengujian berat jenis agregat atau tanah'],
            ['nama_pengujian' => 'Pengujian Berat Jenis Agregat Kasar / Halus', 'biaya' => 60000, 'deskripsi' => 'Pengujian berat jenis agregat kasar atau halus'],
            ['nama_pengujian' => 'Pengujian Berat Jenis Campuran / Density Aspal', 'biaya' => 78000, 'deskripsi' => 'Pengujian berat jenis campuran atau density aspal'],
            ['nama_pengujian' => 'Pengujian Bor Mesin', 'biaya' => 250000, 'deskripsi' => 'Pengujian bor mesin'],
            ['nama_pengujian' => 'Pengujian CBR Lapangan', 'biaya' => 96000, 'deskripsi' => 'Pengujian CBR lapangan'],
            ['nama_pengujian' => 'Pengujian Core Drill Aspal', 'biaya' => 118320, 'deskripsi' => 'Pengujian core drill aspal'],
            ['nama_pengujian' => 'Pengujian Core Drill Beton', 'biaya' => 118320, 'deskripsi' => 'Pengujian core drill beton'],
            ['nama_pengujian' => 'Pengujian Cutting Blok Core Aspal', 'biaya' => 341400, 'deskripsi' => 'Pengujian cutting block core aspal'],
            ['nama_pengujian' => 'Pengujian DCP', 'biaya' => 78000, 'deskripsi' => 'Pengujian Dynamic Cone Penetrometer'],
            ['nama_pengujian' => 'Pengujian Ekstraksi', 'biaya' => 300000, 'deskripsi' => 'Pengujian ekstraksi'],
            ['nama_pengujian' => 'Pengujian Hammer Test', 'biaya' => 72000, 'deskripsi' => 'Pengujian hammer test'],
            ['nama_pengujian' => 'Pengujian Kadar Air', 'biaya' => 36000, 'deskripsi' => 'Pengujian kadar air sampel'],
            ['nama_pengujian' => 'Pengujian Kepadatan Mutlak', 'biaya' => 108000, 'deskripsi' => 'Pengujian kepadatan mutlak'],
            ['nama_pengujian' => 'Pengujian Kuat Tarik Baja', 'biaya' => 120000, 'deskripsi' => 'Pengujian kuat tarik baja'],
            ['nama_pengujian' => 'Pengujian Kuat Tekan / Lentur Beton', 'biaya' => 36000, 'deskripsi' => 'Pengujian kuat tekan atau lentur beton'],
            ['nama_pengujian' => 'Pengujian Lendutan Benkelman Beam', 'biaya' => 120000, 'deskripsi' => 'Pengujian lendutan Benkelman Beam'],
            ['nama_pengujian' => 'Pengujian LWD', 'biaya' => 120000, 'deskripsi' => 'Pengujian Lightweight Deflectometer'],
            ['nama_pengujian' => 'Pengujian PDA Test', 'biaya' => 3000000, 'deskripsi' => 'Pengujian PDA (Pile Driving Analyzer)'],
            ['nama_pengujian' => 'Pengujian Sandcone', 'biaya' => 84000, 'deskripsi' => 'Pengujian sandcone'],
            ['nama_pengujian' => 'Pengujian Sondir', 'biaya' => 360000, 'deskripsi' => 'Pengujian sondir'],
            ['nama_pengujian' => 'Uji Material', 'biaya' => 1250000, 'deskripsi' => 'Uji material konstruksi'],
        ];

        foreach ($jenisPengujian as $pengujian) {
            JenisPengujian::create($pengujian);
        }
    }
}
