<?php

namespace App\Http\Requests\Admin;

use App\Enums\Pelatihan\StatusPendaftaranPelatihanEnum;
use Illuminate\Foundation\Http\FormRequest;

class PendaftaranPelatihanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('manage-pendaftaran-pelatihan');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $enum_status_pendaftaran_pelatihan = implode(',', StatusPendaftaranPelatihanEnum::getValues('cases_review'));
        return [
            'status' => ['required', "in:$enum_status_pendaftaran_pelatihan"],
            'catatan' => ['nullable'],
        ];
    }
}
