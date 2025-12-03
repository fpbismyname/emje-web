<?php

namespace App\Models;

use App\Enums\User\JenisKelaminEnum;
use App\Enums\User\PendidikanTerakhirEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProfilUser extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'profil_user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_lengkap',
        'alamat',
        'nomor_telepon',
        'pendidikan_terakhir',
        'jenis_kelamin',
        'tanggal_lahir',
        'foto_profil',
        'ktp',
        'ijazah',
        'users_id',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'jenis_kelamin' => JenisKelaminEnum::class,
        'pendidikan_terakhir' => PendidikanTerakhirEnum::class,
        'tanggal_lahir' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    /**
     * Relationships
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'formatted_nama_lengkap',
        'formatted_pendidikan_terakhir',
        'formatted_jenis_kelamin',
        'formatted_tanggal_lahir',
        'formatted_date_tanggal_lahir'
    ];
    /**
     * Scope
     */
    public function scopeSearch($query, $keyword)
    {
        if ($keyword == '' || $keyword == null) {
            return $query;
        }
        return $query->where('nama_lengkap', 'like', "%{$keyword}%")
            ->orWhere('alamat', 'like', "%{$keyword}%")
            ->orWhere('nomor_telepon', 'like', "%{$keyword}%");
    }
    public function scopeSearch_by_column($query, $column, $keyword, $operator = "=")
    {
        $keywords = $operator === 'like' ? "%{$keyword}%" : $keyword;
        if ($keyword == '' || $keyword == null || $column == '' || $column == null) {
            return $query;
        }
        if (is_array($keyword)) {
            return $query->whereIn($column, $operator, $keywords);
        }
        if (is_array($column)) {
            foreach ($column as $col) {
                return $query->where($col, $operator, $keywords);
            }
        }
        return $query->where($column, $operator, $keywords);
    }
    public function scopeHas_pengajuan_kontrak_kerja($query)
    {
        return $query->whereHas('users.pengajuan_kontrak_kerja');
    }
    public function scopeHas_pendaftaran_pelatihan($query)
    {
        return $query->whereHas('users.pendaftaran_pelatihan');
    }
    /**
     * Accessor
     */
    public function formattedNamaLengkap(): Attribute
    {
        return Attribute::make(
            get: fn() => Str::of($this->nama_lengkap)->ucfirst()
        );
    }
    public function formattedPendidikanTerakhir(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->pendidikan_terakhir->label()
        );
    }
    public function formattedJenisKelamin(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->jenis_kelamin->label()
        );
    }
    public function formattedTanggalLahir(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->tanggal_lahir->translatedFormat('d F Y')
        );
    }
    public function formattedDateTanggalLahir(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->tanggal_lahir->format('Y-m-d')
        );
    }
}
