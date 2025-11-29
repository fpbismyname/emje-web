<?php

namespace App\Models;

use App\Enums\Pelatihan\StatusPelatihanPesertaEnum;
use Illuminate\Database\Eloquent\Model;

class PelatihanPeserta extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pelatihan_peserta';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pendaftaran_pelatihan_id',
        'gelombang_pelatihan_id',
        'status',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => StatusPelatihanPesertaEnum::class,
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
        return $this->hasOne(Sertifikasi::class, 'pelatihan_peserta_id');
    }
    public function gelombang_pelatihan()
    {
        return $this->belongsTo(GelombangPelatihan::class, 'gelombang_pelatihan_id');
    }
}
