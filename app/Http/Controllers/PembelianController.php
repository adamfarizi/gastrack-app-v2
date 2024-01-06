<?php

namespace App\Http\Controllers;

use App\Events\Chart2Event;
use App\Models\Gas;
use App\Models\Pengiriman;
use App\Models\Pesanan;
use App\Models\Transaksi;
use App\Models\Mobil;
use App\Models\Sopir;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    public function index()
    {
        $data['title'] = 'Pembelian';

        $transaksis = Transaksi::all();
        $pesanans = Pesanan::all();
        $gas = Gas::sum('harga_gas');
        $harga_gas = number_format($gas, 0, ',', '.');

        $data_gas = Gas::all();

        return view('auth.pembelian.pembelian', [
            'transaksis' => $transaksis,
            'pesanans' => $pesanans,
            'harga_gas' => $harga_gas,
            'data_gas' => $data_gas,
        ], $data);
    }

    public function realtimeData()
    {
        $total_transaksi = Transaksi::count();
        $total_pesanan = Pesanan::count();
        $pesanan_masuk = Pesanan::whereHas('pengiriman', function ($query) {
            $query->whereIn('status_pengiriman', ['Proses']);
        })->count();
        $gas = Gas::sum('harga_gas');
        $harga_gas = number_format($gas, 0, ',', '.');
        $transaksis = Transaksi::with('pelanggan', 'tagihan')->whereHas('tagihan', function ($query) {
            $query->whereIn('status_tagihan', ['Belum Bayar'])->orWhereIn('status_tagihan', ['Diproses']);;
        })
        ->orderBy('created_at','desc')
        ->get();
        $riwayat_transaksis = Transaksi::with('pelanggan', 'tagihan')->whereHas('tagihan', function ($query) {
            $query->whereIn('status_tagihan', ['Sudah Bayar']);
        })
        ->orderBy('created_at','desc')
        ->get();

        return response()->json([
            'total_transaksi' => $total_transaksi,
            'total_pesanan' => $total_pesanan,
            'pesanan_masuk' => $pesanan_masuk,
            'harga_gas' => $harga_gas,
            'transaksis' => $transaksis,
            'riwayat_transaksis' => $riwayat_transaksis,
        ]);
    }

    public function detail_pesanan($id_transaksi)
    {
        $data['title'] = 'Pembelian';
        $transaksis = Transaksi::where('id_transaksi', $id_transaksi)->get();
        $pesananAwal = Pesanan::where('id_transaksi', $id_transaksi)->orderBy('tanggal_pesanan', 'asc')->first();
        $pesanans = Pesanan::where('id_transaksi', $id_transaksi)->get();
        $pesananAkhir = Pesanan::where('id_transaksi', $id_transaksi)->orderBy('tanggal_pesanan', 'desc')->first();

        $pengirimans = Pengiriman::all();

        return view('auth.pembelian.more.pesanan', [
            'transaksis' => $transaksis,
            'pesananAwal' => $pesananAwal,
            'pesanans' => $pesanans,
            'pesananAkhir' => $pesananAkhir,
            'pengirimans' => $pengirimans,
        ], $data);
    }

    public function detail_tagihan($id_transaksi)
    {
        $data['title'] = 'Pembelian';

        $transaksis = Transaksi::where('id_transaksi', $id_transaksi)->get();
        $pesanans = Pesanan::where('id_transaksi', $id_transaksi)->get();

        return view('auth.pembelian.more.tagihan', [
            'transaksis' => $transaksis,
            'pesanans' => $pesanans,
        ], $data);
    }

    public function konfirmasi_pembayaran($id_transaksi)
    {
        $transaksi = Transaksi::find($id_transaksi);

        if (!$transaksi) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan !');
        } else {
            if ($transaksi->tagihan->bukti_pembayaran == null) {
                return redirect()->back()->with('error', 'Tidak ada bukti pembayaran !');
            } else {
                $transaksi->tagihan->status_tagihan = "Sudah Bayar";
                $transaksi->tagihan->save();

                $nama_perusahaan = $transaksi->pelanggan->nama_perusahaan;
                $jumlah_tagihan = $transaksi->tagihan->jumlah_tagihan;
                $bulan = Carbon::parse($transaksi->tagihan->tanggal_pembayaran)->format('M Y');
                broadcast(new Chart2Event($nama_perusahaan, $jumlah_tagihan, $bulan));

                return redirect()->route('pembelian')->with('success', 'Pembayaran berhasil dikonfirmasi !');
            }
        }
    }

    public function print_invoice($id_transaksi)
    {   
        $data['title'] = 'Print Invoice';

        $transaksis = Transaksi::where('id_transaksi',$id_transaksi)->get();
        $pesanans = Pesanan::where('id_transaksi',$id_transaksi)->get();
        $gas = Gas::sum('harga_gas');
        $harga_gas = number_format($gas, 0, ',', '.');

        return view('auth.pembelian.more.print', [
            'transaksis' => $transaksis,
            'pesanans' => $pesanans,
            'harga_gas' => $harga_gas,
        ], $data);
    }

    public function edit_gas($id_gas, Request $request)
    {
        $request->validate([
            'harga_gas' => 'required',
        ]);

        $data_gas = Gas::findOrFail($id_gas);

        if (!$data_gas) {
            return redirect()->back()->with('error', 'Gas tidak ditemukan !');
        } else {
            $data_gas->fill([
                'harga_gas' => $request->input('harga_gas'),
            ]);    
            $data_gas->save();
    
            return redirect()->back()->with('success', 'Harga gas berhasil diubah !');
        }
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

        return view('auth.pembelian.more.pengiriman', [
            'pengirimans' => $pengirimans,
            'pelanggan' => $pelanggan,
            'sopir' => $sopir,
            'mobil' => $mobil,
        ], $data);
    }
    
}
