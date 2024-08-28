<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Exception;

class Kegiatan extends Model
{
    protected $table = 'kegiatan';
    protected $primaryKey = 'kegiatan_id';
    protected $fillable = [
        'name_kegiatan', 'dpa_id',
    ];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($kegiatan) {
            if ($kegiatan->uraians()->count() > 0) {
                throw new Exception("Cannot delete kegiatan because it has related uraian records.");
            }
        });
    }

    public function dpa(): BelongsTo
    {
        return $this->belongsTo(DPA::class, 'dpa_id', 'dpa_id');
    }

    public function uraians(): HasMany
    {
        return $this->hasMany(Uraian::class, 'kegiatan_id', 'kegiatan_id');
    }
}