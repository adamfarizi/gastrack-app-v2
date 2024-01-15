<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class LaporanController extends Controller
{
    public function index()
    {
        $title = 'Laporan';

        $transaksis = Transaksi::with('pelanggan', 'pesanan')->get();

        return view('auth.laporan.laporan', compact('transaksis', 'title'));
    }
}