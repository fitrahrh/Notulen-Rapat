<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jadwal_pegawai', function (Blueprint $table) {
            $table->id('jadwal_pegawai_id');
            $table->unsignedBigInteger('jadwal_id');
            $table->unsignedBigInteger('pegawai_id');
            $table->timestamps();

            $table->foreign('jadwal_id')->references('jadwal_id')->on('jadwal')->onDelete('cascade');
            $table->foreign('pegawai_id')->references('pegawai_id')->on('pegawai')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwal_pegawai');
    }
};