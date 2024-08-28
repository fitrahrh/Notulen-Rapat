<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Exception;

class DPA extends Model
{
    protected $table = 'dpa';
    protected $primaryKey = 'dpa_id';
    protected $fillable = [
        'name_dpa', 'bidang_id',
    ];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($dpa) {
            if ($dpa->kegiatans()->count() > 0) {
                throw new Exception("Cannot delete dpa because it has related kegiatan records.");
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function bidang(): BelongsTo
    {
        return $this->belongsTo(Bidang::class, 'bidang_id', 'bidang_id');
    }

    public function jadwals(): HasMany
    {
        return $this->hasMany(Jadwal::class, 'dpa_id', 'dpa_id');
    }

    public function kegiatans(): HasMany
    {
        return $this->hasMany(Kegiatan::class, 'dpa_id', 'dpa_id');
    }

    public function uraians(): HasMany
    {
        return $this->hasMany(Uraian::class, 'dpa_id', 'dpa_id');
    }
}