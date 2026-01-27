<?php

namespace App\Http\Controllers;

use App\Models\JenisPengujian;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua jenis pengujian dari database
        $jenisPengujian = JenisPengujian::orderBy('nama_pengujian')->get();

        return view('homepage', ['jenisPengujian' => $jenisPengujian]);
    }
}
