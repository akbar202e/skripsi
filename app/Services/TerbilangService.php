<?php

namespace App\Services;

class TerbilangService
{
    private static array $angka = [
        '',
        'satu',
        'dua',
        'tiga',
        'empat',
        'lima',
        'enam',
        'tujuh',
        'delapan',
        'sembilan'
    ];

    private static array $tingkat = [
        'puluh',
        'ratus',
        'ribu',
        'puluh ribu',
        'ratus ribu',
        'juta',
        'puluh juta',
        'ratus juta',
        'miliar',
        'puluh miliar',
        'ratus miliar',
        'triliun',
        'puluh triliun',
        'ratus triliun'
    ];

    /**
     * Convert number to terbilang (words in Indonesian)
     */
    public static function toTerbilang(int $num): string
    {
        if ($num == 0) {
            return 'nol';
        }

        $str = '';
        $tingkat_idx = 0;

        while ($num > 0) {
            $angka_idx = $num % 10;

            if ($angka_idx != 0) {
                $str = self::$angka[$angka_idx] . ' ' . (isset(self::$tingkat[$tingkat_idx]) ? self::$tingkat[$tingkat_idx] : '') . ' ' . $str;
            }

            $num = (int)($num / 10);
            $tingkat_idx++;
        }

        return trim(str_replace('  ', ' ', $str));
    }

    /**
     * Format nominal ke terbilang lengkap
     */
    public static function format(int $num): string
    {
        return ucfirst(self::toTerbilang($num)) . ' Rupiah';
    }
}
