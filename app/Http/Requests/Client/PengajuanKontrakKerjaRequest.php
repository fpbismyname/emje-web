<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class PengajuanKontrakKerjaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->is_client_user;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $request_method = $this->getMethod();
        if ($request_method === 'PUT') {
            return [
                'surat_pengajuan_kontrak' => [
                    'nullable',
                    'file',
                    'mimes:pdf',
                    'max:4096',
                ]
            ];
        }
        return [
            'surat_pengajuan_kontrak' => [
                'required',
                'nullable',
                'file',
                'mimes:pdf',
                'max:4096',
            ]
        ];
    }
}
