<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('uraian', function (Blueprint $table) {
            $table->id('uraian_id');
            $table->string('name_uraian');
            $table->timestamps();
            $table->unsignedBigInteger('kegiatan_id')->nullable();
            $table->unsignedBigInteger('dpa_id')->nullable();
            $table->unsignedBigInteger('bidang_id')->nullable();

            $table->foreign('kegiatan_id')->references('kegiatan_id')->on('kegiatan')->onDelete('cascade');
            $table->foreign('dpa_id')->references('dpa_id')->on('dpa')->onDelete('cascade');
            $table->foreign('bidang_id')->references('bidang_id')->on('bidang')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('uraian');
    }
};