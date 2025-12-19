<?php

namespace App\Http\Controllers\Client\KontrakKerja;

use App\Enums\Pelatihan\JenisPembayaranEnum;
use App\Enums\Rekening\TipeTransaksiEnum;
use App\Enums\Utils\PaginateSize;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\PembayaranCicilanPelatihanRequest;
use App\Models\KontrakKerjaPeserta;
use App\Models\PembayaranDanaTalang;
use App\Models\PembayaranPelatihan;
use App\Models\Rekening;
use App\Services\Utils\Toast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;

class PembayaranDanaTalangController extends Controller
{
    protected $relations = ['pengajuan_kontrak_kerja'];
    public function index(Request $request, KontrakKerjaPeserta $kontrak_kerja_peserta_model)
    {
        $filters = $request->only('search', 'kategori_pelatihan');

        $query = $kontrak_kerja_peserta_model->with($this->relations)->whereHas('pengajuan_kontrak_kerja', fn($q) => $q->where('users_id', auth()->user()->id));

        foreach ($filters as $key => $value) {
            match ($key) {
                'search' => $query->whereHas('pengajuan_kontrak_kerja.kontrak_kerja', fn($q) => $q->search($value)),
                default => $query->whereHas('pengajuan_kontrak_kerja.kontrak_kerja', fn($q) => $q->search_by_column($key, $value))
            };
        }

        $datas = $query->latest()->paginate(PaginateSize::SMALL->value)->withQueryString();

        $payload = compact('datas');
        return view('client.kontrak-kerja.pembayaran-dana-talang.index', $payload);
    }
    public function show(string $id, KontrakKerjaPeserta $kontrak_kerja_peserta_model)
    {
        $kontrak_kerja_diikuti = $kontrak_kerja_peserta_model->findOrFail($id);
        $payload = compact('kontrak_kerja_diikuti');
        return view('client.kontrak-kerja.pembayaran-dana-talang.show', $payload);
    }

    public function bayar_cicilan(string $id_kontrak_kerja_diikuti, string $id_cicilan, PembayaranDanaTalang $pembayaran_dana_talang_model)
    {
        $cicilan = $pembayaran_dana_talang_model->search_by_column('jenis_pembayaran', JenisPembayaranEnum::ANGSURAN)->where('id', $id_cicilan)->first();
        $payload = compact('cicilan', 'id_kontrak_kerja_diikuti');
        return view('client.kontrak-kerja.pembayaran-dana-talang.cicilan.bayar-cicilan', $payload);
    }
    public function submit_bayar_cicilan(
        PembayaranCicilanPelatihanRequest $request,
        string $id_kontrak_kerja_diikuti,
        string $id_cicilan,
        PembayaranDanaTalang $pembayaran_dana_talang_model,
        KontrakKerjaPeserta $kontrak_kerja_peserta_model,
        Rekening $rekening_model
    ) {
        $request->validated();

        // Data
        $rekening_bendahara = $rekening_model->rekening_bendahara()->first();
        $user = auth()->user();
        $bukti_pembayaran = $request->file('bukti_pembayaran');
        $kontrak_kerja_diikuti = $kontrak_kerja_peserta_model->findOrFail($id_kontrak_kerja_diikuti);
        $pembayaran_kontrak_kerja = $pembayaran_dana_talang_model->search_by_column('jenis_pembayaran', JenisPembayaranEnum::ANGSURAN)->where('id', $id_cicilan)->first();

        // Kirim bukti
        $private_storage = Storage::disk('local');
        $path_bukti_pembayaran = null;
        if (!empty($bukti_pembayaran)) {
            $ext_file = $bukti_pembayaran->getClientOriginalExtension();
            $safe_nama_pelatihan = Str::slug($kontrak_kerja_diikuti->pengajuan_kontrak_kerja->kontrak_kerja->nama_perusahaan);
            $safe_name = Str::slug($user->name);
            $file_name = "pembayaran_angsuran_cicilan_dana_talang_{$safe_nama_pelatihan}_dari_{$safe_name}.{$ext_file}";
            $path_bukti_pembayaran = $private_storage->putFileAs('users/pembayaran_dana_talang', $bukti_pembayaran, $file_name);
        }

        // Update data cicilan
        $pembayaran_kontrak_kerja->bukti_pembayaran = $path_bukti_pembayaran;
        $bukti_dikirim = $pembayaran_kontrak_kerja->save();

        // Masukan data transaksi
        $catat_transaksi = $rekening_bendahara->transaksi_rekening()->create([
            'nominal_transaksi' => $pembayaran_kontrak_kerja->nominal,
            'tipe_transaksi' => TipeTransaksiEnum::PEMASUKAN,
            'keterangan' => "Pembayaran angsuran cicilan dana talang untuk kontrak kerja {$kontrak_kerja_diikuti->pengajuan_kontrak_kerja->kontrak_kerja->nama_perusahaan} dari {$user->name}",
        ]);

        // Tambah saldo 
        if ($catat_transaksi) {
            $rekening_bendahara->increment('saldo', $pembayaran_kontrak_kerja->nominal);
        }

        if ($bukti_dikirim) {
            Toast::success("Pembayaran angsuran pelatihan {$kontrak_kerja_diikuti->pengajuan_kontrak_kerja->nama_perusahaan} berhasil dikirim.");
        } else {
            Toast::error("Terjadi kesalahan.");
        }
        return redirect()->route('client.kontrak-kerja.pembayaran-dana-talang.show', [$kontrak_kerja_diikuti->id]);
    }
}
