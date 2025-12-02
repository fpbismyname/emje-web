<?php

namespace App\Http\Requests\Admin;

use App\Enums\KontrakKerja\StatusPengajuanKontrakKerja;
use Illuminate\Foundation\Http\FormRequest;

class KontrakKerjaPesertaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('manage-kontrak-kerja-peserta');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $enum_status_pengajuan = implode(",", StatusPengajuanKontrakKerja::getValues());
        return [
            'status' => ['required', "in:$enum_status_pengajuan"],
            'catatan' => ['nullable']
        ];
    }
}
