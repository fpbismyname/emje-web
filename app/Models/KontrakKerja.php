<?php

namespace App\Models;

use App\Enums\KontrakKerja\StatusKontrakKerjaEnum;
use App\Enums\Pelatihan\KategoriPelatihanEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class KontrakKerja extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kontrak_kerja';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_perusahaan',
        'gaji_terendah',
        'gaji_tertinggi',
        'durasi_kontrak_kerja',
        'deskripsi',
        'surat_kontrak',
        'maksimal_pelamar',
        'status',
        'kategori_kontrak_kerja'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'gaji_terendah' => 'int',
        'gaji_tertinggi' => 'int',
        'status' => StatusKontrakKerjaEnum::class,
        'kategori_kontrak_kerja' => KategoriPelatihanEnum::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    /**
     * Relationships
     */
    public function pengajuan_kontrak_kerja()
    {
        return $this->hasMany(PengajuanKontrakKerja::class, 'kontrak_kerja_id');
    }
    /**
     * Scope
     */
    public function scopeSearch($query, $keyword)
    {
        if ($keyword == '' || $keyword == null) {
            return $query;
        }
        return $query->where(function ($q) use ($keyword) {
            $kw = "%{$keyword}%";
            $q->where('nama_perusahaan', 'like', $kw)
                ->orWhere('gaji_terendah', 'like', $kw)
                ->orWhere('gaji_tertinggi', 'like', $kw)
                ->orWhere('status', 'like', $kw)
                ->orWhere('deskripsi', 'like', $kw)
                ->orWhere('durasi_kontrak_kerja', 'like', $kw);
        });
    }
    public function scopeSearch_by_column($query, $column, $keyword, $operator = "=")
    {
        $keywords = $operator === 'like' ? "%{$keyword}%" : $keyword;
        if ($keyword == '' || $keyword == null || $column == '' || $column == null) {
            return $query;
        }
        if (is_array($keyword)) {
            return $query->whereIn($column, $keywords);
        }
        if (is_array($column)) {
            return $query->where(function ($q) use ($column, $operator, $keywords) {
                foreach ($column as $col) {
                    $q->orWhere($col, $operator, $keywords);
                }
            });
        }

        return $query->where($column, $operator, $keywords);
    }
    public function scopeKontrak_kerja_aktif($query)
    {
        return $query->search_by_column('status', StatusKontrakKerjaEnum::AKTIF);
    }
    /**
     * Appends
     */
    protected $appends = [
        'formatted_nama_perusahaan',
        'formatted_rentang_gaji',
        'formatted_gaji_terendah',
        'formatted_gaji_tertinggi',
        'formatted_durasi_kontrak_kerja',
        'formatted_maksimal_pelamar',
    ];
    /**
     * Accessor
     */
    public function formattedNamaPerusahaan(): Attribute
    {
        return Attribute::make(
            get: fn() => Str::of($this->nama_perusahaan ?? '')->ucfirst()
        );
    }
    public function formattedRentangGaji(): Attribute
    {
        $gaji_terendah = "Rp " . number_format($this->gaji_terendah, 0, ",", ".");
        $gaji_tertinggi = "Rp " . number_format($this->gaji_tertinggi, 0, ",", ".");

        return Attribute::make(
            get: fn() => "{$gaji_terendah} - {$gaji_tertinggi}"
        );
    }
    public function formattedGajiTerendah(): Attribute
    {
        $gaji_terendah = "Rp " . number_format($this->gaji_terendah, 0, ",", ".");
        return Attribute::make(
            get: fn() => $gaji_terendah
        );
    }
    public function formattedGajiTertinggi(): Attribute
    {
        $gaji_tertinggi = "Rp " . number_format($this->gaji_tertinggi, 0, ",", ".");
        return Attribute::make(
            get: fn() => $gaji_tertinggi
        );
    }
    public function formattedDurasiKontrakKerja(): Attribute
    {
        return Attribute::make(
            get: fn() => "{$this->durasi_kontrak_kerja} Tahun"
        );
    }
    public function formattedTanggalKontrakBerakhir(): Attribute
    {
        return Attribute::make(
            get: fn() => now()->addYears($this->durasi_kontrak_kerja)->format('d F Y')
        );
    }
    public function formattedMaksimalPelamar(): Attribute
    {
        return Attribute::make(
            get: fn() => "{$this->maksimal_pelamar} Orang"
        );
    }
}
