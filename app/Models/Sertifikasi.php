<?php

namespace App\Models;

use App\Enums\Pelatihan\JenisSertifikatEnum;
use Illuminate\Database\Eloquent\Model;

class Sertifikasi extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sertifikasi';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nomor_sertifikat',
        'jenis_sertifikat',
        'sertifikat',
        'tanggal_terbit',
        'pelatihan_diikuti_id'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'jenis_sertifikat' => JenisSertifikatEnum::class,
        'tanggal_terbit' => 'datetime',
        'created_at' => 'datetime'
    ];
    /**
     * Relationships
     */
    // Pelatihan Diikuti
    public function pelatihan_peserta()
    {
        return $this->belongsTo(PelatihanPeserta::class, 'pelatihan_peserta_id');
    }
}
