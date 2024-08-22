<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notulen', function (Blueprint $table) {
            $table->id('notulen_id');
            $table->text('text');
            $table->string('jenis_surat');
            $table->string('nomor_surat');
            $table->unsignedBigInteger('jadwal_id')->nullable();
            $table->unsignedBigInteger('pegawai_id')->nullable();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->string('surat_undangan')->nullable();
            $table->string('berkas_absen')->nullable();
            $table->string('berkas_spt')->nullable();
            $table->string('berkas_dokumentasi')->nullable();
            $table->unsignedBigInteger('pic_id')->nullable();
            $table->unsignedBigInteger('penanggung_jawab_id')->nullable();
            $table->unsignedBigInteger('pencatat_id')->nullable();
            $table->timestamps();
            $table->foreign('pic_id')->references('pegawai_id')->on('pegawai')->onDelete('cascade');
            $table->foreign('penanggung_jawab_id')->references('pegawai_id')->on('pegawai')->onDelete('cascade');
            $table->foreign('pencatat_id')->references('pegawai_id')->on('pegawai')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('jadwal_id')->references('jadwal_id')->on('jadwal')->onDelete('cascade');
            $table->foreign('pegawai_id')->references('pegawai_id')->on('pegawai')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notulen');
    }
};
