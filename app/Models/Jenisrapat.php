<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Exception;

class Jenisrapat extends Model
{
    protected $table = 'jenis_rapat';
    protected $primaryKey = 'jenis_rapat_id';
    protected $fillable = [
        'jenis_rapat', 
    ];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($jenisrapat) {
            if ($jenisrapat->jadwal()->count() > 0) {
                throw new Exception("Cannot delete Jenis Rapat because it has related Jadwal records.");
            }
        });
    }

    public function jadwal(): HasMany
    {
        return $this->hasMany(Jadwal::class, 'jenis_rapat_id', 'jenis_rapat_id');
    }
}