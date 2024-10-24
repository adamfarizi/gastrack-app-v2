<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Gas;
use App\Models\Mobil;
use App\Models\Sopir;
use App\Models\Pesanan;
use App\Models\Tagihan;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use App\Models\Pengiriman;
use App\Events\Chart3Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PengirimanController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'Pengiriman';
        $pesanans = Pesanan::all();
        $transaksis = Transaksi::all();
        $gas = Gas::sum('harga_gas');
        $harga_gas = number_format($gas, 0, ',', '.');
        $pengirimans = Pengiriman::where('status_pengiriman', 'Dikirim')->get();

        $perPage_riwayat = $request->input('perPage_riwayat', 10);
        $riwayat_pengirimans_query = Pengiriman::where('status_pengiriman', 'Diterima')
            ->join('pesanan', 'pesanan.id_pesanan', '=', 'pengiriman.id_pesanan')
            ->with(['pesanan', 'pesanan.transaksi.pelanggan'])
            ->orderBy('waktu_pengiriman', 'desc');

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $tanggal_awal = Carbon::parse($request->tanggal_awal)->startOfDay();
            $tanggal_akhir = Carbon::parse($request->tanggal_akhir)->endOfDay();

            $riwayat_pengirimans_query->whereBetween('pesanan.tanggal_pesanan', [$tanggal_awal, $tanggal_akhir]);
        }

        $riwayat_pengirimans = $riwayat_pengirimans_query->paginate($perPage_riwayat, ['pengiriman.*'], 'riwayat_pengirimans')
            ->appends(request()->query());
        
        // dd($riwayat_pengirimans);

        return view('auth.pengiriman.pengiriman', [
            'pesanans' => $pesanans,
            'transaksis' => $transaksis,
            'harga_gas' => $harga_gas,
            'pengirimans' => $pengirimans,
            'riwayat_pengirimans' => $riwayat_pengirimans,
            'perPage_riwayat' => $perPage_riwayat,
        ], $data);
    }

    public function realtimeData()
    {
        $total_pesanan = Pesanan::count();
        $pesanan_diproses = Pengiriman::where('status_pengiriman', 'Proses')->count();
        $pesanan_dikirim = Pengiriman::where('status_pengiriman', 'Dikirim')->count();

        $prosess = Pengiriman::where('status_pengiriman', 'Proses')
            ->with('pesanan')->orderBy('created_at', 'desc')->get();
        $sopirs = Sopir::where('ketersediaan_sopir', 'tersedia')
            ->where('status_sopir', 'aktif')
            ->get();
        $mobils = Mobil::where('ketersediaan_mobil', 'tersedia')
            ->where('status_mobil', 'aktif')
            ->get();

        $pengirimans = Pengiriman::where('status_pengiriman', 'Dikirim')
            ->with('pesanan')->orderBy('created_at', 'desc')->get();
        $nama_sopir = Sopir::all();
        $nama_mobil = Mobil::all();

        $transaksis = Transaksi::with('pelanggan')->get();

        return response()->json([
            'total_pesanan' => $total_pesanan,
            'pesanan_diproses' => $pesanan_diproses,
            'pesanan_dikirim' => $pesanan_dikirim,
            'prosess' => $prosess,
            'sopirs' => $sopirs,
            'mobils' => $mobils,
            'pengirimans' => $pengirimans,
            'nama_sopir' => $nama_sopir,
            'nama_mobil' => $nama_mobil,
            'transaksis' => $transaksis,
        ]);
    }

    public function updateKirim(Request $request)
    {
        $id_pengiriman = $request->input('id_pengiriman');
        $jumlah_pesanan = $request->input('jumlah_pesanan');
        $sopir = $request->input('id_kurir');
        $mobil = $request->input('id_mobil');

        if ($mobil === 'Belum Memilih' || $sopir === 'Belum Memilih' || $jumlah_pesanan === null) {
            Session::flash('error', 'Jumlah Pesanan, Sopir, dan Mobil harus dipilih!');
            return response()->json(['error' => true]);
        } else {
            $pengiriman = Pengiriman::find($id_pengiriman);
            $pengiriman->status_pengiriman = 'Dikirim';
            $pengiriman->id_sopir = $sopir;
            $pengiriman->id_mobil = $mobil;
            $pengiriman->gas_permintaan = $jumlah_pesanan;
            $pengiriman->save();

            $id_pesanan = $pengiriman->id_pesanan;
            $harga_gas = Gas::sum('harga_gas');
            $pesanan = Pesanan::where('id_pesanan', $id_pesanan)->first();
            // $pesanan->jumlah_bar = $jumlah_pesanan;
            // $pesanan->harga_pesanan = $jumlah_pesanan * $harga_gas;
            // $pesanan->save();

            $id_transaksi = $pesanan->id_transaksi;
            $transaksi = Transaksi::where('id_transaksi', $id_transaksi)->first();
            // $id_tagihan = $transaksi->id_tagihan;
            // $tagihan = Tagihan::where('id_tagihan', $id_tagihan)->first();
            // $tagihan->jumlah_tagihan = $tagihan->jumlah_tagihan + ($jumlah_pesanan * $harga_gas);
            // $tagihan->save();

            $sopir = Sopir::find($sopir);
            $sopir->ketersediaan_sopir = 'tidak tersedia';
            $id_pelanggan = $transaksi->id_pelanggan;
            $pelanggan = Pelanggan::where('id_pelanggan', $id_pelanggan)->first();
            $sopir->bop_sopir = $sopir->bop_sopir + $pelanggan->bop_pelanggan;
            $sopir->save();

            $mobil = Mobil::find($mobil);
            $mobil->ketersediaan_mobil = 'tidak tersedia';
            $mobil->save();

            // $jumlah_pengiriman = Pesanan::where('id_pesanan', $pengiriman->id_pesanan)->value('jumlah_pesanan');
            // $dataSopir = Sopir::where('id_sopir', $sopir)->first();
            // $nama = $dataSopir->nama;
            // broadcast(new Chart3Event($jumlah_pengiriman, $nama));

            Session::flash('success', 'Pesanan berhasil dikirim!');
            return response()->json(['success' => true]);
        }
    }

    public function print_suratjalan($id_pengiriman)
    {
        $data['title'] = 'Print Surat Jalan';

        $pengiriman = Pengiriman::where('id_pengiriman', $id_pengiriman)->first();
        $id_transaksi = $pengiriman->pesanan->id_transaksi;
        $transaksi = Transaksi::where('id_transaksi', $id_transaksi)->first();
        $id_pesanan = $pengiriman->pesanan->id_pesanan;
        $pesanan = Pesanan::where('id_pesanan', $id_pesanan)->first();
        $gas = Gas::sum('harga_gas');
        $harga_gas = number_format($gas, 0, ',', '.');

        return view('auth.pengiriman.more.print', [
            'pengiriman' => $pengiriman,
            'transaksi' => $transaksi,
            'pesanan' => $pesanan,
            'harga_gas' => $harga_gas,
        ], $data);
    }

    public function detail_pengiriman($id_pesanan)
    {
        $data['title'] = 'Detail Pengiriman';
        $pengirimans = Pengiriman::where('id_pesanan', $id_pesanan)
            ->with('pesanan')
            ->orderBy('created_at', 'desc')
            ->get();

        $sopirs = Sopir::all();
        $mobils = Mobil::all();

        foreach ($pengirimans as $pengiriman) {
            $sopir = $sopirs->where('id_sopir', $pengiriman->id_sopir)->first();
            $mobil = $mobils->where('id_mobil', $pengiriman->id_mobil)->first();
        }

        // Mengambil pelanggan terkait dengan transaksi terakhir
        $pelanggan = $pengirimans->last()->pesanan->transaksi->pelanggan;

        return view('auth.pengiriman.more.info_pengiriman', [
            'pengirimans' => $pengirimans,
            'pelanggan' => $pelanggan,
            'sopir' => $sopir,
            'mobil' => $mobil,
        ], $data);
    }
}
