<?php
// app/Models/Admin.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory;
    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    
    protected $fillable = [
        'nama',
        'email',
        'role',
        'password',
    ];
    
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_admin');
    }

    public function penarikanbop()
    {
        return $this->hasMany(Penarikanbop::class, 'id_admin');
    }
}
