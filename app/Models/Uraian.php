<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;

class Uraian extends Model
{
    protected $table = 'uraian';
    protected $primaryKey = 'uraian_id';
    protected $fillable = [
        'name_uraian', 'kegiatan_id',
    ];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($uraian) {
            if ($uraian->jadwal()->count() > 0) {
                throw new Exception("Cannot delete jadwal because it has related jadwal records.");
            }
        });
    }
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id', 'kegiatan_id');
    }
    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'jadwal_id', 'jadwal_id');
    }
}