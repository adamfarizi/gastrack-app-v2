<?php

use App\Http\Controllers\Api\ApiPelangganController;
use App\Http\Controllers\Api\ApiPembelianController;
use App\Http\Controllers\Api\ApiSopirController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/pelanggan/login', [ApiPelangganController::class, 'login_action']);
Route::post('/sopir/login', [ApiSopirController::class, 'login_action']);

Route::middleware(['auth:sanctum', 'check.pelanggan'])->group(function () {
    Route::post('/pelanggan/logout', [ApiPelangganController::class, 'logout']);
    Route::get('/pelanggan/update/{id}', [ApiPelangganController::class, 'edit_index']);    
    Route::get('/pelanggan/detail/{id}', [ApiPelangganController::class, 'detail_user']);
    Route::put('/pelanggan/update/{id}', [ApiPelangganController::class, 'edit_action']);
    Route::put('/pelanggan/update/perusahaan/{id}', [ApiPelangganController::class, 'edit_perusahaan']);
    Route::put('/pelanggan/update/name/{id}', [ApiPelangganController::class, 'edit_name']);
    Route::put('/pelanggan/update/email/{id}', [ApiPelangganController::class, 'edit_email']);
    Route::put('/pelanggan/update/no_hp/{id}', [ApiPelangganController::class, 'edit_no_hp']);
    Route::put('/pelanggan/update/alamat/{id}', [ApiPelangganController::class, 'edit_alamat']);    
    Route::put('/pelanggan/update/password/{id}', [ApiPelangganController::class, 'edit_password']);
    Route::get('/pelanggan/index/{id}', [ApiPembelianController::class, 'index_transaksi']);
    Route::get('/pelanggan/transaksi/{id}', [ApiPelangganController::class, 'getTransaksi']);
    Route::get('/pelanggan/detailtransaksi/{id}', [ApiPelangganController::class, 'getDetailTransaksi']);
    Route::get('/pembelian/belum_bayar', [ApiPembelianController::class, 'transaksi_belum_bayar']);
    Route::get('/pembelian/sudah_bayar', [ApiPembelianController::class, 'transaksi_sudah_bayar']);
    Route::post('/pelanggan/pembelian', [ApiPembelianController::class, 'create_transaksi']);
    Route::post('/pelanggan/update_pembayaran/{id}', [ApiPembelianController::class, 'update_pembayaran']);    
    Route::get('/pelanggan/tagihan/{id}', [ApiPembelianController::class, 'index_tagihanPelanggan']);
});

Route::middleware(['auth:sanctum', 'check.sopir'])->group(function(){
    Route::get('/sopir/index', [ApiSopirController::class, 'index']);
    Route::post('/sopir/logout', [ApiSopirController::class, 'logout']);
    Route::get('/sopir/detail/{id}', [ApiSopirController::class, 'detail_sopir']);
    Route::get('/sopir/update/{id}', [ApiSopirController::class, 'edit_index']);
    Route::put('/sopir/update/name/{id}', [ApiSopirController::class, 'edit_name']);
    Route::put('/sopir/update/email/{id}', [ApiSopirController::class, 'edit_email']);
    Route::put('/sopir/update/no_hp/{id}', [ApiSopirController::class, 'edit_no_hp']);
    Route::put('/sopir/update/password/{id}', [ApiSopirController::class, 'edit_password']);
    Route::get('/sopir/pengiriman/{id}', [ApiSopirController::class, 'getDataPengiriman']);
    Route::get('/sopir/detailpengiriman/{id}', [ApiSopirController::class, 'getDataDetailPengiriman']);
    Route::post('/sopir/update_gas_masuk/{id}', [ApiSopirController::class, 'gas_masuk']);
    Route::post('/sopir/update_gas_keluar/{id}', [ApiSopirController::class, 'gas_keluar']);
    Route::post('/sopir/penarikanbop/{id}', [ApiSopirController::class, 'penarikanbop']);
    Route::get('/sopir/riwayat_penarikanbop/{id}', [ApiSopirController::class, 'riwayatpenarikanbop']);
});