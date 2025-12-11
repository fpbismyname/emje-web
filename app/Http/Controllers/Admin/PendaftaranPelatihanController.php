<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Pelatihan\StatusPelatihanPesertaEnum;
use App\Enums\Pelatihan\StatusPembayaranPelatihanEnum;
use App\Enums\Pelatihan\StatusPendaftaranPelatihanEnum;
use App\Enums\Rekening\TipeTransaksiEnum;
use App\Enums\Utils\PaginateSize;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PendaftaranPelatihanRequest;
use App\Models\PendaftaranPelatihan;
use App\Models\Rekening;
use App\Services\Utils\Toast;
use Illuminate\Http\Request;

class PendaftaranPelatihanController extends Controller
{

    public function index(Request $request, PendaftaranPelatihan $pendaftaran_pelatihan_model)
    {
        $filters = $request->only('search', 'status', 'skema_pembayaran');

        $query = $pendaftaran_pelatihan_model->query();

        foreach ($filters as $key => $value) {
            match ($key) {
                'search' => $query->search($value),
                default => $query->search_by_column($key, $value),
            };
        }

        $datas = $query->latest()->paginate(PaginateSize::SMALL->value)->withQueryString();

        $payload = compact('datas');
        return view('admin.pendaftaran-pelatihan.index', $payload);
    }

    public function edit(string $id, PendaftaranPelatihan $pendaftaran_pelatihan_model)
    {
        $pendaftaran_pelatihan = $pendaftaran_pelatihan_model->findOrFail($id);
        $payload = compact('pendaftaran_pelatihan');
        return view('admin.pendaftaran-pelatihan.edit', $payload);
    }

    public function update(
        PendaftaranPelatihanRequest $request,
        string $id,
        PendaftaranPelatihan $pendaftaran_pelatihan_model,
        Rekening $rekening
    ) {

        $update_entries = $request->validated();

        $pendaftaran_pelatihan = $pendaftaran_pelatihan_model->findOrFail($id);
        $pendaftaran_pelatihan->update($update_entries);

        $nama_peserta = $pendaftaran_pelatihan->users->profil_user->nama_lengkap;
        $nama_pelatihan = $pendaftaran_pelatihan->pelatihan->nama_pelatihan;

        $rekening_bendahara = $rekening->rekening_bendahara()->first();


        if ($pendaftaran_pelatihan->status === StatusPendaftaranPelatihanEnum::DITERIMA) {
            $pendaftaran_pelatihan->pelatihan_peserta()->create([
                'gelombang_pelatihan_id' => $pendaftaran_pelatihan->gelombang_pelatihan_id,
                'status' => StatusPelatihanPesertaEnum::BERLANGSUNG,
                'tanggal_mulai' => now(),
                'tanggal_selesai' => now()->addMonths($pendaftaran_pelatihan->durasi_pelatihan)
            ]);
        }

        // Pengembalian pembayaran 
        if ($pendaftaran_pelatihan->status === StatusPendaftaranPelatihanEnum::DITOLAK) {
            $pendaftaran_pelatihan->pembayaran_pelatihan()->get()->each(function ($pembayaran) use ($rekening_bendahara, $nama_peserta, $nama_pelatihan) {

                if ($pembayaran->status === StatusPembayaranPelatihanEnum::SUDAH_BAYAR) {
                    $catat_transaksi_pengembalian = $rekening_bendahara->transaksi_rekening()->create([
                        'nominal_transaksi' => $pembayaran->nominal,
                        'tipe_transaksi' => TipeTransaksiEnum::PENGELUARAN,
                        'keterangan' => "Pengembalian pembayaran kepada {$nama_peserta} atas penolakan pendaftaran {$nama_pelatihan}",
                    ]);

                    if ($catat_transaksi_pengembalian->wasRecentlyCreated) {
                        $rekening_bendahara->decrement('saldo', $pembayaran->nominal);
                    }
                }
                if ($pembayaran->status === StatusPembayaranPelatihanEnum::BELUM_BAYAR || $pembayaran->status === StatusPembayaranPelatihanEnum::SUDAH_BAYAR) {
                    $pembayaran->update([
                        "status" => StatusPembayaranPelatihanEnum::DIKEMBALIKAN
                    ]);
                }
            });
        }

        if ($pendaftaran_pelatihan->wasChanged()) {
            Toast::success('Pendaftaran pelatihan berhasil direview.');
        } else {
            Toast::success('Terjadi kesalahan.');
        }
        return redirect()->back();
    }
}
