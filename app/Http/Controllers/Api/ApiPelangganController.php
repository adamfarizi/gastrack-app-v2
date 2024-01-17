<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Http\Resources\PostResource;
use App\Models\Pesanan;
use App\Models\Tagihan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;


class ApiPelangganController extends Controller
{
    public function index($id)
    {
        $pelanggan = Pelanggan::find($id);

        if ($pelanggan) {
            return new PostResource(true, 'Get Berhasil', $pelanggan);
        } else {
            return response()->json(["message" => "Not Found 404"], 404);
        }
    }

    public function login_action(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $pelanggan = Pelanggan::where('email', $request->email)->first();

        if (!$pelanggan) {
            return response()->json([
                'success' => false,
                'message' => 'Akun tidak terdaftar!',
            ], 404);
        }

        // Verifikasi password
        if (password_verify($request->password, $pelanggan->password)) {
            // Periksa apakah pengguna sudah login di perangkat lain
            if ($pelanggan->tokens()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengguna sudah masuk di perangkat lain.',
                ], 422);
            } else {

                // Buat token untuk perangkat saat ini
                $token = $pelanggan->createToken('myappToken')->plainTextToken;

                return response()->json([
                    'success' => true,
                    'token' => $token,
                    'datauser' => $pelanggan,
                ], 200);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Kombinasi email dan password tidak valid!',
            ], 422);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            // Revoke the user's access tokens
            $user->tokens()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil.',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal logout. Pengguna tidak ditemukan.',
            ], 401);
        }
    }

    public function detail_user(string $id)
    {
        $pelanggan = Pelanggan::where('id_pelanggan', $id)->first();

        if (empty($pelanggan)) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
            ], 422);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditemukan',
                'datauser' => $pelanggan,
            ], 200);
        }
    }

    public function edit_index(string $id)
    {
        $pelanggan = Pelanggan::where('id_pelanggan', $id)->first();

        if (empty($pelanggan)) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
            ], 422);
        } else {
            $pelanggan->no_hp = $this->hidePhoneNumber($pelanggan->no_hp);
            $pelanggan->email = $this->encryptEmail($pelanggan->email);
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditemukan',
                'datauser' => $pelanggan,
            ], 200);
        }
    }

    public function edit_action(string $id, Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'alamat' => 'required|string|max:255',
                'no_hp' => 'required|string|max:15',
            ]);

            $pelanggan = Pelanggan::find($id);
            if (empty($pelanggan)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan!',
                ], 422);
            }

            $pelanggan->nama = $request->input('nama');
            $pelanggan->email = $request->input('email');
            $pelanggan->no_hp = $request->input('no_hp');
            $pelanggan->alamat = $request->input('alamat');
            $pelanggan->save();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diubah',
                'datauser' => $pelanggan,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->validator->errors()->all(),
            ], 422);
        }
    }

    public function edit_name(string $id, Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            // Lanjutkan dengan operasi lain jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->validator->errors()->all(),
            ], 422);
        }

        $pelanggan = Pelanggan::find($id);
        if (empty($pelanggan)) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
            ], 422);
        }

        $pelanggan->nama_pemilik = $request->input('name');
        $pelanggan->save();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diubah',
            'datauser' => $pelanggan,
        ], 200);
    }

    public function edit_perusahaan(string $id, Request $request)
    {
        try {
            $request->validate([
                'perusahaan' => 'required|string|max:255',
            ]);

            // Lanjutkan dengan operasi lain jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->validator->errors()->all(),
            ], 422);
        }

        $pelanggan = Pelanggan::find($id);
        if (empty($pelanggan)) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
            ], 422);
        }

        $pelanggan->nama_perusahaan = $request->input('perusahaan');
        $pelanggan->save();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diubah',
            'datauser' => $pelanggan,
        ], 200);
    }

    public function edit_email(string $id, Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|max:255',
            ]);

            // Check if the new email already exists
            $existingEmail = Pelanggan::where('email', $request->input('email'))->first();
            if ($existingEmail) {
                if ($existingEmail['id_pelanggan'] == $id) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda tidak melakukan perubahan email.',
                    ], 422);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Email sudah terdaftar.',
                    ], 422);
                }
            }

            $pelanggan = Pelanggan::find($id);
            if (empty($pelanggan)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan!',
                ], 422);
            }

            $pelanggan->email = $request->input('email');
            $pelanggan->save();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diubah',
                'datauser' => $pelanggan,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->validator->errors()->all(),
            ], 422);
        }
    }

    public function edit_no_hp(string $id, Request $request)
    {
        try {
            $request->validate([
                'no_hp' => 'required|string|max:15',
            ]);

            // Lanjutkan dengan operasi lain jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->validator->errors()->all(),
            ], 422);
        }

        $pelanggan = Pelanggan::find($id);
        if (empty($pelanggan)) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
            ], 422);
        }

        $pelanggan->no_hp = $request->input('no_hp');
        $pelanggan->save();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diubah',
            'datauser' => $pelanggan,
        ], 200);
    }

    public function edit_alamat(string $id, Request $request)
    {
        try {
            $request->validate([
                'alamat' => 'required|string|max:255',
                'koordinat' => 'required|string|max:255',
            ]);

            // Lanjutkan dengan operasi lain jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->validator->errors()->all(),
            ], 422);
        }

        $pelanggan = Pelanggan::find($id);
        if (empty($pelanggan)) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
            ], 422);
        }

        $pelanggan->alamat = $request->input('alamat');
        $pelanggan->koordinat = $request->input('koordinat');
        $pelanggan->save();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diubah',
            'datauser' => $pelanggan,
        ], 200);
    }

    public function edit_password(string $id, Request $request)
    {
        try {
            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required',
                'new_password_confirmation' => 'required',
            ]);

            // Lanjutkan dengan operasi lain jika validasi berhasil
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->validator->errors()->all(),
            ], 422);
        }

        $old_password = $request->input('old_password');
        $passwordInDatabase = Pelanggan::where('id_pelanggan', $id)->pluck('password')->first();

        if (Hash::check($old_password, $passwordInDatabase)) {
            $new_password = $request->input('new_password');
            $new_password_confirmation = $request->input('new_password_confirmation');

            if ($new_password == $new_password_confirmation) {
                $pelanggan = Pelanggan::find($id);
                $pelanggan->password = Hash::make($new_password); // Menghash password baru
                $pelanggan->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Password berhasil diubah!',
                    'datauser' => $pelanggan,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Konfirmasi password tidak cocok!',
                ], 422);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Password lama tidak cocok!',
            ], 422);
        }
    }

    public function getTransaksi($id_pelanggan)
    {
        $cek_data = Transaksi::where('id_pelanggan', $id_pelanggan)->first();

        $transaksi = Transaksi::where('transaksi.id_pelanggan', $id_pelanggan)
            ->join('pelanggan', 'transaksi.id_pelanggan', '=', 'pelanggan.id_pelanggan')
            ->join('tagihan', 'transaksi.id_tagihan', '=', 'tagihan.id_tagihan');

        if (empty($cek_data)) {
            return response()->json([
                'success' => false,
                'message' => 'Belum ada transaksi',
            ], 422);
        } else {
            $data = $transaksi
                ->select(
                    'transaksi.id_transaksi',
                    'transaksi.resi_transaksi',
                    'tagihan.jumlah_tagihan',
                    'tagihan.status_tagihan',
                )->get();

            $formattedResult = $data->map(function ($item) {
                return [
                    'id_transaksi' => $item->id_transaksi,
                    'resi' => $item->resi_transaksi,
                    'total_tagihan' => number_format($item->jumlah_tagihan, 0, ',', '.'),
                    'status_pembayaran' => $item->status_tagihan,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditemukan',
                'data' => $formattedResult,
            ], 200);
        }
    }

    public function getDetailTransaksi($id_transaksi)
    {
        $transaksi = Transaksi::where('transaksi.id_transaksi', $id_transaksi)
            ->join('pelanggan', 'transaksi.id_pelanggan', '=', 'pelanggan.id_pelanggan')
            ->join('tagihan', 'transaksi.id_tagihan', '=', 'tagihan.id_tagihan')
            ->join('pesanan', 'transaksi.id_transaksi', '=', 'pesanan.id_transaksi');

        if (empty($transaksi)) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
            ], 422);
        } else {
            $pesanan_awal = Pesanan::select('tanggal_pesanan', 'jumlah_bar', 'harga_pesanan',)
                ->where('id_transaksi', $id_transaksi)->orderBy('tanggal_pesanan', 'asc')->first();
            $pesanan_akhir = Pesanan::select('tanggal_pesanan', 'jumlah_bar', 'harga_pesanan',)
                ->where('id_transaksi', $id_transaksi)->orderBy('tanggal_pesanan', 'desc')->first();
            $pesanan = Pesanan::select('tanggal_pesanan', 'jumlah_bar', 'harga_pesanan',)
                ->where('id_transaksi', $id_transaksi)->get();
            Carbon::setLocale('id');
            $formattedJumlahTagihan = number_format($pesanan_awal->harga_pesanan, 0, ',', '.');
            $formattedTanggalJatuhTempo = Carbon::parse($pesanan_awal->tanggal_pesanan)->isoFormat('DD MMMM YYYY');

            $formattedJumlahTagihanPesanan = number_format($pesanan_akhir->harga_pesanan, 0, ',', '.');
            $formattedTanggalPesanan = Carbon::parse($pesanan_akhir->tanggal_pesanan)->isoFormat('DD MMMM YYYY');

            $pesanan_akhir->tanggal_pesanan = $formattedTanggalPesanan;
            $pesanan_akhir->harga_pesanan = $formattedJumlahTagihanPesanan;
            $pesanan_awal->tanggal_pesanan = $formattedTanggalJatuhTempo;
            $pesanan_awal->harga_pesanan = $formattedJumlahTagihan;

            $formattedPesanan = $pesanan->map(function ($item) {
                return [
                    'tanggal_pesanan' => Carbon::parse($item->tanggal_pesanan)->isoFormat('DD MMMM YYYY'),
                    'jumlah_bar' => $item->jumlah_bar,
                    'harga_pesanan' => number_format($item->harga_pesanan, 0, ',', '.'),
                ];
            });

            $data = $transaksi
                ->select(
                    'transaksi.resi_transaksi AS resi',
                    'pelanggan.nama_perusahaan AS pelanggan',
                    'pelanggan.no_hp',
                    'pelanggan.alamat AS alamat',
                    'tagihan.jumlah_tagihan AS total_tagihan',
                    'pesanan.tanggal_pesanan',
                    'pesanan.jumlah_bar',
                    'pesanan.harga_pesanan',
                )->first();

            $formattedData = [
                'resi' => $data->resi,
                'pelanggan' => $data->pelanggan,
                'no_hp' => $data->no_hp,
                'alamat' => $data->alamat,
                'pesanan_awal' => $pesanan_awal,
                'pesanan_akhir' => $pesanan_akhir,
                'pesanan' => $formattedPesanan
            ];

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditemukan',
                'data' => $formattedData,
            ], 200);
        }
    }

    private function hidePhoneNumber($phoneNumber)
    {
        // Menyembunyikan karakter kecuali 4 digit terakhir
        $visibleDigits = 4;
        $length = strlen($phoneNumber);

        if ($length <= $visibleDigits) {
            return $phoneNumber;
        }

        $hiddenPart = str_repeat('*', $length - $visibleDigits);
        $visiblePart = substr($phoneNumber, -$visibleDigits);

        return $hiddenPart . $visiblePart;
    }

    private function encryptEmail($email)
    {
        $emailParts = explode('@', $email);

        if (count($emailParts) === 2) {
            $username = $emailParts[0];
            $domain = $emailParts[1];

            // Enkripsi huruf di tengah
            $encryptedUsername = $this->encryptMiddle($username);

            // Gabungkan kembali
            $encryptedEmail = $encryptedUsername . '@' . $domain;

            return $encryptedEmail;
        }

        return $email;
    }

    private function encryptMiddle($text)
    {
        $length = strlen($text);

        if ($length <= 2) {
            return $text;
        }

        $start = substr($text, 0, 1);
        $end = substr($text, -1);

        $middle = str_repeat('*', $length - 2);

        return $start . $middle . $end;
    }
}
