<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PembayaranDanaTalangExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected Collection $datas;
    public function __construct($filterred_datas)
    {
        $this->datas = $filterred_datas;
    }
    public function collection()
    {
        return $this->datas->map(function ($data) {
            return [
                'nama_peserta' => $data->users->profil_user->nama_lengkap,
                'nama_pelatihan' => $data->kontrak_kerja->nama_perusahaan,
                'nominal_pembayaran' => config('rules-lpk.formatted_biaya_pemberangkatan'),
                'sumber_dana_pemberangkatan' => $data->sumber_dana->label(),
                "status_pembayaran" => $data->pembayaran_dana_talang_lunas ? "Lunas" : "Belum Lunas"
            ];
        });
    }
    public function headings(): array
    {
        return [
            'Nama Peserta',
            'Nama Pelatihan',
            'Nominal Pembayaran',
            'Sumber Dana Pemberangkatan',
            'Status Pembayaran'
        ];
    }
}
