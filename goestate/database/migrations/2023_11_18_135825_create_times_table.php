<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('times', function (Blueprint $table) {
            $table->id();
            $table->string('action');
            $table->dateTime('timer');
            $table->unsignedBigInteger('lahan_id');
            $table->unsignedBigInteger('iduser');
            $table->timestamps();

            $table->foreign('iduser')->references('id')->on('users');
            $table->foreign('lahan_id')->references('id')->on('datalahan');
        });
    }

    public function down()
    {
        Schema::dropIfExists('times');
    }
};
