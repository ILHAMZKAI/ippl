<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idlahan');
            $table->unsignedBigInteger('id_user');
            $table->string('data_col');
            $table->string('data_row');
            $table->string('warna');
            $table->decimal('berat', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('marks');
    }
};
