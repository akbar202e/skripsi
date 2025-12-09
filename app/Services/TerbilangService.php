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

    /**
     * Convert number to terbilang (words in Indonesian)
     */
    public static function toTerbilang(int $num): string
    {
        if ($num == 0) {
            return 'nol';
        }

        $result = '';
        
        // Triliun
        if ($num >= 1000000000000) {
            $triliun = (int)($num / 1000000000000);
            $result .= self::convertBelowThousand($triliun) . ' triliun ';
            $num %= 1000000000000;
        }
        
        // Miliar
        if ($num >= 1000000000) {
            $miliar = (int)($num / 1000000000);
            $result .= self::convertBelowThousand($miliar) . ' miliar ';
            $num %= 1000000000;
        }
        
        // Juta
        if ($num >= 1000000) {
            $juta = (int)($num / 1000000);
            $result .= self::convertBelowThousand($juta) . ' juta ';
            $num %= 1000000;
        }
        
        // Ribu
        if ($num >= 1000) {
            $ribu = (int)($num / 1000);
            $result .= self::convertBelowThousand($ribu) . ' ribu ';
            $num %= 1000;
        }
        
        // Satuan
        if ($num > 0) {
            $result .= self::convertBelowThousand($num) . ' ';
        }
        
        return trim(str_replace('  ', ' ', $result));
    }
    
    /**
     * Convert number below 1000
     */
    private static function convertBelowThousand(int $num): string
    {
        if ($num == 0) {
            return '';
        }
        
        $result = '';
        
        // Ratus
        $hundreds = (int)($num / 100);
        if ($hundreds > 0) {
            if ($hundreds == 1) {
                $result .= 'seratus';
            } else {
                $result .= self::$angka[$hundreds] . ' ratus';
            }
        }
        
        $num %= 100;
        
        if ($num > 0) {
            if ($result !== '') {
                $result .= ' ';
            }
            
            if ($num < 10) {
                // Satuan 1-9
                $result .= self::$angka[$num];
            } elseif ($num < 20) {
                // 10-19
                $tens = $num - 10;
                if ($tens == 0) {
                    $result .= 'sepuluh';
                } elseif ($tens == 1) {
                    $result .= 'sebelas';
                } else {
                    $result .= self::$angka[$tens] . ' belas';
                }
            } else {
                // 20-99
                $tens = (int)($num / 10);
                $ones = $num % 10;
                $result .= self::$angka[$tens] . ' puluh';
                if ($ones > 0) {
                    $result .= ' ' . self::$angka[$ones];
                }
            }
        }
        
        return trim($result);
    }

    /**
     * Format nominal ke terbilang lengkap
     */
    public static function format(int $num): string
    {
        return ucfirst(self::toTerbilang($num)) . ' Rupiah';
    }
}
