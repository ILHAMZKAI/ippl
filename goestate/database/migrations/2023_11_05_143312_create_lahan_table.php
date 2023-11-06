<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('datalahan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('jumlah_baris');
            $table->integer('jumlah_kolom');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users'); // Sesuaikan dengan nama tabel pengguna Anda (jika ada)
        });
    }

    public function down()
    {
        Schema::dropIfExists('datalahan');
    }
};
