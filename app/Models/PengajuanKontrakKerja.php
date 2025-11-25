<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanKontrakKerja extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pengajuan_kontrak_kerja';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'kontrak_kerja_id',
        'users_id'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];
    /**
     * Relationships
     */
    public function kontrak_kerja()
    {
        return $this->belongsTo(KontrakKerja::class, 'kontrak_kerja_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    public function kontrak_kerja_diikuti()
    {
        return $this->hasOne(KontrakKerjaDiikuti::class, 'pengajuan_kontrak_kerja_id');
    }
}
