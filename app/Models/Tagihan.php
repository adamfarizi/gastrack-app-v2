<?php
// app/Models/Pembayaran.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $table = 'tagihan';
    protected $primaryKey = 'id_tagihan';
    
    protected $fillable = [
        'tanggal_jatuh_tempo',
        'jumlah_tagihan',
        'status_tagihan',
        'tanggal_pembayaran',
        'bukti_pembayaran',
        'id_pelanggan',
    ];
    
    public function transaksis()
    {
        return $this->belongsTo(Transaksi::class, 'id_tagihan');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }
}
