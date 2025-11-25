<?php

namespace App\Models;

use App\Enums\Pelatihan\MetodePembayaranEnum;
use Illuminate\Database\Eloquent\Model;

class PendaftaranPelatihan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pendaftaran_pelatihan';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'metode_pembayaran',
        'tanggal_dibayar'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_dibayar' => 'datetime',
        'created_at' => 'datetime',
        'metode_pembayaran' => MetodePembayaranEnum::class,
    ];
    /**
     * Relationships
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    public function pelatihan()
    {
        return $this->belongsTo(Pelatihan::class, 'pelatihan_id');
    }
    public function pelatihan_diikuti()
    {
        return $this->hasOne(PelatihanDiikuti::class, 'pendaftaran_pelatihan_id');
    }
}
