<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPayment extends Model
{
    use HasFactory;

    protected $table = 'master_payment';
    
    protected $primaryKey = 'id_master';

    protected $fillable = [
        'nama_master',
        'bank_master',
        'kcu_master',
        'account_master',
    ];

    public $timestamps = true;
}
