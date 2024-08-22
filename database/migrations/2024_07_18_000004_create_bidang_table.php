<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidangTable extends Migration
{
    public function up()
    {
        Schema::create('bidang', function (Blueprint $table) {
            $table->bigIncrements('bidang_id');
            $table->string('name_bidang');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('bidang');
    }
}
