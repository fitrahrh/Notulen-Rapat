<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('tempat');
            $table->string('pimpinan');
            $table->string('bagian');
            $table->string('kegiatan');
            $table->string('pencatat');
            $table->string('notulis');
            $table->text('notulensi');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reports');
    }
}

