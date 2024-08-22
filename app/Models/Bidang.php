<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Exception;

class Bidang extends Model
{
    protected $table = 'bidang';
    protected $primaryKey = 'bidang_id';
    protected $fillable = [
        'name_bidang', 'id_user', 'dpa_id',
    ];
    
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($bidang) {
            if ($bidang->dpas()->count() > 0) {
                throw new Exception("Cannot delete Bidang because it has related dpa records.");
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function dpas(): HasMany
    {
        return $this->hasMany(DPA::class, 'bidang_id', 'bidang_id');
    }
}