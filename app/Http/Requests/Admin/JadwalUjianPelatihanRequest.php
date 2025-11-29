<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class JadwalUjianPelatihanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('manage-jadwal-ujian-pelatihan');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_pelatihan' => ['required'],
            'lokasi' => ['required'],
            'tanggal_mulai' => ['required'],
            'tanggal_selesai' => ['required', 'gte:tanggal_mulai'],
            'gelombang_pelatihan_id' => ['required'],
        ];
    }
}
