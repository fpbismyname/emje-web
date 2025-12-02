<?php

namespace App\Models;

use App\Enums\KontrakKerja\StatusKontrakKerjaPesertaEnum;
use Illuminate\Database\Eloquent\Model;

class KontrakKerjaPeserta extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kontrak_kerja_peserta';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'kontrak_kerja_id',
        'users_id',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => StatusKontrakKerjaPesertaEnum::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    /**
     * Relationships
     */
    public function pengajuan_kontrak_kerja()
    {
        return $this->belongsTo(PengajuanKontrakKerja::class, 'pengajuan_kontrak_kerja_id');
    }
}
