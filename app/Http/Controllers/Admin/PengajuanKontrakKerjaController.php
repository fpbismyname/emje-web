<?php

namespace App\Http\Controllers\Admin;

use App\Enums\KontrakKerja\StatusKontrakKerjaPesertaEnum;
use App\Enums\KontrakKerja\StatusPembayaranKontrakKerjaEnum;
use App\Enums\KontrakKerja\StatusPengajuanKontrakKerja;
use App\Enums\KontrakKerja\SumberDanaEnum;
use App\Enums\Pelatihan\JenisPembayaranEnum;
use App\Enums\Rekening\TipeTransaksiEnum;
use App\Enums\Utils\PaginateSize;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PengajuanKontrakKerjaRequest;
use App\Models\KontrakKerja;
use App\Models\PengajuanKontrakKerja;
use App\Models\Rekening;
use App\Services\Utils\Toast;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
        Rekening $rekening_model
    ) {
        $update_entries = $request->validated();

        $pengajuan_kontrak_kerja = $pengajuan_kontrak_kerja_model->findOrFail($id);
        $pengajuan_kontrak_kerja->update($update_entries);

        $rekening_bendahara = $rekening_model->rekening_bendahara()->first();

        if ($pengajuan_kontrak_kerja->status === StatusPengajuanKontrakKerja::DITERIMA) {
            // Create or update related KontrakKerja model
            $pengajuan_kontrak_kerja->kontrak_kerja_peserta()->create([
                'status' => StatusKontrakKerjaPesertaEnum::BERLANGSUNG
            ]);
            if ($pengajuan_kontrak_kerja->sumber_dana === SumberDanaEnum::DANA_TALANG) {
                // Catat transaksi
                $catat_transksi = $rekening_bendahara->transaksi_rekening()->create([
                    'nominal_transaksi' => config('rules-lpk.biaya_pemberangkatan'),
                    'keterangan' => "Pembayaran pemberangkatan peserta {$pengajuan_kontrak_kerja->users->profil_user->nama_lengkap} dari dana talang perusahaan.",
                    'tipe_transaksi' => TipeTransaksiEnum::PENGELUARAN,
                ]);
                if ($catat_transksi->wasRecentlyCreated) {
                    $rekening_bendahara->decrement('saldo', config('rules-lpk.biaya_pemberangkatan'));
                }
                // Buat cicilan pembayaran dana talang
                $tenor_cicilan = config('rules-lpk.tenor_kontrak_kerja');
                $nominal_cicilan = config('rules-lpk.biaya_pemberangkatan') / $tenor_cicilan;
                $tanggal_jatuh_tempo_cicilan = Carbon::parse(now())->addMonth();

                for ($i = 0; $i < $tenor_cicilan; $i++) {
                    $pengajuan_kontrak_kerja->pembayaran_dana_talang()->create([
                        'nominal' => $nominal_cicilan,
                        'status' => StatusPembayaranKontrakKerjaEnum::BELUM_BAYAR,
                        'jenis_pembayaran' => JenisPembayaranEnum::ANGSURAN,
                        'bukti_pembayaran' => null,
                        'tanggal_pembayaran' => $tanggal_jatuh_tempo_cicilan->clone()->addMonths($i),
                    ]);
                }
            }
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
