<?php

namespace App\Models;

use App\Enums\Pelatihan\KategoriPelatihanEnum;
use App\Enums\Pelatihan\StatusPelatihanEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pelatihan extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pelatihan';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_pelatihan',
        'nominal_biaya',
        'durasi_pelatihan',
        'kategori_pelatihan',
        'deskripsi',
        'status'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'nominal_biaya' => 'int',
        'status' => StatusPelatihanEnum::class,
        'kategori_pelatihan' => KategoriPelatihanEnum::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function pendaftaran_pelatihan()
    {
        return $this->hasMany(PendaftaranPelatihan::class, 'pelatihan_id');
    }
    public function gelombang_pelatihan()
    {
        return $this->hasMany(GelombangPelatihan::class, 'pelatihan_id');
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
        return $query->where('nama_pelatihan', 'like', $kw)
            ->orWhere('nominal_biaya', 'like', $kw)
            ->orWhere('durasi_bulan', 'like', $kw)
            ->orWhere('kategori_pelatihan', 'like', $kw)
            ->orWhere('deskripsi', 'like', $kw)
            ->orWhere('status', 'like', $kw);
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
        'formatted_nama_pelatihan',
        'formatted_nominal_biaya',
        'formatted_durasi_pelatihan'
    ];
    /**
     * Accessor
     */
    public function formattedNamaPelatihan(): Attribute
    {
        return Attribute::make(
            get: fn() => Str::of($this->nama_pelatihan)->ucfirst()
        );
    }
    public function formattedNominalBiaya(): Attribute
    {
        return Attribute::make(
            get: fn() => "Rp " . number_format($this->nominal_biaya, 0, ',', '.')
        );
    }
    public function formattedDurasiPelatihan(): Attribute
    {
        return Attribute::make(
            get: fn() => "{$this->durasi_pelatihan} bulan"
        );
    }
}
