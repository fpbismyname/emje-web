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
