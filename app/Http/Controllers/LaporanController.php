<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Models\Transaksi;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'Laporan';

        $perPage_penjualan = $request->input('perPage_penjualan', 10);
        $detail_penjualans = Pesanan::with(['transaksi', 'transaksi.pelanggan', 'transaksi.tagihan'])
        ->paginate($perPage_penjualan, ['*'], 'detail_penjualans');

        $perPage_omzet = $request->input('perPage_omzet', 10);
        $laporan_omzet = Pesanan::with(['transaksi', 'transaksi.pelanggan'])
        ->paginate($perPage_omzet, ['*'], 'laporan_omzet');

        $perPage_bop = $request->input('perPage_bop', 10);
        $total_omzet = Pesanan::sum('harga_pesanan');
        $laporan_bop = Pengiriman::with(['pesanan', 'pesanan.transaksi.pelanggan'])
        ->paginate($perPage_bop, ['*'], 'laporan_bop');

        return view('auth.laporan.laporan',[
            'detail_penjualans' => $detail_penjualans,
            'laporan_omzet' => $laporan_omzet,
            'total_omzet' => $total_omzet,
            'laporan_bop' => $laporan_bop,
            'perPage_penjualan' => $perPage_penjualan,  
            'perPage_omzet' => $perPage_omzet,  
            'perPage_bop' => $perPage_bop,  
        ], $data);
    }
}