<?php
// app/Models/Kurir.php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Sopir extends Model implements Authenticatable
{
    use AuthenticableTrait, HasApiTokens;
    protected $table = 'sopir';
    protected $primaryKey = 'id_sopir';
    
    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'no_hp',
        'ketersediaan_sopir',
        'status_sopir',
    ];
    
    public function pengirimans()
    {
        return $this->belongsTo(Pengiriman::class, 'id_sopir');
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }
}
