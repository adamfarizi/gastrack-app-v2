<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Models\Transaksi;

class LaporanController extends Controller
{
    public function index()
    {
        $data['title'] = 'Laporan';

        $transaksis = Transaksi::with('pelanggan', 'pesanan')->get();
        $pesanans = Pesanan::with('transaksi')->get();
        $pengirimans = Pengiriman::with('pesanan', 'sopir', 'mobil')->get();
        $total_omzet = Pesanan::sum('harga_pesanan');

        return view('auth.laporan.laporan',[
            'transaksis' => $transaksis,
            'pesanans' => $pesanans,
            'pengirimans' => $pengirimans,
            'total_omzet' => $total_omzet,
        ], $data);
    }
}