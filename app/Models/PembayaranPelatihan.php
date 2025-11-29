<?php

namespace App\Models;

use App\Enums\Pelatihan\JenisPembayaranEnum;
use App\Enums\Pelatihan\StatusPembayaranPelatihanEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class PembayaranPelatihan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pembayaran_pelatihan';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nominal',
        'status',
        'jenis_pembayaran',
        'bukti_pembayaran',
        'catatan',
        'tanggal_pembayaran',
        'pendaftaran_pelatihan_id'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => StatusPembayaranPelatihanEnum::class,
        'created_at' => 'datetime',
        'tanggal_pembayaran' => 'datetime',
        'jenis_pembayaran' => JenisPembayaranEnum::class,
    ];
    /**
     * Relationships
     */
    public function pendaftaran_pelatihan()
    {
        return $this->belongsTo(User::class, 'pendaftaran_pelatihan_id');
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
        return $query->where('nominal', 'like', $kw)
            ->orWhere('status', 'like', $kw)
            ->orWhere('jenis_pembayaran', 'like', $kw)
            ->orWhere('catatan', 'like', $kw)
            ->orWhereHas('pendaftaran_pelatihan', function ($q) use ($kw) {
                $q->whereHas('users', function ($nqr) use ($kw) {
                    $nqr->whereHas('profil_user', function ($nnqr) use ($kw) {
                        $nnqr->where('nama_lengkap', 'like', $kw);
                    });
                })->orWhereHas('pelatihan', function ($nqr) use ($kw) {
                    $nqr->where('nama_pelatihan', 'like', $kw);
                });
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
    protected $appends = ['formatted_nominal'];
    /**
     * Accessor
     */
    public function formattedNominal(): Attribute
    {
        return Attribute::make(
            get: fn() => "Rp " . number_format($this->nominal ?? 0, 0, ",", ".")
        );
    }
}
