<?php
// database/migrations/{timestamp}_create_pelanggans_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelangganTable extends Migration
{
    public function up()
    {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id('id_pelanggan');
            $table->string('nama_perusahaan');
            $table->string('nama_pemilik');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('pelanggan');
            $table->string('alamat')->nullable();
            $table->string('koordinat')->nullable();
            $table->string('no_hp')->nullable();
            $table->decimal('bop_pelanggan', 50, 0);
            $table->decimal('harga_pelanggan', 50, 0);
            $table->enum('jenis_pembayaran',['2', '3', '4'])->nullable();
            $table->enum('status',['aktif', 'tidak aktif'])->default('aktif');
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('pelanggan');
    }
}
