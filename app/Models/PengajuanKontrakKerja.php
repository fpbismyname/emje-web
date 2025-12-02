<?php

namespace App\Models;

use App\Enums\KontrakKerja\StatusPengajuanKontrakKerja;
use App\Enums\Pelatihan\StatusPendaftaranPelatihanEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'surat_lamaran',
        'catatan',
        'kontrak_kerja_id',
        'users_id'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => StatusPengajuanKontrakKerja::class,
        'created_at' => 'datetime',
    ];
    /**
     * Relationships
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    public function kontrak_kerja()
    {
        return $this->belongsTo(KontrakKerja::class, 'kontrak_kerja_id');
    }
    public function kontrak_kerja_peserta()
    {
        return $this->hasOne(KontrakKerjaPeserta::class, 'pengajuan_kontrak_kerja_id');
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
        return $query->where('status', 'like', $kw)
            ->whereHas('users', fn($q) => $q->whereHas('profil_user', fn($nqr) => $nqr->where('nama_lengkap', $keyword)));
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
        'layak_diterima'
    ];
    /**
     * Accessor
     */
    public function hasReviewed(): Attribute
    {
        return Attribute::make(
            get: fn() => in_array($this->status, [StatusPengajuanKontrakKerja::DITERIMA, StatusPengajuanKontrakKerja::DITOLAK, StatusPengajuanKontrakKerja::DIBATALKAN])
        );
    }

    public function layakDiterima(): Attribute
    {
        $sisaKuota = $this->kontrak_kerja->maksimal_pelamar - $this->kontrak_kerja_peserta()->count();

        return Attribute::make(
            get: fn() => $sisaKuota > 0
        );
    }
}
