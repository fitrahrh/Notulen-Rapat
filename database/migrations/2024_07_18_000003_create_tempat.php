<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tempat_rapat', function (Blueprint $table) {
            $table->id('tempat_id');
            $table->string('name_tempat');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tempat_rapat');
    }
};