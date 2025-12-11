<?php

namespace App\Http\Requests\Client;

use App\Enums\Pelatihan\SkemaPembayaranEnum;
use App\Enums\Pelatihan\TenorCicilanPelatihanEnum;
use App\Enums\User\JenisKelaminEnum;
use App\Enums\User\PendidikanTerakhirEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PendaftaranPelatihanRequest extends FormRequest
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
        return [

            // Pembayaran
            'skema_pembayaran' => [
                'required',
                Rule::in(array_column(SkemaPembayaranEnum::cases(), 'value'))
            ],

            'tenor' => ['required_if:skema_pembayaran,cicilan', Rule::in(array_column(TenorCicilanPelatihanEnum::cases(), 'value'))],

            // Cicilan → wajib DP
            'bukti_pembayaran_dp' => [
                'required_if:skema_pembayaran,cicilan',
                'nullable',
                'file',
                'image',
                'mimes:jpg,jpeg,png,pdf',
                'max:4096',
            ],

            // Cash → wajib bukti full payment
            'bukti_pembayaran_cash' => [
                'required_if:skema_pembayaran,cash',
                'nullable',
                'file',
                'image',
                'mimes:jpg,jpeg,png,pdf',
                'max:4096',
            ],
        ];
    }
}
