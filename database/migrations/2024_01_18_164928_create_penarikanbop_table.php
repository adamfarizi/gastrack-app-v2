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
        Schema::create('penarikanbop', function (Blueprint $table) {
            $table->id('id_penarikan');
            $table->string('kode_penarikan');
            $table->dateTime('tanggal_penarikan');
            $table->decimal('jumlah_penarikan', 50, 0);
            $table->dateTime('tanggal_pengambilan')->nullable();
            $table->enum('status_penarikan',['Sudah Tarik','Belum Tarik'])->default('Belum Tarik');
            $table->unsignedBigInteger('id_sopir')->nullable();
            $table->unsignedBigInteger('id_admin')->nullable();
            $table->timestamps();

            $table->foreign('id_sopir')->references('id_sopir')->on('sopir');
            $table->foreign('id_admin')->references('id_admin')->on('admin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penarikanbop');
    }
};
