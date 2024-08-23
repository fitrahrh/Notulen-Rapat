<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jenis_rapat', function (Blueprint $table) {
            $table->id('jenis_rapat_id');
            $table->string('jenis_rapat');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jenis_rapat');
    }
};