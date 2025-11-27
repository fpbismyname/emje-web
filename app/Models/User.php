<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['formatted_name'];
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
        return $this->hasMany(PengajuanKontrakKerja::class, 'user_id');
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
        if (is_array($column)) {
            foreach ($column as $col) {
                return $query->where($col, $operator, $keywords);
            }
        }
        return $query->where($column, $operator, $keywords);
    }
    /**
     * Accessor
     */
    public function formattedName(): Attribute
    {
        return Attribute::make(
            get: fn() => Str::of($this->name)->ucfirst()
        );
    }
}
