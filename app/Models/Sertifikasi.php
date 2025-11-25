<?php

namespace App\Models;

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
        'tanggal_terbit',
        'pelatihan_diikuti_id'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_terbit' => 'datetime',
        'created_at' => 'datetime'
    ];
    /**
     * Relationships
     */
    // Pelatihan Diikuti
    public function pelatihan_diikuti()
    {
        return $this->belongsTo(PelatihanDiikuti::class, 'pelatihan_diikuti_id');
    }
}
