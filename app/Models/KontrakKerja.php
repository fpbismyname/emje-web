<?php

namespace App\Models;

use App\Enums\KontrakKerja\StatusKontrakKerjaEnum;
use Illuminate\Database\Eloquent\Model;

class KontrakKerja extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kontrak_kerja';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_perusahaan',
        'gaji_terendah',
        'gaji_tertinggi',
        'status',
        'durasi_kontrak_kerja'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => StatusKontrakKerjaEnum::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    /**
     * Relationships
     */
    public function pengajuan_kontrak_kerja()
    {
        return $this->hasMany(PengajuanKontrakKerja::class, 'kontrak_kerja_id');
    }
}
