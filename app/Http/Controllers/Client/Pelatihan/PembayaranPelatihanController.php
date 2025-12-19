<?php

namespace App\Http\Controllers\Client\Pelatihan;

use App\Enums\Pelatihan\JenisPembayaranEnum;
use App\Enums\Rekening\TipeTransaksiEnum;
use App\Enums\Utils\PaginateSize;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\PembayaranCicilanPelatihanRequest;
use App\Models\PelatihanPeserta;
use App\Models\PembayaranPelatihan;
use App\Models\Rekening;
use App\Services\Utils\Toast;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Str;

class PembayaranPelatihanController extends Controller
{
    protected $relations = ['pendaftaran_pelatihan', 'gelombang_pelatihan'];
    public function index(Request $request, PelatihanPeserta $pelatihan_peserta_model)
    {
        $filters = $request->only('search', 'kategori_pelatihan');

        $query = $pelatihan_peserta_model->with($this->relations)->whereHas('pendaftaran_pelatihan', fn($q) => $q->where('users_id', auth()->user()->id));

        foreach ($filters as $key => $value) {
            match ($key) {
                'search' => $query->whereHas('gelombang_pelatihan.pelatihan', fn($q) => $q->search($value)),
                default => $query->whereHas('gelombang_pelatihan.pelatihan', fn($q) => $q->search_by_column($key, $value))
            };
        }

        $datas = $query->latest()->paginate(PaginateSize::SMALL->value)->withQueryString();

        $payload = compact('datas');
        return view('client.pelatihan.pembayaran-pelatihan.index', $payload);
    }
    public function show(string $id, PelatihanPeserta $pelatihan_peserta_model)
    {
        $pelatihan_diikuti = $pelatihan_peserta_model->findOrFail($id);
        $payload = compact('pelatihan_diikuti');
        return view('client.pelatihan.pembayaran-pelatihan.show', $payload);
    }

    public function bayar_cicilan(string $id_pelatihan_diikuti, string $id_cicilan, PembayaranPelatihan $pembayaran_pelatihan_model)
    {
        $cicilan = $pembayaran_pelatihan_model->search_by_column('jenis_pembayaran', JenisPembayaranEnum::ANGSURAN)->where('id', $id_cicilan)->first();
        $payload = compact('cicilan', 'id_pelatihan_diikuti');
        return view('client.pelatihan.pembayaran-pelatihan.cicilan.bayar-cicilan', $payload);
    }
    public function submit_bayar_cicilan(
        PembayaranCicilanPelatihanRequest $request,
        string $id_pelatihan_diikuti,
        string $id_cicilan,
        PembayaranPelatihan $pembayaran_pelatihan_model,
        PelatihanPeserta $pelatihan_peserta_model,
        Rekening $rekening_model
    ) {
        $request->validated();

        // Data
        $rekening_bendahara = $rekening_model->rekening_bendahara()->first();
        $user = auth()->user();
        $bukti_pembayaran = $request->file('bukti_pembayaran');
        $pelatihan_diikuti = $pelatihan_peserta_model->findOrFail($id_pelatihan_diikuti);
        $pembayaran_pelatihan = $pembayaran_pelatihan_model->search_by_column('jenis_pembayaran', JenisPembayaranEnum::ANGSURAN)->where('id', $id_cicilan)->first();

        // Kirim bukti
        $private_storage = Storage::disk('local');
        $path_bukti_pembayaran = null;
        if (!empty($bukti_pembayaran)) {
            $ext_file = $bukti_pembayaran->getClientOriginalExtension();
            $safe_nama_pelatihan = Str::slug($pelatihan_diikuti->gelombang_pelatihan->nama_gelombang);
            $safe_name = Str::slug($user->name);
            $file_name = "pembayaran_angsuran_cicilan_pelatihan_{$safe_nama_pelatihan}_dari_{$safe_name}.{$ext_file}";
            $path_bukti_pembayaran = $private_storage->putFileAs('users/pembayaran_pelatihan', $bukti_pembayaran, $file_name);
        }

        // Update data cicilan
        $pembayaran_pelatihan->bukti_pembayaran = $path_bukti_pembayaran;
        $bukti_dikirim = $pembayaran_pelatihan->save();

        // Masukan data transaksi
        $catat_transaksi = $rekening_bendahara->transaksi_rekening()->create([
            'nominal_transaksi' => $pembayaran_pelatihan->nominal,
            'tipe_transaksi' => TipeTransaksiEnum::PEMASUKAN,
            'keterangan' => "Pembayaran angsuran untuk pelatihan {$pelatihan_diikuti->gelombang_pelatihan->nama_gelombang} dari {$user->name}",
        ]);

        // Tambah saldo 
        if ($catat_transaksi) {
            $rekening_bendahara->increment('saldo', $pembayaran_pelatihan->nominal);
        }

        if ($bukti_dikirim) {
            Toast::success("Pembayaran angsuran pelatihan {$pelatihan_diikuti->gelombang_pelatihan->nama_gelombang} berhasil dikirim.");
        } else {
            Toast::error("Terjadi kesalahan.");
        }
        return redirect()->route('client.pelatihan.pembayaran-pelatihan.show', [$pelatihan_diikuti->id]);
    }
}
