<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Bidang;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';
    protected $primaryKey = 'pegawai_id';
    protected $fillable = [
        'nama_pegawai', 'nip', 'jabatan', 'bidang_id', 'alamat', 'jenis_kelamin', 'no_hp', 'email'
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($pegawai) {
            User::create([
                'name' => $pegawai->nama_pegawai,
                'email' => $pegawai->email,
                'password' => bcrypt('123'), // Ganti dengan kata sandi yang sesuai
                'pegawai_id' => $pegawai->pegawai_id,
                'role' => 'user',
            ]);
        });
    }

    public function user()
    {
        return $this->hasOne(User::class, 'pegawai_id', 'pegawai_id');
    }
    // Display a listing of the resource
    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id');
    }
    
}
