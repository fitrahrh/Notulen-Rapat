<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatedpaTable extends Migration
{
    public function up()
    {
        Schema::create('dpa', function (Blueprint $table) {
            $table->id('dpa_id');
            $table->string('name_dpa');
            $table->timestamps();
            $table->unsignedBigInteger('bidang_id')->nullable();
            $table->foreign('bidang_id')->references('bidang_id')->on('bidang')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dpa');
    }
}