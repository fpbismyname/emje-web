<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rekening';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_rekening',
        'saldo'
    ];
    /**
     * Relationships
     */
    public function transaksi_rekening()
    {
        return $this->hasMany(TransaksiRekening::class, 'rekening_id');
    }
}
