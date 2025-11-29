<?php

namespace App\Models;

use App\Enums\Pelatihan\StatusJadwalUjianPelatihanEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class JadwalUjianPelatihan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jadwal_ujian_pelatihan';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_ujian',
        'lokasi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'gelombang_pelatihan_id'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'status' => StatusJadwalUjianPelatihanEnum::class
    ];
    /**
     * Relationships
     */
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
        return $query->where('nama_ujian', 'like', $kw)
            ->orWhere('lokasi', 'like', $kw);
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
        'tanggal_mulai',
        'tanggal_selesai',
    ];
    /**
     * Accessor
     */
    public function formattedTanggalMulai()
    {
        return Attribute::make(
            get: fn() => $this->tanggal_mulai->format('d F Y | H:i')
        );
    }
    public function formattedTanggalSelesai()
    {
        return Attribute::make(
            get: fn() => $this->tanggal_selesai->format('d F Y | H:i')
        );
    }
}
