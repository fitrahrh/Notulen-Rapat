<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('ttd')->nullable();
            $table->unsignedBigInteger('pegawai_id')->nullable();
            $table->foreign('pegawai_id')->references('pegawai_id')->on('pegawai')->onDelete('cascade');

        });
        Schema::table('jadwal', function (Blueprint $table) {
            $table->unsignedBigInteger('notulen_id')->nullable();
            $table->foreign('notulen_id')->references('notulen_id')->on('notulen')->onDelete('cascade');
        });
    }

};
