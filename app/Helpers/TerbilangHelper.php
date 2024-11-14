<?php

namespace App\Helpers;

class TerbilangHelper
{
    public static function terbilang($angka)
    {
        $huruf = array(
            0 => 'Nol', 1 => 'Satu', 2 => 'Dua', 3 => 'Tiga', 4 => 'Empat', 5 => 'Lima', 6 => 'Enam', 7 => 'Tujuh',
            8 => 'Delapan', 9 => 'Sembilan', 10 => 'Sepuluh', 11 => 'Sebelas', 12 => 'Dua Belas', 13 => 'Tiga Belas',
            14 => 'Empat Belas', 15 => 'Lima Belas', 16 => 'Enam Belas', 17 => 'Tujuh Belas', 18 => 'Delapan Belas',
            19 => 'Sembilan Belas', 20 => 'Dua Puluh', 30 => 'Tiga Puluh', 40 => 'Empat Puluh', 50 => 'Lima Puluh',
            60 => 'Enam Puluh', 70 => 'Tujuh Puluh', 80 => 'Delapan Puluh', 90 => 'Sembilan Puluh'
        );
        
        if ($angka < 21) {
            return $huruf[$angka];
        } elseif ($angka < 100) {
            $belasan = $angka % 10;
            $puluhan = floor($angka / 10) * 10;
            return $huruf[$puluhan] . ' ' . $huruf[$belasan];
        } elseif ($angka < 200) {
            return 'Seratus ' . self::terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $ratusan = floor($angka / 100);
            $sisa = $angka % 100;
            if ($sisa > 0) {
                return $huruf[$ratusan] . ' Ratus ' . self::terbilang($sisa);
            } else {
                return $huruf[$ratusan] . ' Ratus';
            }
        } elseif ($angka < 1000000) {
            $ribuan = floor($angka / 1000);
            $sisa = $angka % 1000;
            if ($sisa > 0) {
                return self::terbilang($ribuan) . ' Ribu ' . self::terbilang($sisa);
            } else {
                return self::terbilang($ribuan) . ' Ribu';
            }
        } elseif ($angka < 1000000000) {
            $jutaan = floor($angka / 1000000);
            $sisa = $angka % 1000000;
            if ($sisa > 0) {
                return self::terbilang($jutaan) . ' Juta ' . self::terbilang($sisa);
            } else {
                return self::terbilang($jutaan) . ' Juta';
            }
        } else {
            return 'Angka terlalu besar';
        }
    }
}
