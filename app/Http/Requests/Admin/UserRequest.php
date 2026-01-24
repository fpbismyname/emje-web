<?php

namespace App\Http\Requests\Admin;

use App\Enums\User\JenisKelaminEnum;
use App\Enums\User\PendidikanTerakhirEnum;
use App\Enums\User\RoleEnum;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() || auth()->user()->can('manage-user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method_request = $this->getMethod();
        $role_user = $this->get('role');

        $return_validation = [];

        $enum_role_client = implode(',', RoleEnum::getValues('client_user'));
        $enum_role_admin = implode(',', RoleEnum::getValues('admin_user'));
        $enum_pendidikan_terakhir = implode(',', PendidikanTerakhirEnum::getValues());
        $enum_jenis_kelamin = implode(',', JenisKelaminEnum::getValues());


        if (in_array($role_user, RoleEnum::getValues('admin_user'))) {
            if ($method_request === 'POST') {
                $return_validation = [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                    'role' => ['required', 'string', "in:{$enum_role_admin}"],
                    'password' => ['required', 'string', 'min:6'],
                ];
            } else if ($method_request === 'PUT') {
                $return_validation = [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255'],
                    'role' => ['required', 'string', "in:{$enum_role_admin}"],
                    'reset_password' => ['nullable'],
                    'old_password' => ['nullable', 'string', 'min:6'],
                    'new_password' => ['nullable', 'string', 'min:6'],
                ];
            }
        } else if (in_array($role_user, RoleEnum::getValues('client_user'))) {
            if ($method_request === 'POST') {
                $return_validation = [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                    'role' => ['required', 'string', "in:{$enum_role_client}"],
                    'password' => ['required', 'string', 'min:6'],
                    'nama_lengkap' => ['required', 'string', 'max:255'],
                    'alamat' => ['required', 'string', 'max:255'],
                    'nomor_telepon' => ['required', 'string', 'max:20'],
                    'pendidikan_terakhir' => ['required', 'string', "in:{$enum_pendidikan_terakhir}"],
                    'jenis_kelamin' => ['required', 'string', "in:{$enum_jenis_kelamin}"],
                    'tanggal_lahir' => ['required', 'date'],
                    'foto_profil' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:8192'],
                    'ktp' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:8192'],
                    'ijazah' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:8192'],
                ];
            } else if ($method_request === 'PUT') {
                $return_validation = [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255'],
                    'role' => ['required', 'string', "in:{$enum_role_client}"],
                    'nama_lengkap' => ['required', 'string', 'max:255'],
                    'alamat' => ['required', 'string', 'max:255'],
                    'nomor_telepon' => ['required', 'string', 'max:20'],
                    'pendidikan_terakhir' => ['required', 'string', "in:{$enum_pendidikan_terakhir}"],
                    'jenis_kelamin' => ['required', 'string', "in:{$enum_jenis_kelamin}"],
                    'tanggal_lahir' => ['required', 'date'],
                    'foto_profil' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:8192'],
                    'ktp' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:8192'],
                    'ijazah' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:8192'],
                    'reset_password' => ['nullable'],
                    'old_password' => ['nullable', 'string', 'min:6'],
                    'new_password' => ['nullable', 'string', 'min:6'],
                ];
            }
        }

        return $return_validation;
    }
}
