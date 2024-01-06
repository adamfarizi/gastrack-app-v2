<?php
// database/migrations/{timestamp}_create_mobils_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobilTable extends Migration
{
    public function up()
    {
        Schema::create('mobil', function (Blueprint $table) {
            $table->id('id_mobil');
            $table->string('identitas_mobil');
            $table->string('nopol_mobil');
            $table->string('jenis_mobil')->nullable();
            $table->enum('ketersediaan_mobil',['tersedia','tidak tersedia'])->default('tersedia');
            $table->enum('status_mobil',['aktif','tidak aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mobil');
    }
}
