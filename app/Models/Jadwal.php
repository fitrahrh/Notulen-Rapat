<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Exception;

class Jadwal extends Model
{
    protected $table = 'jadwal';
    protected $primaryKey = 'jadwal_id';
    protected $fillable = [
        'name_rapat',
        'jenis_rapat', 
        'tanggal', 
        'jam_mulai',
        'jam_selesai',
        'tempat_rapat',
        'mbis', 
        'rolan', 
        'verifikasi', 
        'keterangan', 
        'dpa_id', 
        'kegiatan_id',
        'uraian_id',
        'notulen_id',
    ];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($jadwal) {
            if ($jadwal->notulen()->count() > 0) {
                throw new Exception("Cannot delete jadwal because it has related notulen records.");
            }
        });
    }
    

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function dpa()
    {
        return $this->belongsTo(dpa::class, 'dpa_id', 'dpa_id');
    }

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id', 'kegiatan_id');
    }

    public function notulen()
    {
        return $this->hasMany(Notulen::class, 'notulen_id', 'notulen_id');
    }

    public function uraian()
    {
        return $this->belongsTo(Uraian::class, 'uraian_id', 'uraian_id');
    }

}