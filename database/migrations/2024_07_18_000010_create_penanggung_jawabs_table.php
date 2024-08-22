<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenanggungJawabsTable extends Migration
{
    public function up()
    {
        Schema::create('penanggung_jawabs', function (Blueprint $table) {
            $table->id('id_penanggung_jawab');
            $table->string('name_penanggung_jawab');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penanggung_jawabs');
    }
}
