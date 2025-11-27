<?php

namespace App\Models;

use App\Enums\KontrakKerja\StatusKontrakKerjaDiikutiEnum;
use Illuminate\Database\Eloquent\Model;

class KontrakKerjaDiikuti extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kontrak_kerja_diikuti';
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
        'status' => StatusKontrakKerjaDiikutiEnum::class,
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
