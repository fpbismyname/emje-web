<?php

namespace App\Models;

use App\Enums\Pelatihan\SesiGelombangPelatihanEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class GelombangPelatihan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gelombang_pelatihan';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_gelombang',
        'tanggal_mulai',
        'tanggal_selesai',
        'sesi',
        'maksimal_peserta',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'sesi' => SesiGelombangPelatihanEnum::class
    ];
    /**
     * Relationships
     */
    public function pelatihan()
    {
        return $this->belongsTo(Pelatihan::class, 'pelatihan_id');
    }
    public function pelatihan_peserta()
    {
        return $this->hasMany(PelatihanPeserta::class, 'gelombang_pelatihan_id');
    }
    public function jadwal_ujian_pelatihan()
    {
        return $this->hasMany(JadwalUjianPelatihan::class, 'gelombang_pelatihan_id');
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
        return $query->where('nama_gelombang', 'like', $kw);
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
    public function scopeTersedia_untuk_registrasi(Builder $query)
    {
        return $query->withCount(['pelatihan_peserta'])
            ->where('maksimal_peserta', '>', 'pelatihan_peserta_count');
    }
    public function scopeTersedia_untuk_jadwal_ujian(Builder $query, $includeJadwalId = null)
    {
        return $query->whereDoesntHave('jadwal_ujian_pelatihan', fn($q) => $q->where('id', $includeJadwalId));
    }
    /**
     * Appends
     */
    protected $appends = [
        'formatted_durasi_pelatihan',
        'formatted_tanggal_mulai',
        'formatted_tanggal_selesai',
        'date_time_tanggal_mulai',
        'date_time_tanggal_selesai',
        'total_peserta_gelombang',
    ];
    /**
     * Accessor
     */
    public function formattedDurasiPelatihan(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->pelatihan->formatted_durasi_pelatihan ?? "-"
        );
    }
    public function formattedTanggalMulai(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->tanggal_mulai ? $this->tanggal_mulai->translatedFormat('d F Y') : "-"
        );
    }
    public function formattedTanggalSelesai(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->tanggal_selesai ? $this->tanggal_selesai->translatedFormat('d F Y') : "-"
        );
    }
    public function dateTimeTanggalMulai(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->tanggal_mulai?->format('Y-m-d')
        );
    }
    public function dateTimeTanggalSelesai(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->tanggal_selesai?->format('Y-m-d')
        );
    }
    public function totalMaksimalPeserta(): Attribute
    {
        $total_peserta_gelombang = $this->pelatihan_peserta()->count();
        $maksimal_peserta_gelombang = $this->maksimal_peserta;
        return Attribute::make(
            get: fn() => "$total_peserta_gelombang / $maksimal_peserta_gelombang"
        );
    }
    public function totalPesertaGelombang(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->pelatihan_peserta()->count()
        );
    }

}
