<?php

namespace App\Filament\Widgets;

use App\Models\Dokumen;
use Filament\Widgets\Widget;

class DokumenGrid extends Widget
{
    // Mengatur urutan widget (opsional, sesuaikan dengan kebutuhan)
    protected static ?int $sort = 2;

    // KUNCI PERBAIKAN: Membuat widget mengambil lebar penuh (full width)
    // Ini akan mencegah widget terjepit di separuh layar
    protected int | string | array $columnSpan = 'full';

    protected static string $view = 'filament.widgets.dokumen-grid';

    public function getDokumen()
    {
        return Dokumen::all();
    }

    public function getImageUrl($imagePath)
    {
        if (!$imagePath) {
            // Pastikan Anda memiliki placeholder default atau ganti dengan url gambar statis
            return asset('images/placeholder.jpg'); 
        }

        // Check if it's already a full URL
        if (strpos($imagePath, 'http') === 0) {
            return $imagePath;
        }

        // Return the storage URL
        return asset('storage/' . $imagePath);
    }
}