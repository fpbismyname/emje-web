<?php

namespace App\Http\Requests\Admin;

use App\Enums\Pelatihan\JenisSertifikatEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SertifikatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() || auth()->user()->can('manage-pelatihan');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $request_method = $this->getMethod();
        $return_validation = match ($request_method) {
            'POST' => [
                'jenis_sertifikat' => ['required', Rule::in(array_column(JenisSertifikatEnum::cases(), 'value'))],
                'sertifikat' => [
                    'required',
                    'file',
                    'mimes:pdf',
                    'max:4096',
                ]
            ],
            'PUT' => [
                'jenis_sertifikat' => ['required', Rule::in(array_column(JenisSertifikatEnum::cases(), 'value'))],
                'sertifikat' => [
                    'nullable',
                    'file',
                    'mimes:pdf',
                    'max:4096',
                ]
            ],
        };
        return $return_validation;
    }
}
