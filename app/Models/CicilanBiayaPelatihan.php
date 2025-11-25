<?php

namespace App\Models;

use App\Enums\Pelatihan\CicilanBiayaPelatihanEnum;
use Illuminate\Database\Eloquent\Model;

class CicilanBiayaPelatihan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cicilan_biaya_pelatihan';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nominal_cicilan',
        'status',
        'pelatihan_diikuti_id'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => CicilanBiayaPelatihanEnum::class,
    ];
    /**
     * Relationships
     */
    public function pelatihan_diikuti()
    {
        return $this->belongsTo(PelatihanDiikuti::class, 'pelatihan_diikuti_id');
    }
}
