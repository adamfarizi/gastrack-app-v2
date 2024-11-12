<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    use HasFactory;

    protected $table = 'keuangan'; // Nama tabel di database

    protected $primaryKey = 'id_keuangan'; // Primary key dari tabel

    protected $fillable = [
        'jenis',
        'tanggal',
        'deskripsi',
        'jumlah',
        'id_admin',
    ];

    // Relasi ke model Admin
    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin');
    }

}
