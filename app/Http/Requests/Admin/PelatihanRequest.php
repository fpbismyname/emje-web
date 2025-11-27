<?php

namespace App\Http\Requests\Admin;

use App\Enums\Pelatihan\KategoriPelatihanEnum;
use App\Enums\Pelatihan\StatusPelatihanEnum;
use Illuminate\Foundation\Http\FormRequest;

class PelatihanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('manage-pelatihan');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $enum_kategori_pelatihan = implode(',', KategoriPelatihanEnum::getValues());
        $enum_status_pelatihan = implode(',', StatusPelatihanEnum::getValues());
        return [
            'nama_pelatihan' => ['required', 'string', 'max:255'],
            'nominal_biaya' => ['required', 'numeric', 'min:0'],
            'durasi_bulan' => ['required', 'integer', 'min:1'],
            'kategori_pelatihan' => ['required', 'string', "in:$enum_kategori_pelatihan"],
            'deskripsi' => ['nullable', 'string'],
            'status' => ['required', "in:$enum_status_pelatihan"],
        ];
    }
}
