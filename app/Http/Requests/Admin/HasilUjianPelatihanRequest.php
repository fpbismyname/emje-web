<?php

namespace App\Http\Requests\Admin;

use App\Enums\Pelatihan\StatusHasilUjianPelatihanEnum;
use Illuminate\Foundation\Http\FormRequest;

class HasilUjianPelatihanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('manage-hasil-ujian-pelatihan');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_materi' => ['required', 'string'],
            'nilai' => ['required', 'numeric', 'min:1', 'max:100'],
        ];
    }
}
