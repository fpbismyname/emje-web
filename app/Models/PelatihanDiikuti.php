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
    // Users
    public function users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    // Pendaftaran pelatihan
    public function pendaftaran_pelatihan()
    {
        return $this->belongsTo(PendaftaranPelatihan::class, 'pendaftaran_pelatihan_id');
    }
    // Pelatihan
    public function pelatihan()
    {
        return $this->hasOneThrough(
            Pelatihan::class,
            PendaftaranPelatihan::class,
            'id',
            'id',
            'pendaftaran_pelatihan_id',
            'pelatihan_id'
        );
    }
    // Sertifikasi
    public function sertifikasi()
    {
        return $this->hasOne(Sertifikasi::class, 'pelatihan_diikuti_id');
    }
}
