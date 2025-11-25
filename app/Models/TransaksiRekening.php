<?php

namespace App\Models;

use App\Enums\Rekening\TipeTransaksiEnum;
use Illuminate\Database\Eloquent\Model;

class TransaksiRekening extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transaksi_rekening';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nominal_transaksi',
        'catatan',
        'tipe_transaksi',
        'rekening_id'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tipe_transaksi' => TipeTransaksiEnum::class,
        'created_at' => 'datetime'
    ];
    /**
     * Relationship
     */
    public function rekening()
    {
        return $this->belongsTo(Rekening::class, 'rekening_id');
    }
}
