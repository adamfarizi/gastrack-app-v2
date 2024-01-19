<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penarikanbop extends Model
{
    protected $table = 'penarikanbop';
    protected $primaryKey = 'id_penarikan';
    
    protected $fillable = [
        'kode_penarikan',
        'tanggal_penarikan',
        'jumlah_penarikan',
        'tanggal_pengambilan',
        'status_penarikan',
        'id_sopir',
        'id_admin',
    ];
    
    public function sopir()
    {
        return $this->belongsTo(Sopir::class, 'id_sopir', 'id_sopir');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin');
    }
}
