<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    
    protected $fillable = [
        'tanggal_pesanan',
        'jumlah_bar',
        'jumlah_m3',

        // Perhitungan
        'spesific_gravity',
        'CO2',
        'N2',
        'heating_value',
        'temperature',
        'tube_volume',
        'lwc',

        'harga_pesanan',
        'bop_pesanan',
        'bukti_pesanan',
        'deskripsi_pesanan',
        'id_transaksi',
    ];
    
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }

    public function pengiriman()
    {
        return $this->belongsTo(Pengiriman::class, 'id_pesanan');
    }
}
