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
        $permohonan = $pembayaran->permohonan;
        
        // Get jenis pengujian dengan pivot data (jumlah_sampel)
        $jenisPengujians = $permohonan->jenisPengujians()->get();
        
        // Hitung total dari jenis pengujian
        $totalAmount = 0;
        foreach ($jenisPengujians as $pengujian) {
            $qty = $pengujian->pivot->jumlah_sampel ?? 1;
            $totalAmount += ($pengujian->biaya * $qty);
        }
        
        $data = [
            'pembayaran' => $pembayaran,
            'permohonan' => $permohonan,
            'user' => $pembayaran->user,
            'nomorNota' => $pembayaran->merchant_order_id,
            'tanggal' => $pembayaran->paid_at ? $pembayaran->paid_at->format('d M Y') : now()->format('d M Y'),
            'pemohon' => $pembayaran->user->name,
            'pekerjaan' => $permohonan->isi, // Gunakan field 'isi'
            'metode' => $pembayaran->payment_method_name ?? $pembayaran->payment_method ?? '-',
            'jenisPengujians' => $jenisPengujians,
            'jumlahBayar' => $pembayaran->amount,
            'totalKeseluruhan' => $totalAmount > 0 ? $totalAmount : $pembayaran->amount,
        ];

        return Pdf::loadView('payment.nota-pdf', $data)
            ->setPaper('a4')
            ->setOption('margin-top', 10)
            ->setOption('margin-right', 10)
            ->setOption('margin-bottom', 10)
            ->setOption('margin-left', 10);
    }
}
