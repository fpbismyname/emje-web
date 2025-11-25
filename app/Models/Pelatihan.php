<?php

namespace App\Models;

use App\Enums\Pelatihan\KategoriPelatihanEnum;
use Illuminate\Database\Eloquent\Model;

class Pelatihan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pelatihan';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_pelatihan',
        'nominal_biaya',
        'durasi_bulan',
        'kategori_pelatihan',
        'deskripsi',
        'status'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'kategori_pelatihan' => KategoriPelatihanEnum::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function pendaftaran_pelatihan()
    {
        return $this->hasMany(PendaftaranPelatihan::class, 'pelatihan_id');
    }
}
