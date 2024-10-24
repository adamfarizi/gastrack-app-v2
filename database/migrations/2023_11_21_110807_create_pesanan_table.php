<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->dateTime('tanggal_pesanan');
            $table->integer('jumlah_bar')->nullable()->default('0');
            $table->decimal('jumlah_m3')->nullable()->default('0');

            // Perhitungan
            $table->decimal('spesific_gravity', 10, 2)->nullable()->default(0.75);
            $table->decimal('CO2', 10, 2)->nullable()->default(1.00);
            $table->decimal('N2', 10, 2)->nullable()->default(1.00);
            $table->decimal('heating_value', 15, 5)->nullable()->default(1001.48361);
            $table->integer('temperature')->nullable()->default(21);
            $table->integer('tube_volume')->nullable()->default(0);

            $table->decimal('harga_pesanan', 50, 0)->nullable()->default('0');
            $table->decimal('bop_pesanan', 50, 0)->nullable()->default('0');
            $table->string('bukti_pesanan');
            $table->string('deskripsi_pesanan')->nullable();
            $table->unsignedBigInteger('id_transaksi');
            $table->timestamps();

            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesanan');
    }
};
