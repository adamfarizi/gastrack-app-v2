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

        $detail_penjualans = Pesanan::with(['transaksi', 'transaksi.pelanggan', 'transaksi.tagihan'])
        ->paginate(10, ['*'], 'detail_penjualans');
        $laporan_omzet = Pesanan::with(['transaksi', 'transaksi.pelanggan'])
        ->paginate(10, ['*'], 'laporan_omzet');
        $total_omzet = Pesanan::sum('harga_pesanan');
        $laporan_bop = Pengiriman::with(['pesanan', 'pesanan.transaksi.pelanggan'])
        ->paginate(10, ['*'], 'laporan_bop');

        return view('auth.laporan.laporan',[
            'detail_penjualans' => $detail_penjualans,
            'laporan_omzet' => $laporan_omzet,
            'total_omzet' => $total_omzet,
            'laporan_bop' => $laporan_bop,
        ], $data);
    }
}