<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

class QrCodeController extends Controller
{
    /**
     * Tampilkan halaman print QR code sampel
     */
    public function printQrCode(Permohonan $permohonan)
{
    // Langsung ambil Data URI di akhir chain
    $qrCodeBase64 = Builder::create()
        ->writer(new PngWriter())
        ->data($permohonan->sample_code)
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(ErrorCorrectionLevel::High)
        ->size(300)
        ->margin(10)
        ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
        ->build()
        ->getDataUri(); // Ambil string-nya di sini

    return view('permohonan.print-qr-code', [
        'permohonan'   => $permohonan,
        'qrCodeBase64' => $qrCodeBase64,
    ]);
}
}
