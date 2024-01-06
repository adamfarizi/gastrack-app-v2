<?php
// database/migrations/{timestamp}_create_sopirs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSopirTable extends Migration
{
    public function up()
    {
        Schema::create('sopir', function (Blueprint $table) {
            $table->id('id_sopir');
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('sopir');
            $table->string('no_hp');
            $table->decimal('bop_sopir', 50, 0)->nullable()->default('0');
            $table->enum('ketersediaan_sopir',['tersedia','tidak tersedia'])->default('tersedia');
            $table->enum('status_sopir',['aktif','tidak aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sopir');
    }
}
