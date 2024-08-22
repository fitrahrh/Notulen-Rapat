<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'tanggal',
        'waktu',
        'tempat',
        'pimpinan',
        'bagian',
        'kegiatan',
        'pencatat',
        'notulis',
        'notulensi',
    ];
}
