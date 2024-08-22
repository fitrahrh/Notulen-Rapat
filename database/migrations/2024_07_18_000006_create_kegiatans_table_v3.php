<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id('kegiatan_id');
            $table->string('name_kegiatan');
            $table->timestamps();
            $table->unsignedBigInteger('dpa_id')->nullable();
            $table->foreign('dpa_id')->references('dpa_id')->on('dpa')->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('kegiatan');
    }
};