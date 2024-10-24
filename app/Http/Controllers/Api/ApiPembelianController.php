<?php

namespace App\Http\Controllers\Api;

use App\Events\BayarTagihanEvent;
use App\Events\Chart1Event;
use App\Events\Chart4Event;
use App\Events\PesananBaruEvent;
use App\Http\Controllers\Controller;
use App\Models\Gas;
use App\Models\Pelanggan;
use App\Models\Pengiriman;
use App\Models\Transaksi;
use App\Models\Tagihan;
use App\Models\Pesanan;
use App\Events\newTranEvent;
use App\Events\updateTranEvent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ApiPembelianController extends Controller
{

    public function index_transaksi($id_pelanggan)
    {
        try {
            $transaksi = Transaksi::where('id_pelanggan', $id_pelanggan)->get();

            return response()->json([
                'success' => true,
                'message' => 'Data transaksi berhasil diambil',
                'data' => $transaksi,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data transaksi',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function create_transaksi(Request $request)
    {
        $pelangganAktif = Pelanggan::where('id_pelanggan', $request->input('id_pelanggan'))
            ->where('status', 'aktif')
            ->first();

        if (!$pelangganAktif) {
            return response()->json([
                'success' => false,
                'message' => 'Pelanggan tidak aktif. Transaksi tidak dapat dilakukan.',
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan',
            'bukti_pesanan' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        } else {
            $tagihan_terbaru = Tagihan::where('id_pelanggan', $request->input('id_pelanggan'))
                ->orderBy('created_at', 'desc')
                ->first();
            if (!$tagihan_terbaru) {
                $pelanggan = Pelanggan::where('id_pelanggan', $request->input('id_pelanggan'))->first();
                $tanggal_jatuh_tempo_baru = now()->addWeeks($pelanggan->jenis_pembayaran)->format('Y-m-d');
                $tagihan = new Tagihan([
                    'tanggal_jatuh_tempo' => $tanggal_jatuh_tempo_baru,
                    'status_tagihan' => 'Belum Bayar',
                    'tanggal_pembayaran' => null,
                    'bukti_pembayaran' => null,
                    'id_pelanggan' => $request->input('id_pelanggan'),
                ]);
                $tagihan->save();
                $resi_transaksi = 'GTK-' . now()->format('YmdHis') . Str::random(2);
                $tagihan_baru = Tagihan::where('id_pelanggan', $request->input('id_pelanggan'))
                    ->orderBy('created_at', 'desc')
                    ->first();
                $transaksi = new Transaksi([
                    'resi_transaksi' => $resi_transaksi,
                    'tanggal_transaksi' => now(),
                    'id_pelanggan' => $request->input('id_pelanggan'),
                    'id_tagihan' => $tagihan_baru->id_tagihan,
                    'id_admin' => 1,
                ]);
                $transaksi->save();
                $tanggal_sekarang = now();
                $transaksi_baru = Transaksi::where('id_pelanggan', $request->input('id_pelanggan'))
                    ->latest('created_at')
                    ->first();
                $file = $request->file('bukti_pesanan');
                $fileName = $file->getClientOriginalName();
                $file->move(public_path('img/BuktiPesanan'), $fileName);
                $pesanan = new Pesanan([
                    'tanggal_pesanan' => $tanggal_sekarang,
                    'id_transaksi' => $transaksi_baru->id_transaksi,
                    'bukti_pesanan' => $fileName,
                    'bop_pesanan' => $pelanggan->bop_pelanggan,
                    'deskripsi_pesanan' => $request->input('deskripsi_pesanan'),
                ]);
                $pesanan->save();
                $pesanan_baru = Pesanan::where('id_transaksi', $transaksi_baru->id_transaksi)
                    ->latest('created_at')
                    ->first();
                $kode_pengiriman = 'GTK|SEND-' . now()->format('YmdHis') . Str::random(2);
                $pengiriman = new Pengiriman([
                    'kode_pengiriman' => $kode_pengiriman,
                    'status_pengiriman' => 'Proses',
                    'id_pesanan' => $pesanan_baru->id_pesanan,
                ]);
                $pengiriman->save();

                // Broadcast
                $nama_perusahaan = $pelanggan->nama_perusahaan;
                $jumlah_pesanan = $request->input('jumlah_pesanan');
                $hari = Carbon::parse($pesanan_baru->tanggal_pesanan)->format('d M');
                $total_pesanan = 1;
                broadcast(new PesananBaruEvent($nama_perusahaan));
                broadcast(new Chart1Event($nama_perusahaan, $jumlah_pesanan, $hari));
                broadcast(new Chart4Event($nama_perusahaan, $total_pesanan));

                return response()->json([
                    'success' => true,
                    'message' => 'Transaksi baru sudah ditambah !',
                    'data_transaksi' => $transaksi_baru,
                    'data_tagihan' => $tagihan_baru,
                    'data_pesanan' => $pesanan,
                    'data_pengiriman' => $pengiriman,
                ], 200);
            } else {
                if ($tagihan_terbaru->status_tagihan === 'Belum Bayar') {
                    $tanggal_sekarang = now();
                    if ($tanggal_sekarang > $tagihan_terbaru->tanggal_jatuh_tempo) {

                        return response()->json([
                            'success' => false,
                            'message' => 'Anda memiliki tagihan yang belum dibayar !',
                        ], 422);
                    } else {
                        $transaksi_terbaru = Transaksi::where('id_pelanggan', $request->input('id_pelanggan'))
                            ->latest('created_at')
                            ->first();
                        $pelanggan = Pelanggan::where('id_pelanggan', $request->input('id_pelanggan'))->first();
                        $file = $request->file('bukti_pesanan');
                        $fileName = $file->getClientOriginalName();
                        $file->move(public_path('img/BuktiPesanan'), $fileName);
                        $pesanan = new Pesanan([
                            'tanggal_pesanan' => $tanggal_sekarang,
                            'id_transaksi' => $transaksi_terbaru->id_transaksi,
                            'bukti_pesanan' => $fileName,
                            'bop_pesanan' => $pelanggan->bop_pelanggan,
                            'deskripsi_pesanan' => $request->input('deskripsi_pesanan'),
                        ]);
                        $pesanan->save();
                        $pesanan_baru = Pesanan::where('id_transaksi', $transaksi_terbaru->id_transaksi)
                            ->latest('created_at')
                            ->first();
                        $kode_pengiriman = 'GTK|SEND-' . now()->format('YmdHis') . Str::random(2);
                        $pengiriman = new Pengiriman([
                            'kode_pengiriman' => $kode_pengiriman,
                            'status_pengiriman' => 'Proses',
                            'id_pesanan' => $pesanan_baru->id_pesanan,
                        ]);
                        $pengiriman->save();

                        // Broadcast
                        $nama_perusahaan = $pelanggan->nama_perusahaan;
                        $jumlah_pesanan = $request->input('jumlah_pesanan');
                        $hari = Carbon::parse($pesanan_baru->tanggal_pesanan)->format('d M');
                        $total_pesanan = 1;
                        broadcast(new PesananBaruEvent($nama_perusahaan));
                        broadcast(new Chart1Event($nama_perusahaan, $jumlah_pesanan, $hari));
                        broadcast(new Chart4Event($nama_perusahaan, $total_pesanan));

                        return response()->json([
                            'success' => true,
                            'message' => 'Pesanan baru sudah ditambah !',
                            'data_pesanan' => $pesanan,
                            'data_tagihan' => $tagihan_terbaru,
                            'data_pengiriman' => $pengiriman,
                        ], 200);
                    }
                } else {
                    $pelanggan = Pelanggan::where('id_pelanggan', $request->input('id_pelanggan'))->first();
                    $tanggal_jatuh_tempo_baru = now()->addWeeks($pelanggan->jenis_pembayaran)->format('Y-m-d');
                    $tagihan = new Tagihan([
                        'tanggal_jatuh_tempo' => $tanggal_jatuh_tempo_baru,
                        'status_tagihan' => 'Belum Bayar',
                        'tanggal_pembayaran' => null,
                        'bukti_pembayaran' => null,
                        'id_pelanggan' => $request->input('id_pelanggan'),
                    ]);
                    $tagihan->save();
                    $resi_transaksi = 'GTK-' . now()->format('YmdHis') . Str::random(2);
                    $tagihan_baru = Tagihan::where('id_pelanggan', $request->input('id_pelanggan'))
                        ->orderBy('created_at', 'desc')
                        ->first();
                    $transaksi = new Transaksi([
                        'resi_transaksi' => $resi_transaksi,
                        'tanggal_transaksi' => now(),
                        'id_pelanggan' => $request->input('id_pelanggan'),
                        'id_tagihan' => $tagihan_baru->id_tagihan,
                        'id_admin' => 1,
                    ]);
                    $transaksi->save();
                    $tanggal_sekarang = now();
                    $transaksi_baru = Transaksi::where('id_pelanggan', $request->input('id_pelanggan'))
                        ->latest('created_at')
                        ->first();
                    $file = $request->file('bukti_pesanan');
                    $fileName = $file->getClientOriginalName();
                    $file->move(public_path('img/BuktiPesanan'), $fileName);
                    $pesanan = new Pesanan([
                        'tanggal_pesanan' => $tanggal_sekarang,
                        'id_transaksi' => $transaksi_baru->id_transaksi,
                        'bukti_pesanan' => $fileName,
                        'bop_pesanan' => $pelanggan->bop_pelanggan,
                        'deskripsi_pesanan' => $request->input('deskripsi_pesanan'),
                    ]);
                    $pesanan->save();
                    $pesanan_baru = Pesanan::where('id_transaksi', $transaksi_baru->id_transaksi)
                        ->latest('created_at')
                        ->first();
                    $kode_pengiriman = 'GTK|SEND-' . now()->format('YmdHis') . Str::random(2);
                    $pengiriman = new Pengiriman([
                        'kode_pengiriman' => $kode_pengiriman,
                        'status_pengiriman' => 'Proses',
                        'id_pesanan' => $pesanan_baru->id_pesanan,
                    ]);
                    $pengiriman->save();

                    // Broadcast
                    $nama_perusahaan = $pelanggan->nama_perusahaan;
                    $jumlah_pesanan = $request->input('jumlah_pesanan');
                    $hari = Carbon::parse($pesanan_baru->tanggal_pesanan)->format('d M');
                    $total_pesanan = 1;
                    broadcast(new PesananBaruEvent($nama_perusahaan));
                    broadcast(new Chart1Event($nama_perusahaan, $jumlah_pesanan, $hari));
                    broadcast(new Chart4Event($nama_perusahaan, $total_pesanan));

                    return response()->json([
                        'success' => true,
                        'message' => 'Transaksi baru sudah ditambah !',
                        'data_transaksi' => $transaksi_baru,
                        'data_tagihan' => $tagihan_baru,
                        'data_pesanan' => $pesanan,
                        'data_pengiriman' => $pengiriman,
                    ], 200);
                }
            }
        }
    }

    public function transaksi_belum_bayar($id_pelanggan = null)
    {
        $query = Transaksi::whereHas('tagihan', function ($query) {
            $query->where('status_tagihan', 'Belum Bayar');
        })
            ->join('pelanggan', 'transaksi.id_pelanggan', '=', 'pelanggan.id_pelanggan')
            ->join('tagihan', 'transaksi.id_tagihan', '=', 'tagihan.id_tagihan');

        // Menambahkan kondisi berdasarkan id_pelanggan jika disediakan
        if ($id_pelanggan !== null) {
            $query->where('pelanggan.id_pelanggan', $id_pelanggan);
        }

        $belum_bayar = $query
            ->select([
                'transaksi.id_transaksi',
                'pelanggan.nama_perusahaan',
                'pelanggan.nama_pemilik',
                'transaksi.tanggal_transaksi',
                'transaksi.resi_transaksi',
                'tagihan.status_tagihan',
                'tagihan.jumlah_tagihan',
            ])
            ->orderBy('transaksi.tanggal_transaksi', 'desc')
            ->get();

        if ($belum_bayar->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Data ditemukan',
                'datauser' => $belum_bayar,
            ], 200);
        }
    }

    public function transaksi_sudah_bayar($id_pelanggan = null)
    {
        $query = Transaksi::whereHas('tagihan', function ($query) {
            $query->where('status_tagihan', 'Sudah Bayar');
        })
            ->join('pelanggan', 'transaksi.id_pelanggan', '=', 'pelanggan.id_pelanggan')
            ->join('tagihan', 'transaksi.id_tagihan', '=', 'tagihan.id_tagihan');

        // Menambahkan kondisi berdasarkan id_pelanggan jika disediakan
        if ($id_pelanggan !== null) {
            $query->where('pelanggan.id_pelanggan', $id_pelanggan);
        }

        $belum_bayar = $query
            ->select([
                'transaksi.id_transaksi',
                'pelanggan.nama_perusahaan',
                'pelanggan.nama_pemilik',
                'transaksi.tanggal_transaksi',
                'transaksi.resi_transaksi',
                'tagihan.status_tagihan',
                'tagihan.jumlah_tagihan',
            ])
            ->orderBy('transaksi.tanggal_transaksi', 'desc')
            ->get();

        if ($belum_bayar->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Data ditemukan',
                'datauser' => $belum_bayar,
            ], 200);
        }
    }

    public function update_pembayaran($id_tagihan, Request $request)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $dikirim = Tagihan::where('id_tagihan', $id_tagihan)->first();

        if (!$dikirim) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
            ], 422);
        }

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('img/BuktiPembayaran'), $fileName);

            $dikirim->update([
                'tanggal_pembayaran' => now(),
                'bukti_pembayaran' => $fileName,
                'status_tagihan' => 'Diproses'
            ]);
        }

        // Broadcast
        $pelanggan = Pelanggan::where('id_pelanggan', $dikirim->id_pelanggan)->first();
        $nama_perusahaan = $pelanggan->nama_perusahaan;
        broadcast(new BayarTagihanEvent($nama_perusahaan));

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diubah',
            'datauser' => $dikirim,
        ], 200);
    }

    public function index_tagihanPelanggan(string $id)
    {
        $pelanggan = Tagihan::where('id_pelanggan', $id)
            ->where('status_tagihan', "Belum Bayar")
            ->first();

        if (empty($pelanggan)) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada tagihan',
            ], 422);
        } else {
            $formattedJumlahTagihan = number_format($pelanggan->jumlah_tagihan, 0, ',', '.');
            Carbon::setLocale('id');
            $formattedTanggalJatuhTempo = Carbon::parse($pelanggan->tanggal_jatuh_tempo)->isoFormat('DD MMMM YYYY');

            // Update data pelanggan dengan format baru
            $pelanggan->tanggal_jatuh_tempo = $formattedTanggalJatuhTempo;
            $pelanggan->jumlah_tagihan = $formattedJumlahTagihan;
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditemukan',
                'data' => $pelanggan,
            ], 200);
        }
    }

    public function updatePengirimanLWC(Request $request, $id_pesanan)
    {
        // Validasi request
        $request->validate([
            'gas_masuk' => 'required|integer',
            'sisa_gas' => 'required|integer',
            'tube_volume' => 'required|integer',
        ]);

        // Ambil data pesanan berdasarkan ID dan filter kondisi pengiriman
        $pesanan = Pesanan::where('id_pesanan', $id_pesanan)
            ->where(function ($query) {
                $query->whereNull('tube_volume')
                    ->orWhere('tube_volume', 0); // Cek lwc null atau 0
            })
            ->whereHas('pengiriman', function ($query) {
                $query->whereNull('kapasitas_gas_masuk')
                    ->whereNull('kapasitas_gas_keluar')
                    ->whereNull('sisa_gas');
            })
            ->with('pengiriman')
            ->first();

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
            ], 422);
        } else {
            // Update data pengiriman
            $pengiriman = $pesanan->pengiriman;
            $pengiriman->kapasitas_gas_masuk = $request->gas_masuk;
            $pengiriman->kapasitas_gas_keluar = $request->gas_masuk - $request->sisa_gas;
            $pengiriman->sisa_gas = $request->sisa_gas;
            $pengiriman->save();  // Simpan perubahan pada pengiriman

            // Update data pesanan
            $pesanan->jumlah_bar = $pengiriman->kapasitas_gas_keluar;
            $pesanan->tube_volume = $request->tube_volume;
            $pesanan->save();  // Simpan perubahan pada pesanan

            return response()->json([
                'success' => true,
                'message' => 'Data pengiriman berhasil diupdate',
            ], 200);
        }
    }

}