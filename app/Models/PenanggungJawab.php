<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenanggungJawab extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_penanggung_jawab';

    protected $fillable = [
        'name_penanggung_jawab',
    ];
}
