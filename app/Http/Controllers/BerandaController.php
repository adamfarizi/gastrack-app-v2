<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pengiriman;
use App\Models\Pesanan;
use App\Models\Tagihan;
use App\Models\Transaksi;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BerandaController extends Controller
{
    public function index()
    {
        $data['title'] = 'Beranda';

        $transaksis = Transaksi::all();

        // Peningkatan pesanan
        $tanggal_sekarang = date('Y-m-d');
        $tanggal_sebelumnya = date('Y-m-d', strtotime('-1 day', strtotime($tanggal_sekarang)));
        $total_pesanan_sekarang = Pesanan::whereDate('tanggal_pesanan', $tanggal_sekarang)
            ->sum('jumlah_bar');
        $total_pesanan_sebelumnya = Pesanan::whereDate('tanggal_pesanan', $tanggal_sebelumnya)
            ->sum('jumlah_bar');
        $peningkatan_pesanan = 0;
        if ($total_pesanan_sebelumnya > 0) {
            $peningkatan_pesanan = (($total_pesanan_sekarang - $total_pesanan_sebelumnya) / $total_pesanan_sebelumnya) * 100;
        }

        // Peningkatan pemasukan
        $bulan_sekarang = date('n');
        $bulan_sebelumnya = $bulan_sekarang - 1;
        $tahun_sekarang = date('Y');
        $tahun_sebelumnya = $tahun_sekarang;
        if ($bulan_sebelumnya <= 0) {
            $bulan_sebelumnya = 12;
            $tahun_sebelumnya -= 1;
        }
        $total_pemasukan_sekarang = Tagihan::whereMonth('tanggal_pembayaran', $bulan_sekarang)
            ->whereYear('tanggal_pembayaran', $tahun_sekarang)
            ->where('status_tagihan', 'Sudah Bayar')
            ->sum('jumlah_tagihan');
        $total_pemasukan_sebelumnya = Tagihan::whereMonth('tanggal_pembayaran', $bulan_sebelumnya)
            ->whereYear('tanggal_pembayaran', $tahun_sebelumnya)
            ->where('status_tagihan', 'Sudah Bayar')
            ->sum('jumlah_tagihan');
        $peningkatan_pemasukan = 0;
        if ($total_pemasukan_sebelumnya > 0) {
            $peningkatan_pemasukan = (($total_pemasukan_sekarang - $total_pemasukan_sebelumnya) / $total_pemasukan_sebelumnya) * 100;
        }

        $pesanan_sekarang = Pesanan::whereDate('tanggal_pesanan', $tanggal_sekarang)
            ->orderBy('tanggal_pesanan', 'ASC')
            ->take(6)
            ->get();

        return view('auth.beranda.beranda', [
            'transaksis' => $transaksis,
            'peningkatan_pesanan' => $peningkatan_pesanan,
            'peningkatan_pemasukan' => $peningkatan_pemasukan,
            'total_pemasukan_sekarang' => $total_pemasukan_sekarang,
            'total_pemasukan_sebelumnya' => $total_pemasukan_sebelumnya,
            'pesanan_sekarang' => $pesanan_sekarang,
        ], $data);
    }

    public function realtimeData()
    {
        $total_pelanggan = Pelanggan::count();
        $total_transaksi = Transaksi::count();
        $total_pesanan = Pesanan::count();
        $total_tagihan = Tagihan::where('status_tagihan', 'Sudah Bayar')->sum('jumlah_tagihan');
        $total_pemasukan = number_format($total_tagihan, 0, ',', '.');

        // Chart 1
        $data_pesanan = Pesanan::select(
            Pesanan::raw('SUM(jumlah_bar) as total_pesanan'),
            Pesanan::raw('DATE_FORMAT(tanggal_pesanan, "%d %b") as hari'),
            Pesanan::raw('MAX(tanggal_pesanan) as max_tanggal')
        )
            ->join('transaksi', 'pesanan.id_transaksi', '=', 'transaksi.id_transaksi')
            ->groupBy('tanggal_pesanan')
            ->orderBy('tanggal_pesanan', 'DESC')
            ->take(7)
            ->get();
        $data_chart1 = $data_pesanan->pluck('total_pesanan');
        $label_chart1 = $data_pesanan->pluck('hari');

        // Chart 2
        $data_pemasukan = Tagihan::select(
            Tagihan::raw('SUM(CASE WHEN status_tagihan = "Sudah Bayar" THEN jumlah_tagihan ELSE 0 END) as jumlah_tagihan'),
            Tagihan::raw('DATE_FORMAT(tanggal_pembayaran, "%d %Y") as bulan'),
            Tagihan::raw('MAX(tanggal_pembayaran) as max_tanggal')
        )
            ->where('status_tagihan', 'Sudah Bayar')
            ->groupBy('status_tagihan','tanggal_pembayaran')
            ->orderBy('tanggal_pembayaran', 'ASC')
            ->take(10)
            ->get();
        $data_chart2 = $data_pemasukan->pluck('jumlah_tagihan');
        $label_chart2 = $data_pemasukan->pluck('bulan');

        // Chart 3
        $now = Carbon::now();
        $data_pengiriman = Pengiriman::selectRaw('sopir.nama, COUNT(*) as jumlah_pengiriman')
            ->join('sopir', 'sopir.id_sopir', '=', 'pengiriman.id_sopir')
            ->whereIn('pengiriman.status_pengiriman', ['Dikirim', 'Diterima'])
            ->whereMonth('pengiriman.created_at', $now->month)
            ->whereYear('pengiriman.created_at', $now->year)
            ->groupBy('sopir.nama')
            ->orderBy('sopir.nama', 'ASC')
            ->take(10)
            ->get();
        $data_chart3 = $data_pengiriman->pluck('jumlah_pengiriman');
        $label_chart3 = $data_pengiriman->pluck('nama');

        // Chart 4
        $data_pelanggan = Pelanggan::selectRaw('COUNT(pesanan.id_pesanan) as jumlah_bar, pelanggan.nama_perusahaan')
            ->join('transaksi', 'pelanggan.id_pelanggan', '=', 'transaksi.id_pelanggan')
            ->join('pesanan', 'transaksi.id_transaksi', '=', 'pesanan.id_transaksi')
            ->whereMonth('pesanan.tanggal_pesanan', '=', now()->month)
            ->groupBy('pelanggan.id_pelanggan', 'pelanggan.nama_perusahaan')
            ->orderByDesc('jumlah_bar')
            ->take(10)
            ->get();
        $data_chart4 = $data_pelanggan->pluck('jumlah_bar');
        $label_chart4 = $data_pelanggan->pluck('nama_perusahaan');

        // Tabel Pembelian
        $transaksis = Transaksi::with('pelanggan', 'tagihan')
            ->orderByDesc('tanggal_transaksi')
            ->get();

        return response()->json([
            'total_pelanggan' => $total_pelanggan,
            'total_transaksi' => $total_transaksi,
            'total_pesanan' => $total_pesanan,
            'total_pemasukan' => $total_pemasukan,

            'data_chart1' => $data_chart1->toArray(),
            'label_chart1' => $label_chart1->toArray(),

            'data_chart2' => $data_chart2->toArray(),
            'label_chart2' => $label_chart2->toArray(),

            'data_chart3' => $data_chart3->toArray(),
            'label_chart3' => $label_chart3->toArray(),

            'data_chart4' => $data_chart4->toArray(),
            'label_chart4' => $label_chart4->toArray(),

            'transaksis' => $transaksis,
        ]);
    }

}
