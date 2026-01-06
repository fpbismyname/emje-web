<?php

namespace App\Http\Requests\Admin;

use App\Enums\KontrakKerja\StatusKontrakKerjaEnum;
use App\Enums\Pelatihan\KategoriPelatihanEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KontrakKerjaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('manage-kontrak-kerja');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // $method_request = $this->getMethod();

        $request_validation = [
            'nama_perusahaan' => ['required', 'string', 'max:255'],
            'gaji_terendah' => ['nullable', 'numeric', 'min:0', 'lt:gaji_tertinggi'],
            'gaji_tertinggi' => ['nullable', 'numeric', 'min:0', 'gt:gaji_terendah'],
            'status' => ['required', 'string', Rule::in(array_column(StatusKontrakKerjaEnum::cases(), 'value'))],
            'maksimal_pelamar' => ['required', 'min:1', 'max:9999999999'],
            'durasi_kontrak_kerja' => ['nullable', 'integer', 'min:1'],
            'deskripsi' => ['nullable', 'string'],
            'kategori_kontrak_kerja' => ['required', Rule::in(array_column(KategoriPelatihanEnum::cases(), 'value'))],
        ];

        return $request_validation;
    }
}
