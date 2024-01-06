<?php
// database/migrations/{timestamp}_create_tagihans_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagihanTable extends Migration
{
    public function up()
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id('id_tagihan');
            $table->date('tanggal_jatuh_tempo');
            $table->decimal('jumlah_tagihan', 50, 0);
            $table->enum('status_tagihan',['Sudah Bayar','Belum Bayar','Diproses'])->default('Belum Bayar');
            $table->dateTime('tanggal_pembayaran')->nullable();
            $table->string('bukti_pembayaran')->nullable();
            $table->unsignedBigInteger('id_pelanggan');
            $table->timestamps();

            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggan');
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('tagihan');
    }
}
