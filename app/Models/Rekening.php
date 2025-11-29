<?php

namespace App\Models;

use App\Enums\Rekening\TipeTransaksiEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
    /**
     * Scope
     */
    public function scopeRekening_bendahara($query)
    {
        return $query->where('nama_rekening', 'bendahara');
    }
    /**
     * Appends
     */
    protected $appends = [
        'formatted_inflow_data',
        'formatted_outflow_data',
        'formatted_saldo'
    ];
    /**
     * Accessor
     */
    public function formattedInflowData(): Attribute
    {
        $amount_inflow = $this->transaksi_rekening()->search_by_column('tipe_transaksi', TipeTransaksiEnum::PEMASUKAN)->get()->sum('nominal_transaksi');
        return Attribute::make(
            get: fn() => "Rp " . number_format($amount_inflow, 0, ',', '.')
        );
    }
    public function formattedOutflowData(): Attribute
    {
        $amount_outflow = $this->transaksi_rekening()->search_by_column('tipe_transaksi', TipeTransaksiEnum::PENGELUARAN)->get()->sum('nominal_transaksi');
        return Attribute::make(
            get: fn() => "Rp " . number_format($amount_outflow, 0, ',', '.')
        );
    }
    public function formattedSaldo(): Attribute
    {
        $amount_saldo = $this->saldo ?? 0;
        return Attribute::make(
            get: fn() => "Rp " . number_format($amount_saldo, 0, ',', '.')
        );
    }
}
