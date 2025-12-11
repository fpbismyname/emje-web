<?php

namespace App\Models;

use App\Enums\Pelatihan\JenisPembayaranEnum;
use App\Enums\Pelatihan\SkemaPembayaranEnum;
use App\Enums\Pelatihan\StatusPembayaranEnum;
use App\Enums\Pelatihan\StatusPembayaranPelatihanEnum;
use App\Enums\Pelatihan\StatusPendaftaranPelatihanEnum;
use App\Enums\Pelatihan\TenorCicilanPelatihanEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'skema_pembayaran',
        'tenor',
        'catatan',
        'tanggal_pembayaran',
        'users_id',
        'pelatihan_id',
        'gelombang_pelatihan_id'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => StatusPendaftaranPelatihanEnum::class,
        'created_at' => 'datetime',
        'tanggal_pembayaran' => 'datetime',
        'skema_pembayaran' => SkemaPembayaranEnum::class,
        'tenor' => TenorCicilanPelatihanEnum::class,
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
    public function pelatihan_peserta()
    {
        return $this->hasOne(PelatihanPeserta::class, 'pendaftaran_pelatihan_id');
    }
    public function pembayaran_pelatihan()
    {
        return $this->hasMany(PembayaranPelatihan::class, 'pendaftaran_pelatihan_id');
    }
    public function pembayaran_pelatihan_lunas()
    {
        return $this->hasMany(PembayaranPelatihan::class, 'pendaftaran_pelatihan_id')->where('status', StatusPembayaranPelatihanEnum::SUDAH_BAYAR);
    }
    public function pembayaran_pelatihan_dp()
    {
        return $this->hasOne(PembayaranPelatihan::class, 'pendaftaran_pelatihan_id')->latest('tanggal_pembayaran')->search_by_column('jenis_pembayaran', JenisPembayaranEnum::DP);
    }
    public function pembayaran_pelatihan_cash()
    {
        return $this->hasOne(PembayaranPelatihan::class, 'pendaftaran_pelatihan_id')->latest('tanggal_pembayaran')->search_by_column('jenis_pembayaran', JenisPembayaranEnum::CASH);
    }
    public function gelombang_pelatihan()
    {
        return $this->belongsTo(GelombangPelatihan::class, 'gelombang_pelatihan_id');
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
        return $query->where('skema_pembayaran', 'like', $kw)
            ->orWhere('status', 'like', $kw)
            ->orWhere('tenor', 'like', $kw)
            ->orWhere('catatan', 'like', $kw)
            ->orWhereHas('pelatihan', function ($q) use ($kw) {
                $q->where('nama_pelatihan', 'like', $kw);
            })
            ->orWhereHas('users', function ($q) use ($kw) {
                $q->whereHas('profil_user', function ($nqr) use ($kw) {
                    $nqr->where('nama_lengkap', 'like', $kw);
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
    protected $appends = [
        'has_reviewed',
        'formatted_tanggal_dibayar',
        'formatted_nominal_dp_dibayar',
        'formatted_tanggal_dp_dibayar',
        'formatted_tenor_cicilan',
        'users_profil_user_nama_lengkap',
        'pelatihan_nama_pelatihan',
        'pelatihan_nominal_biaya',
        'pelatihan_durasi_pelatihan',
        'pelatihan_kategori_pelatihan',
        'pelatihan_deskripsi_pelatihan',
        'pembayaran_pelatihan_lunas',
        'layak_diterima',
        'formatted_total_biaya_terbayar',
        'decimal_total_biaya_terbayar',
    ];
    /**
     * Accessor
     */
    public function formattedTenorCicilan(): Attribute
    {
        return Attribute::make(
            get: fn() => "{$this->tenor_cicilan->value} Bulan"
        );
    }
    public function usersProfilUserNamaLengkap(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->users?->profil_user?->nama_lengkap ?? "-"
        );
    }
    public function pelatihanNamaPelatihan(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->pelatihan?->formatted_nama_pelatihan ?? "-"
        );
    }
    public function pelatihanNominalBiaya(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->pelatihan?->formatted_nominal_biaya ?? "-"
        );
    }
    public function pelatihanDurasiPelatihan(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->pelatihan?->formatted_durasi_pelatihan ?? "-"
        );
    }
    public function pelatihanKategoriPelatihan(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->pelatihan?->kategori_pelatihan->label() ?? '-'
        );
    }
    public function pelatihanDeskripsiPelatihan(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->pelatihan?->deskripsi ?? '-'
        );
    }
    public function hasReviewed(): Attribute
    {
        return Attribute::make(
            get: fn() => in_array($this->status, [StatusPendaftaranPelatihanEnum::DITERIMA, StatusPendaftaranPelatihanEnum::DITOLAK, StatusPendaftaranPelatihanEnum::DIBATALKAN])
        );
    }
    public function layakDiterima(): Attribute
    {
        $ada_slot_sisa_peserta = $this->pelatihan->gelombang_pelatihan()->each(function (GelombangPelatihan $gelombang) {
            return $gelombang->maksimal_peserta > $gelombang->total_peserta_gelombang;
        });
        return Attribute::make(
            get: fn() => $ada_slot_sisa_peserta
        );
    }
    public function pembayaranPelatihanLunas(): Attribute
    {
        $total_biaya = $this->pelatihan->nominal_biaya;
        $dp_terbayar = $this->pembayaran_pelatihan_dp?->nominal ?? 0;
        $angsuran_terbayar = $this->pembayaran_pelatihan_lunas()->where('jenis_pembayaran', JenisPembayaranEnum::ANGSURAN)->sum('nominal');
        $cash_terbayar = $this->pembayaran_pelatihan_cash?->nominal ?? 0;
        $total_terbayar = $dp_terbayar + $angsuran_terbayar + $cash_terbayar;

        return Attribute::make(
            get: fn() => $total_terbayar >= $total_biaya
        );
    }
    public function decimalTotalBiayaTerbayar(): Attribute
    {
        $total_biaya_terbayar = $this->pembayaran_pelatihan()->where('status', StatusPembayaranPelatihanEnum::SUDAH_BAYAR)->sum('nominal');
        return Attribute::make(
            get: fn() => $total_biaya_terbayar
        );
    }
    public function formattedTotalBiayaTerbayar(): Attribute
    {
        $total_biaya_terbayar = $this->pembayaran_pelatihan()->where('status', StatusPembayaranPelatihanEnum::SUDAH_BAYAR)->sum('nominal');
        return Attribute::make(
            get: fn() => "Rp " . number_format($total_biaya_terbayar, 0, ",", ".")
        );
    }
}
