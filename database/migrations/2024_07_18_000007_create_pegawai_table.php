<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id('pegawai_id');
            $table->string('nama_pegawai');
            $table->string('nip')->unique();
            $table->string('jabatan');
            $table->unsignedBigInteger('bidang_id')->nullable();
            $table->text('alamat');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('no_hp');
            $table->string('email')->unique();
            $table->timestamps();
            $table->foreign('bidang_id')->references('bidang_id')->on('bidang')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pegawai');
    }
};
