<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use Illuminate\Http\Request;

class DokumenController extends Controller
{
    /**
     * Display a listing of the dokumen
     */
    public function index()
    {
        $kategori = request('kategori');
        $query = Dokumen::query();

        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        $dokumens = $query->paginate(12);

        return view('dokumen.index', compact('dokumens', 'kategori'));
    }

    /**
     * Display the specified dokumen with Pan & Zoom
     */
    public function show(Dokumen $dokumen)
    {
        return view('dokumen.show', compact('dokumen'));
    }
}
