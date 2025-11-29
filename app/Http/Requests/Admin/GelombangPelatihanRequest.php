<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GelombangPelatihanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('manage-gelombang-pelatihan');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method_request = $this->getMethod();
        return match ($method_request) {
            'POST' => [
                'nama_gelombang' => ['required'],
                'tanggal_mulai' => ['required'],
                'maksimal_peserta' => ['required', 'numeric'],
                'pelatihan_id' => ['required'],
            ],
            'PUT' => [
                'nama_gelombang' => ['required'],
                'tanggal_mulai' => ['required'],
                'maksimal_peserta' => ['required', 'numeric'],
            ]
        };
    }
}
