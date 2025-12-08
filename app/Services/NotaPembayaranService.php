<?php

namespace App\Services;

use App\Models\Pembayaran;
use Barryvdh\DomPDF\Facade\Pdf;

class NotaPembayaranService
{
    /**
     * Generate nota pembayaran PDF
     */
    public static function generatePdf(Pembayaran $pembayaran): \Barryvdh\DomPDF\PDF
    {
        $data = [
            'pembayaran' => $pembayaran,
            'permohonan' => $pembayaran->permohonan,
            'user' => $pembayaran->user,
            'nomorNota' => $pembayaran->merchant_order_id,
            'tanggal' => $pembayaran->paid_at ? $pembayaran->paid_at->format('d M Y') : now()->format('d M Y'),
            'pemohon' => $pembayaran->user->name,
            'pekerjaan' => $pembayaran->permohonan->judul,
            'metode' => $pembayaran->payment_method_name ?? $pembayaran->payment_method ?? '-',
            'jumlahBayar' => $pembayaran->amount,
            'totalKeseluruhan' => $pembayaran->amount,
        ];

        return Pdf::loadView('payment.nota-pdf', $data)
            ->setPaper('a4')
            ->setOption('margin-top', 10)
            ->setOption('margin-right', 10)
            ->setOption('margin-bottom', 10)
            ->setOption('margin-left', 10);
    }
}
