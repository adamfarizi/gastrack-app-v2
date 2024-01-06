<?php
// database/migrations/{timestamp}_create_transaksis_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->string('resi_transaksi');
            $table->dateTime('tanggal_transaksi');
            $table->unsignedBigInteger('id_pelanggan');
            $table->unsignedBigInteger('id_tagihan')->nullable();
            $table->unsignedBigInteger('id_admin');
            $table->timestamps();

            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggan');
            $table->foreign('id_tagihan')->references('id_tagihan')->on('tagihan');
            $table->foreign('id_admin')->references('id_admin')->on('admin');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
