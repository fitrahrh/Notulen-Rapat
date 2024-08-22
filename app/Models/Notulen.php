<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notulen extends Model
{
    protected $table = 'notulen';
    protected $primaryKey = 'notulen_id';
    protected $fillable = [
        'text',
        'jenis_surat',
        'nomor_surat',
        'surat_undangan',
        'berkas_absen',
        'berkas_spt',
        'berkas_dokumentasi',
        'pic_id',
        'penanggung_jawab_id',
        'pencatat_id',
        'jadwal_id',
        'pegawai_id',
        'id_user'
    ];

    protected static function boot(){
        parent::boot();
    
        static::created(function($notulen){
            Jadwal::where('jadwal_id', $notulen->jadwal_id)->update([
                'notulen_id' => $notulen->notulen_id,
            ]);
        });
    
        static::updated(function($notulen){
            Jadwal::where('jadwal_id', $notulen->jadwal_id)->update([
                'notulen_id' => $notulen->notulen_id,
            ]);
        });
    }    public function pic()
    {
        return $this->belongsTo(Pegawai::class, 'pic_id');
    }
    public function pencatat()
    {
        return $this->belongsTo(Pegawai::class, 'pencatat_id');
    }
    public function penanggung_jawab()
    {
        return $this->belongsTo(Pegawai::class, 'penanggung_jawab_id');
    }

    public function jadwal()
    {
        return $this->hasOne(Jadwal::class, 'jadwal_id', 'jadwal_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id', 'pegawai_id');
    }
}