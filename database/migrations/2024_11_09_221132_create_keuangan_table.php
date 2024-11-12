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
        Schema::create('keuangan', function (Blueprint $table) {
            $table->id('id_keuangan');
            $table->enum('jenis', ['debet', 'kredit']);
            $table->dateTime('tanggal');
            $table->string('deskripsi')->nullable();
            $table->decimal('jumlah', 50, 0)->default(0);
            $table->unsignedBigInteger('id_admin');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('id_admin')->references('id_admin')->on('admin')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keuangan');
    }
};
