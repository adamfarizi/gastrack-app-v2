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
        // Tentukan aturan validasi id_pelanggan
        $rules = [
            'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan',
        ];

        // Lakukan validasi
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'id pelanggan tidak ditemukan!',
                'errors' => $validator->errors(),
            ], 422);
        } else {
            $pelangganAktif = Pelanggan::where('id_pelanggan', $request->input('id_pelanggan'))
                ->where('status', 'aktif')
                ->first();

            if (!$pelangganAktif) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat pesanan, akun Anda telah dinonaktifkan',
                ], 422);
            } else {
                $tagihan_terbaru = Tagihan::where('id_pelanggan', $request->input('id_pelanggan'))
                    ->orderBy('created_at', 'desc')
                    ->first();

                //! Cek apakah sudah pernah pesan, jika belum pernah maka membuat transaksi baru
                if (!$tagihan_terbaru) {

                    $rules_file['bukti_pesanan'] = 'required|image|mimes:jpeg,jpg,png|max:2048';

                    // Lakukan validasi
                    $validator = Validator::make($request->all(), $rules_file);

                    if ($validator->fails()) {
                        if ($pelangganAktif->jenis_rumus == 'normal') {
                            return response()->json([
                                'success' => false,
                                'message' => 'Mohon unggah bukti pesanan!',
                                'errors' => $validator->errors(),
                            ], 422);
                        } else {
                            return response()->json([
                                'success' => false,
                                'message' => 'Mohon unggah foto turbin meter saat ini, kemudian lakukan pesan ulang!',
                                'errors' => $validator->errors(),
                            ], 403);
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
                        $fileName = $transaksi->resi_transaksi . '_' . $file->getClientOriginalName();
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

                        //? Response untuk jenis_rumus turbin
                        if ($pelanggan->jenis_rumus === 'turbin') {
                            //? Pemanggilan handleTurbinUpload jika jenis_rumus adalah turbin
                            $uploadResult = $this->handleTurbinUpload($file, $fileName, $transaksi_baru->id_transaksi);

                            return response()->json([
                                'success' => true,
                                'message' => 'Pesanan baru berhasil dibuat!',
                                'upload_result' => $uploadResult,
                                'data_transaksi' => $transaksi_baru,
                                'data_tagihan' => $tagihan_baru,
                                'data_pesanan' => $pesanan,
                                'data_pengiriman' => $pengiriman,
                            ], 200);
                        }

                        //? Response untuk jenis_rumus normal
                        return response()->json([
                            'success' => true,
                            'message' => 'Pesanan baru berhasil dibuat!',
                            'data_transaksi' => $transaksi_baru,
                            'data_tagihan' => $tagihan_baru,
                            'data_pesanan' => $pesanan,
                            'data_pengiriman' => $pengiriman,
                        ], 200);
                    }
                } else {
                    //! Cek status pembayaran tagihan, jika sudah bayar membuat transaksi baru
                    if ($tagihan_terbaru->status_tagihan === 'Belum Bayar') {
                        $tanggal_sekarang = now();
                        //! Cek jatuh tempo, jika tidak jatuh tempo lanjut ke create pesanan di transaksi sekarang
                        if ($tanggal_sekarang > $tagihan_terbaru->tanggal_jatuh_tempo) {
                            $pelanggan = Pelanggan::where('id_pelanggan', $request->input('id_pelanggan'))->first();
                            //! Pelanggan Turbin tetap bisa pesan meski lewat jatuh tempo, tetapi membuat transaksi baru
                            if ($pelanggan->jenis_rumus === 'normal') {
                                return response()->json([
                                    'success' => false,
                                    'message' => 'Anda memiliki tagihan yang belum dibayar!',
                                ], 422);
                            } else {
                                //? Pelanggan Turbin
                                // $tanggal_jatuh_tempo_baru = now()->addMonth()->format('Y-m-d');
                                //? Jatuh tempo ada yang 1 bulan

                                $rules_file['bukti_pesanan'] = 'required|image|mimes:jpeg,jpg,png|max:2048';

                                // Lakukan validasi
                                $validator = Validator::make($request->all(), $rules_file);

                                if ($validator->fails()) {
                                    return response()->json([
                                        'success' => false,
                                        'message' => 'Mohon unggah foto turbin meter saat ini, kemudian lakukan pesan ulang!',
                                        'errors' => $validator->errors(),
                                    ], 403);
                                } else {

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
                                    $fileName = $transaksi->resi_transaksi . '_' . $file->getClientOriginalName();
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

                                    //? Pemanggilan handleTurbinUpload jika jenis_rumus adalah turbin
                                    $uploadResult = $this->handleTurbinUpload($file, $fileName, $transaksi_baru->id_transaksi);

                                    return response()->json([
                                        'success' => true,
                                        'message' => 'Pesanan baru berhasil dibuat!',
                                        'upload_result' => $uploadResult,
                                        'data_transaksi' => $transaksi_baru,
                                        'data_tagihan' => $tagihan_baru,
                                        'data_pesanan' => $pesanan,
                                        'data_pengiriman' => $pengiriman,
                                    ], 200);
                                }
                            }
                        } else {

                            if ($pelangganAktif->jenis_rumus == 'normal') {
                                $rules_file['bukti_pesanan'] = 'required|image|mimes:jpeg,jpg,png|max:2048';
                            } else {
                                $rules_file['bukti_pesanan'] = 'image|mimes:jpeg,jpg,png|max:2048';
                            }

                            // Lakukan validasi
                            $validator = Validator::make($request->all(), $rules_file);

                            if ($validator->fails()) {
                                return response()->json([
                                    'success' => false,
                                    'message' => 'Mohon unggah bukti pesanan!',
                                    'errors' => $validator->errors(),
                                ], 422);
                            } else {

                                $transaksi_terbaru = Transaksi::where('id_pelanggan', $request->input('id_pelanggan'))
                                    ->latest('created_at')
                                    ->first();
                                $pelanggan = Pelanggan::where('id_pelanggan', $request->input('id_pelanggan'))->first();

                                //? Default nilai untuk bukti_pesanan jika tidak upload bukti pesanan di turbin
                                $fileName = '-';
                                if ($request->hasFile('bukti_pesanan')) {
                                    $file = $request->file('bukti_pesanan');
                                    $fileName = $transaksi_terbaru->resi_transaksi . '_' . $file->getClientOriginalName();
                                    $file->move(public_path('img/BuktiPesanan'), $fileName);
                                }
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
                                    'message' => 'Pesanan berhasil dibuat!',
                                    'data_pesanan' => $pesanan,
                                    'data_tagihan' => $tagihan_terbaru,
                                    'data_pengiriman' => $pengiriman,
                                ], 200);
                            }
                        }
                    } else {

                        $rules_file['bukti_pesanan'] = 'required|image|mimes:jpeg,jpg,png|max:2048';

                        // Lakukan validasi
                        $validator = Validator::make($request->all(), $rules_file);

                        if ($validator->fails()) {
                            if ($pelangganAktif->jenis_rumus == 'normal') {
                                return response()->json([
                                    'success' => false,
                                    'message' => 'Mohon unggah bukti pesanan!',
                                    'errors' => $validator->errors(),
                                ], 422);
                            } else {
                                return response()->json([
                                    'success' => false,
                                    'message' => 'Mohon unggah foto turbin meter saat ini, kemudian lakukan pesan ulang!',
                                    'errors' => $validator->errors(),
                                ], 403);
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
                            $fileName = $transaksi->resi_transaksi . '_' . $file->getClientOriginalName();
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
                                'message' => 'Pesanan baru berhasil dibuat!',
                                'data_transaksi' => $transaksi_baru,
                                'data_tagihan' => $tagihan_baru,
                                'data_pesanan' => $pesanan,
                                'data_pengiriman' => $pengiriman,
                            ], 200);
                        }
                    }
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
            $fileName = now()->format('YmdHis') . '_' . $file->getClientOriginalName();
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
            'message' => 'Bukti pembayaran berhasil diunggah, tunggu konfirmasi dari admin dahulu!',
            'datauser' => $dikirim,
        ], 200);
    }

    public function index_tagihanPelanggan(string $id)
    {

        Carbon::setLocale('id');

        $pelanggan = Tagihan::where('id_pelanggan', $id)
            ->where('status_tagihan', "Belum Bayar")
            ->first(); 

        // if (empty($pelanggan)) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Tidak ada tagihan',
        //         'data' => $pelanggan,
        //     ], 422); 
        // }

        // $formattedJumlahTagihan = number_format($pelanggan->jumlah_tagihan, 0, ',', '.');
        // $formattedTanggalJatuhTempo = Carbon::parse($pelanggan->tanggal_jatuh_tempo)->isoFormat('DD MMMM YYYY');
        // $pelanggan->tanggal_jatuh_tempo = $formattedTanggalJatuhTempo;
        // $pelanggan->jumlah_tagihan = $formattedJumlahTagihan;

        if (!empty($pelanggan)) {
            $formattedJumlahTagihan = number_format($pelanggan->jumlah_tagihan, 0, ',', '.');
            $formattedTanggalJatuhTempo = Carbon::parse($pelanggan->tanggal_jatuh_tempo)->isoFormat('DD MMMM YYYY');
            $pelanggan->tanggal_jatuh_tempo = $formattedTanggalJatuhTempo;
            $pelanggan->jumlah_tagihan = $formattedJumlahTagihan;
        }

        return response()->json([
            'success' => true,
            'message' => 'Data tagihan pelanggan',
            'data' => $pelanggan,
        ], 200);
    }

    public function updatePengirimanLWC(Request $request, $id_pesanan)
    {
        // Validasi request
        $validatedData = $request->validate([
            'gas_masuk' => 'required|integer',
            'sisa_gas' => 'required|integer',
            'tube_volume' => 'required|integer',
        ]);

        // Ambil data pesanan berdasarkan ID dan relasi pengiriman
        $pesanan = Pesanan::with('pengiriman')->find($id_pesanan);

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
            ], 422);
        }

        $pengiriman = $pesanan->pengiriman;

        if ($pengiriman->sisa_gas != null && $pengiriman->kapasitas_gas_keluar != null && $pengiriman->kapasitas_gas_masuk != null) {
            return response()->json([
                'success' => false,
                'message' => 'Data sudah diisi!',
            ], 422);

            // kondisi ingin memasukkan LWC saja
        } else if ($validatedData['sisa_gas'] == 0 && $validatedData['gas_masuk'] == 0) {
            $pengiriman->kapasitas_gas_masuk = null;
            $pengiriman->kapasitas_gas_keluar = null;
            $pengiriman->sisa_gas = null;

            // kondisi ingin memasukkan gas masuk dan LWC saja
        } else if ($validatedData['sisa_gas'] == 0) {
            $pengiriman->kapasitas_gas_masuk = $validatedData['gas_masuk'];
            $pengiriman->kapasitas_gas_keluar = null;
            $pengiriman->sisa_gas = null;

            // kondisi jika inputan sisa gas tidak 0
        } else {

            // kondisi mencegah user mengupdate gas keluar sebelum update gas masuk 
            if ($pengiriman->kapasitas_gas_masuk == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Harap masukkan data gas masuk dahulu!',
                ], 403);

                // kondisi mencegah user mengupdate gas keluar sebelum sopir belum upload bukti gas keluar 
            } else if ($pengiriman->bukti_gas_keluar == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Harap menunggu data foto gas keluar dahulu!',
                ], 403);

                // jika tidak memenuhi semua kondisi maka semua data di update
            } else {
                $pengiriman->kapasitas_gas_masuk = $validatedData['gas_masuk'];
                $pengiriman->kapasitas_gas_keluar = $validatedData['gas_masuk'] - $validatedData['sisa_gas'];
                $pengiriman->sisa_gas = $validatedData['sisa_gas'];

            }

        }

        // Update data pesanan pada tube volume (LWC) dan jumlah bar
        $pesanan->jumlah_bar = $pengiriman->kapasitas_gas_keluar;
        $pesanan->tube_volume = $validatedData['tube_volume'];

        // Simpan perubahan
        $pengiriman->save();
        $pesanan->save();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
        ], 200);
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

        // Ambil id_pelanggan dari transaksi yang diberikan
        $id_pelanggan = Transaksi::where('id_transaksi', $id_transaksi)
            ->pluck('id_pelanggan')
            ->first();

        // Ambil data transaksi lama
        $transaksi_lama = Transaksi::where('id_transaksi', '<', $id_transaksi)
            ->where('id_pelanggan', $id_pelanggan)
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
        $pengiriman_pertama = $transaksi_lama->pesanan->first()->pengiriman;
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
        $jenis_rumus = 'tubin';
        broadcast(new GasKeluarEvent($nama_perusahaan, $jenis_rumus));

        return response()->json([
            'success' => true,
            'message' => 'Data pengiriman berhasil diupdate dengan bukti gas keluar',
            'bukti_gas_masuk' => true,
        ], 200);
    }

    public function uploadTurbin(Request $request, $id_transaksi)
    {
        // Validasi request
        $request->validate([
            'bukti_turbin' => 'required|image|mimes:jpeg,jpg,png',
        ]);

        // Ambil id_pelanggan dari transaksi yang diberikan
        $id_pelanggan = Transaksi::where('id_transaksi', $id_transaksi)
            ->pluck('id_pelanggan')
            ->first();

        // Ambil data transaksi lama
        $transaksi_lama = Transaksi::where('id_transaksi', '<', $id_transaksi)
            ->where('id_pelanggan', $id_pelanggan)
            ->with('pesanan.pengiriman')
            ->orderBy('id_transaksi', 'desc')
            ->first();

        $file = $request->file('bukti_turbin');
        $originalFileName = $file->getClientOriginalName();

        $fileNameGasKeluar = null;

        // Jika ada transaksi lama
        if ($transaksi_lama) {
            // Ambil pengiriman pertama dari transaksi lama
            $pengiriman_lama = $transaksi_lama->pesanan->first()->pengiriman ?? null;

            if ($pengiriman_lama) {
                $nomor_resi = preg_replace('/[^0-9]/', '', $pengiriman_lama->kode_pengiriman);
                $fileNameGasKeluar = $nomor_resi . "_" . $originalFileName;

                // Simpan file untuk gas keluar
                $file->move(public_path('img/GasKeluar'), $fileNameGasKeluar);

                // Update pengiriman lama dengan bukti gas keluar
                $pengiriman_lama->update([
                    'bukti_gas_keluar' => $fileNameGasKeluar,
                ]);
            }

            // Notif Gas Diterima
            $transaksi = Transaksi::find($transaksi_lama->id_transaksi);
            $nama_perusahaan = $transaksi->pelanggan->nama_perusahaan;
            $jenis_rumus = 'turbin';
            broadcast(new GasKeluarEvent($nama_perusahaan, $jenis_rumus));
        }

        // Update transaksi saat ini dengan bukti gas masuk
        $pengiriman_baru = Transaksi::where('id_transaksi', $id_transaksi)
            ->with('pesanan.pengiriman')
            ->first()
            ->pesanan
            ->first()
            ->pengiriman;

        if (!$pengiriman_baru) {
            return response()->json([
                'success' => false,
                'message' => 'Pengiriman tidak ditemukan untuk transaksi ini!',
            ], 422);
        }

        $nomor_resi = preg_replace('/[^0-9]/', '', $pengiriman_baru->kode_pengiriman);
        $fileNameGasMasuk = $nomor_resi . "_" . $originalFileName;

        // Salin file yang sama ke folder `img/GasMasuk`
        $sourcePath = $fileNameGasKeluar ? public_path('img/GasKeluar/' . $fileNameGasKeluar) : null;
        $destinationPath = public_path('img/GasMasuk/' . $fileNameGasMasuk);

        // Jika file berhasil dipindahkan sebelumnya, duplikasi ke folder baru
        if (file_exists($sourcePath)) {
            copy($sourcePath, $destinationPath);

            // Update pengiriman baru dengan bukti gas masuk
            $pengiriman_baru->update([
                'bukti_gas_masuk' => $fileNameGasMasuk,
            ]);
        } else {
            // Simpan file langsung ke `img/GasMasuk` jika file belum ada
            $file->move(public_path('img/GasMasuk'), $fileNameGasMasuk);
            $pengiriman_baru->update([
                'bukti_gas_masuk' => $fileNameGasMasuk,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data pengiriman berhasil diupdate',
            'bukti_turbin_masuk' => true,
            'bukti_turbin_keluar_lama' => $transaksi_lama ? true : false,
        ], 200);
    }

    public function handleTurbinUpload($file, $fileName, $id_transaksi)
    {
        $originalFileName = $file->getClientOriginalName();
        // Ambil id_pelanggan dari transaksi yang diberikan
        $id_pelanggan = Transaksi::where('id_transaksi', $id_transaksi)
            ->pluck('id_pelanggan')
            ->first();

        // Ambil data transaksi lama
        $transaksi_lama = Transaksi::where('id_transaksi', '<', $id_transaksi)
            ->where('id_pelanggan', $id_pelanggan)
            ->with('pesanan.pengiriman')
            ->orderBy('id_transaksi', 'desc')
            ->first();

        // GasMasuk: Selalu pindahkan file ke folder GasMasuk
        $pengiriman_baru = Transaksi::where('id_transaksi', $id_transaksi)
            ->with('pesanan.pengiriman')
            ->first()
            ->pesanan
            ->first()
            ->pengiriman;

        if (!$pengiriman_baru) {
            return false;
        }

        $nomor_resi_baru = preg_replace('/[^0-9]/', '', $pengiriman_baru->kode_pengiriman);
        $fileNameGasMasuk = $nomor_resi_baru . "_" . $originalFileName;

        // Salin file dari BuktiPesanan ke GasMasuk
        $sourcePath = public_path('img/BuktiPesanan/' . $fileName);
        $destinationPath = public_path('img/GasMasuk/' . $fileNameGasMasuk);
        copy($sourcePath, $destinationPath);

        // Update pengiriman baru dengan bukti gas masuk
        $pengiriman_baru->update([
            'bukti_gas_masuk' => $fileNameGasMasuk,
        ]);

        // GasKeluar: Jika ada transaksi lama
        if ($transaksi_lama) {
            $pengiriman_lama = $transaksi_lama->pesanan->first()->pengiriman ?? null;

            if ($pengiriman_lama) {
                $nomor_resi_lama = preg_replace('/[^0-9]/', '', $pengiriman_lama->kode_pengiriman);
                $fileNameGasKeluar = $nomor_resi_lama . "_" . $originalFileName;

                // Salin file dari GasMasuk ke GasKeluar
                $sourcePath = public_path('img/GasMasuk/' . $fileNameGasMasuk);
                $destinationPath = public_path('img/GasKeluar/' . $fileNameGasKeluar);
                copy($sourcePath, $destinationPath);

                // Update pengiriman lama dengan bukti gas keluar
                $pengiriman_lama->update([
                    'bukti_gas_keluar' => $fileNameGasKeluar,
                ]);
            }
        }

        return true;
    }

}