<?php

namespace App\Http\Requests\Client;

use App\Enums\User\JenisKelaminEnum;
use App\Enums\User\PendidikanTerakhirEnum;
use App\Enums\User\RoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PengaturanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && in_array(auth()->user()->role->value, array_column(RoleEnum::client_user(), 'value'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Akun user
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'reset_password' => ['nullable'],
            'new_password' => ['nullable', 'string', 'min:6'],
            // Profil user
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
            'nomor_telepon' => ['required', 'string', 'max:20'],
            'pendidikan_terakhir' => ['required', 'string', Rule::in(array_column(PendidikanTerakhirEnum::cases(), 'value'))],
            'jenis_kelamin' => ['required', 'string', Rule::in(array_column(JenisKelaminEnum::cases(), 'value'))],
            'tanggal_lahir' => ['required', 'date'],
            'foto_profil' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:8192'],
            'ktp' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:8192'],
            'ijazah' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:8192'],
        ];
    }
}
