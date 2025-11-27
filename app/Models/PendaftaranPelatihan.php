<?php

namespace App\Models;

use App\Enums\Pelatihan\MetodePembayaranEnum;
use App\Enums\Pelatihan\StatusPendaftaranPelatihanEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'bukti_pembayaran',
        'metode_pembayaran',
        'tanggal_dibayar',
        'users_id',
        'pelatihan_id'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => StatusPendaftaranPelatihanEnum::class,
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
    /**
     * Scope
     */
    public function scopeSearch($query, $keyword)
    {
        if ($keyword == '' || $keyword == null) {
            return $query;
        }
        $kw = "%{$keyword}%";
        return $query->where('metode_pembayaran', 'like', $kw)
            ->orWhere('status', 'like', $kw)
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
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'link_bukti_pembayaran',
        'formatted_tanggal_dibayar',
        'users_profil_user_nama_lengkap',
        'pelatihan_nama_pelatihan',
        'pelatihan_nominal_biaya',
        'pelatihan_durasi_bulan',
        'pelatihan_kategori_pelatihan',
        'pelatihan_deskripsi_pelatihan',
    ];
    /**
     * Accessor
     */
    public function linkBuktiPembayaran(): Attribute
    {
        $private_storage = Storage::disk('local');
        return Attribute::make(
            get: fn() => $private_storage->path($this->bukti_pembayaran)
        );
    }
    public function formattedTanggalDibayar(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->tanggal_dibayar ? $this->tanggal_dibayar->format('d F Y H:i') : "-"
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
    public function pelatihanDurasiBulan(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->pelatihan?->formatted_durasi_bulan ?? "-"
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
}
