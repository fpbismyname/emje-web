<?php

namespace App\Models;

use App\Enums\Pelatihan\StatusHasilUjianPelatihanEnum;
use Illuminate\Database\Eloquent\Model;

class HasilUjianPelatihan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hasil_ujian_pelatihan';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_materi',
        'nilai',
        'status',
        'ujian_pelatihan_id'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => StatusHasilUjianPelatihanEnum::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    /**
     * Relationships
     */
    public function jadwal_ujian_pelatihan()
    {
        return $this->belongsTo(JadwalUjianPelatihan::class, 'jadwal_ujian_pelatihan_id');
    }
}
