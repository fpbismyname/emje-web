<?php

namespace App\Http\Requests\Admin;

use App\Enums\Pelatihan\JenisUjianEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'nama_ujian' => ['required'],
            'lokasi' => ['required'],
            'jenis_ujian' => ['required', 'string', Rule::in(array_column(JenisUjianEnum::cases(),'value'))],
            'tanggal_mulai' => ['required', 'date', 'before_or_equal:tanggal_selesai'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
        ];
    }
}
