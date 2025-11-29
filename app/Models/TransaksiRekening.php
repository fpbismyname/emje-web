<?php

namespace App\Models;

use App\Enums\Rekening\TipeTransaksiEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'keterangan',
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
    /**
     * Scope
     */
    public function scopeSearch($query, $keyword)
    {
        if ($keyword == '' || $keyword == null) {
            return $query;
        }
        $kw = "%{$keyword}%";
        return $query->where('nominal_transaksi', 'like', $kw)
            ->orWhere('keterangan', 'like', $kw)
            ->orWhereHas('rekening', function ($q) use ($kw) {
                $q->where('nama_rekening', $kw);
            });
    }
    public function scopeSearch_by_column(Builder $query, $column, $keyword, $operator = "=")
    {
        $keywords = $operator === 'like' ? "%{$keyword}%" : $keyword;
        if ($keyword == '' || $keyword == null || $column == '' || $column == null) {
            return $query;
        }
        if (is_array($column)) {
            foreach ($column as $col) {
                return $query->whereIn($col, $keywords);
            }
        }
        return $query->where($column, $operator, $keywords);
    }
    /**
     * Appends
     */
    protected $appends = [
        'formatted_tanggal_transaksi',
        'formatted_nominal_transaksi'
    ];
    /**
     * Accessor
     */
    public function formattedTanggalTransaksi(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->created_at->format('d F Y | H:i')
        );
    }

    public function formattedNominalTransaksi(): Attribute
    {
        return Attribute::make(
            get: fn() => "Rp " . number_format($this->nominal_transaksi, 0, ',', '.')
        );
    }
}
