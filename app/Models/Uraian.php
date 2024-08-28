<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;

class Uraian extends Model
{
    protected $table = 'uraian';
    protected $primaryKey = 'uraian_id';
    protected $fillable = [
        'name_uraian', 'kegiatan_id', 'dpa_id', 'bidang_id',
    ];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($uraian) {
            if ($uraian->jadwal()->count() > 0) {
                throw new Exception("Cannot delete uraian because it has related jadwal records.");
            }
        });
    }

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id', 'kegiatan_id');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'uraian_id', 'uraian_id');
    }

    public function dpa()
    {
        return $this->belongsTo(DPA::class, 'dpa_id', 'dpa_id');
    }

    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id', 'bidang_id');
    }
}