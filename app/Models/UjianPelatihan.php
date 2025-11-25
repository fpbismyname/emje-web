<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UjianPelatihan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ujian_pelatihan';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_ujian',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'pelatihan_diikuti_id'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];
    /**
     * Relationships
     */
    public function pelatihan()
    {
        return $this->belongsTo(PelatihanDiikuti::class, 'pelatihan_diikuti_id');
    }
}
