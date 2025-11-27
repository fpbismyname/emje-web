<?php

namespace App\Models;

use App\Enums\Pelatihan\StatusPelatihanDiikutiEnum;
use Illuminate\Database\Eloquent\Model;

class PelatihanDiikuti extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pelatihan_diikuti';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'pendaftaran_pelatihan_id',
        'users_id',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => StatusPelatihanDiikutiEnum::class,
    ];
    /**
     * Relationships
     */
    public function pendaftaran_pelatihan()
    {
        return $this->belongsTo(PendaftaranPelatihan::class, 'pendaftaran_pelatihan_id');
    }
    public function sertifikasi()
    {
        return $this->hasOne(Sertifikasi::class, 'pelatihan_diikuti_id');
    }
    public function ujian_pelatihan()
    {
        return $this->hasMany(UjianPelatihan::class, 'pelatihan_diikuti_id');
    }
    public function cicilan_biaya_pelatihan()
    {
        return $this->hasMany(CicilanBiayaPelatihan::class, 'pelatihan_diikuti_id');
    }
}
