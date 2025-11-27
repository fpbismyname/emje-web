<?php

namespace App\Http\Requests\Admin;

use App\Enums\KontrakKerja\StatusKontrakKerjaEnum;
use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'nama_perusahaan' => ['required', 'string', 'max:255'],
            'gaji_terendah' => ['nullable', 'numeric', 'min:0'],
            'gaji_tertinggi' => ['nullable', 'numeric', 'min:0', 'gte:gaji_terendah'],
            'status' => ['required', 'string', 'in:' . implode(",", StatusKontrakKerjaEnum::getValues())],
            'durasi_kontrak_kerja' => ['nullable', 'integer', 'min:1'],
            'deskripsi' => ['nullable', 'string'],
        ];
    }
}
