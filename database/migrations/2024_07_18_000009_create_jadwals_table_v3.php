<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalsTableV3 extends Migration
{
    public function up()
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id('jadwal_id');
            $table->string('name_rapat');
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('tempat_rapat');
            $table->bigInteger('mbis')-> nullable();
            $table->enum('rolan',['Sudah diambil','belum diambil'])->nullable();
            $table->enum('verifikasi',['Belum','Sudah'])->nullable();
            $table->text('keterangan');
            $table->unsignedBigInteger('jenis_rapat_id')->nullable();
            $table->unsignedBigInteger('dpa_id')->nullable();
            $table->unsignedBigInteger('kegiatan_id')->nullable();
            $table->unsignedBigInteger('uraian_id')->nullable();

            $table->foreign('jenis_rapat_id')->references('jenis_rapat_id')->on('jenis_rapat')->onDelete('cascade');
            $table->foreign('dpa_id')->references('dpa_id')->on('dpa')->onDelete('cascade');
            $table->foreign('kegiatan_id')->references('kegiatan_id')->on('kegiatan')->onDelete('cascade');
            $table->foreign('uraian_id')->references('uraian_id')->on('uraian')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwal');
    }
}