<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Gas;
use App\Models\Pesanan;
use App\Models\Tagihan;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use App\Models\Pengiriman;
use App\Events\Chart1Event;
use App\Events\Chart4Event;
use Illuminate\Support\Str;
use App\Events\newTranEvent;
use Illuminate\Http\Request;
use App\Events\GasKeluarEvent;
use App\Events\updateTranEvent;
use App\Events\PesananBaruEvent;
use App\Events\BayarTagihanEvent;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

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
            // Cek apakah sudah pernah pesan
            if (!$tagihan_terbaru) {
                $pelanggan = Pelanggan::where('id_pelanggan', $request->input('id_pelanggan'))->first();
                //? If else jatuh tempo untuk yang turbin menjadi addMonth 1
                // if ($pelanggan->jenis_rumus === 'normal') {
                //     $tanggal_jatuh_tempo_baru = now()->addWeeks($pelanggan->jenis_pembayaran)->format('Y-m-d');
                // } else {
                //     $tanggal_jatuh_tempo_baru = now()->addMonth()->format('Y-m-d');
                // }e
                //? Jatuh tempo ada yang 1 bulan
                if ($pelanggan->jenis_pembayaran == 5) {
                    $tanggal_jatuh_tempo_baru = now()->addMonth()->format('Y-m-d');
                } else {
                    $tanggal_jatuh_tempo_baru = now()->addWeeks($pelanggan->jenis_pembayaran)->format('Y-m-d');
                }

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

                //? If else jika pesanan baru maka Turbin harus upload gas masuk
                if ($pelanggan->jenis_rumus === 'normal') {
                    return response()->json([
                        'success' => true,
                        'message' => 'Transaksi baru sudah ditambah !',
                        'data_transaksi' => $transaksi_baru,
                        'data_tagihan' => $tagihan_baru,
                        'data_pesanan' => $pesanan,
                        'data_pengiriman' => $pengiriman,
                    ], 200);
                } else {
                    return response()->json([
                        'success' => true,
                        'message' => 'Transaksi baru sudah ditambah !',
                        'upload_gas_masuk' => true,
                        'data_transaksi' => $transaksi_baru,
                        'data_tagihan' => $tagihan_baru,
                        'data_pesanan' => $pesanan,
                        'data_pengiriman' => $pengiriman,
                    ], 200);
                }
            } else {
                // Cek status pembayaran tagihan
                if ($tagihan_terbaru->status_tagihan === 'Belum Bayar') {
                    $tanggal_sekarang = now();
                    // Cek jatuh tempo
                    if ($tanggal_sekarang > $tagihan_terbaru->tanggal_jatuh_tempo) {
                        $pelanggan = Pelanggan::where('id_pelanggan', $request->input('id_pelanggan'))->first();
                        //! Pelanggan Turbin tetap bisa pesan meski lewat jatuh tempo, tetapi membuat transaksi baru
                        if ($pelanggan->jenis_rumus === 'normal') {
                            return response()->json([
                                'success' => false,
                                'message' => 'Anda memiliki tagihan yang belum dibayar !',
                            ], 422);
                        } else {
                            //? Pelanggan Turbin
                            // $tanggal_jatuh_tempo_baru = now()->addMonth()->format('Y-m-d');
                            //? Jatuh tempo ada yang 1 bulan
                            if ($pelanggan->jenis_pembayaran == 5) {
                                $tanggal_jatuh_tempo_baru = now()->addMonth()->format('Y-m-d');
                            } else {
                                $tanggal_jatuh_tempo_baru = now()->addWeeks($pelanggan->jenis_pembayaran)->format('Y-m-d');
                            }
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
                                'message' => 'Transaksi baru sudah ditambah masukkan Gas Akhir Pesanan Lama dan Gas Awal Pesanan Baru !',
                                'upload_gas_keluar' => true,
                                'data_transaksi' => $transaksi_baru,
                                'data_tagihan' => $tagihan_baru,
                                'data_pesanan' => $pesanan,
                                'data_pengiriman' => $pengiriman,
                            ], 200);
                        }
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
                    //? If else jatuh tempo untuk yang turbin menjadi addMonth 1
                    // if ($pelanggan->jenis_rumus === 'normal') {
                    //     $tanggal_jatuh_tempo_baru = now()->addWeeks($pelanggan->jenis_pembayaran)->format('Y-m-d');
                    // } else {
                    //     $tanggal_jatuh_tempo_baru = now()->addMonth()->format('Y-m-d');
                    // }
                    //? Jatuh tempo ada yang 1 bulan
                    if ($pelanggan->jenis_pembayaran == 5) {
                        $tanggal_jatuh_tempo_baru = now()->addMonth()->format('Y-m-d');
                    } else {
                        $tanggal_jatuh_tempo_baru = now()->addWeeks($pelanggan->jenis_pembayaran)->format('Y-m-d');
                    }

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

    public function uploadGasMasuk(Request $request, $id_transaksi)
    {
        // Validasi request
        $request->validate([
            'bukti_gas_masuk' => 'required|image|mimes:jpeg,jpg,png',
        ]);

        // Ambil transaksi berdasarkan ID
        $transaksi = Transaksi::where('id_transaksi', $id_transaksi)
            ->with('pesanan.pengiriman')
            ->first();

        if (!$transaksi) {
            return response()->json([
                'success' => false,
                'message' => 'Data transaksi tidak ditemukan!',
            ], 422);
        }

        // Ambil pengiriman dari pesanan pertama (asumsi satu transaksi memiliki satu pesanan)
        $pengiriman_baru = $transaksi->pesanan->first()->pengiriman ?? null;

        if (!$pengiriman_baru) {
            return response()->json([
                'success' => false,
                'message' => 'Data pengiriman tidak ditemukan!',
            ], 422);
        }

        // Cek apakah bukti gas masuk sudah ada
        if ($pengiriman_baru->bukti_gas_masuk) {
            return response()->json([
                'success' => false,
                'message' => 'Bukti gas masuk sudah diupload sebelumnya!',
            ], 422);
        }

        if ($request->hasFile('bukti_gas_masuk')) {
            $file = $request->file('bukti_gas_masuk');
            $nomor_resi = preg_replace('/[^0-9]/', '', $pengiriman_baru->kode_pengiriman);
            $fileName = $nomor_resi . "_" . $file->getClientOriginalName();
            $file->move(public_path('img/GasMasuk'), $fileName);

            $pengiriman_baru->update([
                'bukti_gas_masuk' => $fileName,
            ]);
        }

        $pengiriman_baru->save();

        return response()->json([
            'success' => true,
            'message' => 'Data pengiriman berhasil diupdate dengan bukti gas masuk'
        ], 200);
    }

    public function uploadGasKeluar(Request $request, $id_transaksi)
    {
        // Validasi request
        $request->validate([
            'bukti_gas_keluar' => 'required|image|mimes:jpeg,jpg,png',
        ]);

        // Ambil data transaksi lama
        $transaksi_lama = Transaksi::where('id_transaksi', '<', $id_transaksi)
            ->with('pesanan.pengiriman')
            ->orderBy('id_transaksi', 'desc')
            ->first();

        if (!$transaksi_lama) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi lama tidak ditemukan!',
            ], 422);
        }

        // Ambil pengiriman pertama dari transaksi lama
        $pengiriman_pertama = $transaksi_lama->pesanan->first()->pengiriman->first();

        if (!$pengiriman_pertama) {
            return response()->json([
                'success' => false,
                'message' => 'Pengiriman tidak ditemukan!',
            ], 422);
        }

        // Cek apakah bukti_gas_keluar sudah diupload
        if ($pengiriman_pertama->bukti_gas_keluar !== null) {
            return response()->json([
                'success' => false,
                'message' => 'Bukti gas keluar sudah diupload sebelumnya!',
            ], 422);
        }

        if ($request->hasFile('bukti_gas_keluar')) {
            $file = $request->file('bukti_gas_keluar');
            $nomor_resi = preg_replace('/[^0-9]/', '', $pengiriman_pertama->kode_pengiriman);
            $fileName = $nomor_resi . "_" . $file->getClientOriginalName();
            $file->move(public_path('img/GasKeluar'), $fileName);

            // Update pengiriman dengan bukti_gas_keluar
            $pengiriman_pertama->update([
                'bukti_gas_keluar' => $fileName,
            ]);
        }

        $pengiriman_pertama->save();

        // Notif Gas Diterima
        $pesanan = Pesanan::where('id_pesanan', $pengiriman_pertama->id_pesanan)->first();
        $transaksi = Transaksi::where('id_transaksi', $pesanan->id_transaksi)->first();
        $nama_perusahaan = $transaksi->pelanggan->nama_perusahaan;
        broadcast(new GasKeluarEvent($nama_perusahaan));

        return response()->json([
            'success' => true,
            'message' => 'Data pengiriman berhasil diupdate dengan bukti gas keluar',
            'bukti_gas_masuk' => true,
        ], 200);
    }

}