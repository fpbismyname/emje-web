<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Pelatihan\StatusPelatihanPesertaEnum;
use App\Enums\User\RoleEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => RoleEnum::class,
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
    /**
     * Relationships
     */
    public function profil_user()
    {
        return $this->hasOne(ProfilUser::class, 'users_id');
    }
    public function pendaftaran_pelatihan()
    {
        return $this->hasMany(PendaftaranPelatihan::class, 'users_id');
    }
    public function pengajuan_kontrak_kerja()
    {
        return $this->hasMany(PengajuanKontrakKerja::class, 'users_id');
    }
    /**
     * Scope 
     */
    public function scopeSearch($query, $keyword)
    {
        if ($keyword == '' || $keyword == null) {
            return $query;
        }
        return $query->where('name', 'like', "%{$keyword}%")
            ->orWhere('email', 'like', "%{$keyword}%");
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
        return $query->where($column, $operator, $keywords);
    }
    /**
     * Appends
     */
    protected $appends = [
        'formatted_name',
        'jumlah_pelatihan_diikuti',
        'is_client_user',
        'profil_lengkap',
        'dapat_mengajukan_pelatihan'
    ];
    /**
     * Accessor
     */
    public function formattedName(): Attribute
    {
        return Attribute::make(
            get: fn() => Str::of($this->name)->ucfirst()
        );
    }
    public function jumlahPelatihanDiikuti(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->pendaftaran_pelatihan()->count()
        );
    }
    public function jumlahKontrakKerjaDiikuti(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->pengajuan_kontrak_kerja()->count()
        );
    }
    public function isClientUser(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->role === RoleEnum::PESERTA
        );
    }
    public function profilLengkap(): Attribute
    {
        $is_not_complete = [];
        if ($this->profil_user()->exists()) {
            foreach ($this->profil_user->getFillable() as $col) {
                if (empty($this->profil_user->{$col})) {
                    $is_not_complete[] = $col;
                }
            }
        }

        $profil_lengkap = empty($is_not_complete);
        return Attribute::make(
            get: fn() => $profil_lengkap && $this->profil_user()->exists()
        );
    }
    public function dapatMengajukanPelatihan(): Attribute
    {
        $pelatihan_diikuti_selesai = $this->pendaftaran_pelatihan()->get()->every(function ($pendaftaran) {
            if ($pendaftaran->pelatihan_peserta()->exists()) {
                return !in_array($pendaftaran?->pelatihan_peserta?->status, [StatusPelatihanPesertaEnum::BERLANGSUNG]);
            } else {
                return true;
            }
        });
        return Attribute::make(
            get: fn() => $pelatihan_diikuti_selesai
        );
    }
    public function telahMengikutiPelatihan(): Attribute
    {
        $pelatihan_peserta = $this->pendaftaran_pelatihan()->get()->some(function ($pendaftaran) {
            return in_array($pendaftaran->pelatihan_peserta?->status, [StatusPelatihanPesertaEnum::LULUS]);
        });
        return Attribute::make(
            get: fn() => $pelatihan_peserta
        );
    }
}
