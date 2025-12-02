<?php

namespace App\Http\Controllers\Admin;

use App\Enums\KontrakKerja\StatusKontrakKerjaPesertaEnum;
use App\Enums\KontrakKerja\StatusPengajuanKontrakKerja;
use App\Enums\Utils\PaginateSize;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PengajuanKontrakKerjaRequest;
use App\Models\KontrakKerja;
use App\Models\PengajuanKontrakKerja;
use App\Services\Utils\Toast;
use Illuminate\Http\Request;

class PengajuanKontrakKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, PengajuanKontrakKerja $pengajuan_kontrak_kerja_model)
    {
        $filters = $request->only('search', 'status');

        $query = $pengajuan_kontrak_kerja_model->query();

        foreach ($filters as $key => $value) {
            match ($key) {
                'search' => $query->search($value),
                default => $query->search_by_column($key, $value),
            };
        }

        $datas = $query->latest()->paginate(PaginateSize::SMALL->value)->withQueryString();

        $payload = compact('datas');
        return view('admin.pengajuan-kontrak-kerja.index', $payload);
    }
    public function edit(string $id, PengajuanKontrakKerja $pengajuan_kontrak_kerja_model)
    {
        $pengajuan_kontrak_kerja = $pengajuan_kontrak_kerja_model->findOrFail($id);
        $payload = compact('pengajuan_kontrak_kerja');
        return view('admin.pengajuan-kontrak-kerja.edit', $payload);
    }

    public function update(
        PengajuanKontrakKerjaRequest $request,
        string $id,
        PengajuanKontrakKerja $pengajuan_kontrak_kerja_model,
    ) {
        $update_entries = $request->validated();

        $pengajuan_kontrak_kerja = $pengajuan_kontrak_kerja_model->findOrFail($id);
        $pengajuan_kontrak_kerja->update($update_entries);

        if ($pengajuan_kontrak_kerja->status === StatusPengajuanKontrakKerja::DITERIMA) {
            // Create or update related KontrakKerja model
            $pengajuan_kontrak_kerja->kontrak_kerja_peserta()->create([
                'status' => StatusKontrakKerjaPesertaEnum::BERLANGSUNG
            ]);
        }

        if ($pengajuan_kontrak_kerja->wasChanged()) {
            Toast::success('Pengajuan kontrak kerja berhasil direview.');
        } else if (!$pengajuan_kontrak_kerja->getChanges()) {
            Toast::info('Tidak ada perubahan yang dilakukan.');
        } else {
            Toast::info('Terjadi kesalahan.');
        }
        return redirect()->back();
    }
}
