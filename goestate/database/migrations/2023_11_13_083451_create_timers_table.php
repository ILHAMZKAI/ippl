<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('times_lahan', function (Blueprint $table) {
            $table->id();
            $table->string('action');
            $table->dateTime('timer');
            $table->unsignedBigInteger('lahan_id');
            $table->unsignedBigInteger('iduser');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('times_lahan');
    }
};
