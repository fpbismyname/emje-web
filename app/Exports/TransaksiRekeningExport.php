<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransaksiRekeningExport implements FromCollection, WithHeadings
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
                'Nominal transaksi' => $data->formatted_nominal_transaksi,
                'Keterangan' => $data->keterangan,
                'Tipe transaksi' => $data->tipe_transaksi->label(),
                'Tanggal transaksi' => $data->formatted_tanggal_transaksi,
            ];
        });
    }
    public function headings(): array
    {
        return [
            'Pencairan Kelompok',
            'Nominal pencairan',
            'Status pencairan',
            'Tanggal pencairan',
        ];
    }
}
