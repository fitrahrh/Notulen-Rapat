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
            $table->foreign('kegiatan_id')->references('kegiatan_id')->on('kegiatan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('uraian');
    }
};