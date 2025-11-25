<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilUser extends Model
{
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
        'users_id',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
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
}
