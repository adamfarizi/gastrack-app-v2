<?php
// app/Models/Agen.php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Pelanggan extends Model implements Authenticatable
{
    use AuthenticableTrait, HasApiTokens;
    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    
    protected $fillable = [
        'nama_perusahaan',
        'nama_pemilik',
        'email',
        'password',
        'role',
        'alamat',
        'koordinat',
        'no_hp',
        'bop_pelanggan',
        'harga_pelanggan',
        'jenis_pembayaran',
        'status',
    ];
    
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_pelanggan');
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

}
