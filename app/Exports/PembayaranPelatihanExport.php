<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PembayaranPelatihanExport implements FromCollection, WithHeadings
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
                'nama_pelatihan' => $data->pelatihan->nama_pelatihan,
                'skema_pembayaran' => $data->skema_pembayaran->label(),
                'tenor' => $data->tenor?->label() ?? '-',
                'catatan' => $data->catatan ?? "-",
                "status_pembayaran" => $data->pembayaran_pelatihan_lunas ? "Lunas" : "Belum Lunas"
            ];
        });
    }
    public function headings(): array
    {
        return [
            'Nama Peserta',
            'Nama Pelatihan',
            'Skema Pembayaran',
            'Tenor',
            'Catatan',
            "Status Pembayaran"
        ];
    }
}
