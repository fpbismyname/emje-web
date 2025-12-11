<?php

namespace App\Http\Controllers\Client\Pelatihan;

use App\Enums\Pelatihan\JenisPembayaranEnum;
use App\Enums\Pelatihan\SkemaPembayaranEnum;
use App\Enums\Pelatihan\StatusPembayaranPelatihanEnum;
use App\Enums\Pelatihan\StatusPendaftaranPelatihanEnum;
use App\Enums\Rekening\TipeTransaksiEnum;
use App\Enums\Utils\PaginateSize;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\PendaftaranPelatihanRequest;
use App\Models\GelombangPelatihan;
use App\Models\PendaftaranPelatihan;
use App\Models\ProfilUser;
use App\Models\Rekening;
use App\Models\User;
use App\Services\Utils\Toast;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PendaftaranPelatihanController extends Controller
{
    protected $relations = ['pelatihan'];
    public function index(Request $request, PendaftaranPelatihan $pendaftaran_pelatihan_model)
    {
        $filters = $request->only('search', 'kategori_pelatihan');

        $query = $pendaftaran_pelatihan_model->with($this->relations)->where('users_id', auth()->user()->id);

        foreach ($filters as $key => $value) {
            match ($key) {
                'search' => $query->whereHas('pelatihan', fn($q) => $q->search($value)),
                default => $query->whereHas('pelatihan', fn($q) => $q->search_by_column($key, $value))
            };
        }

        $datas = $query->latest()->paginate(PaginateSize::SMALL->value)->withQueryString();

        $payload = compact('datas');
        return view('client.pelatihan.pendaftaran-pelatihan.index', $payload);
    }
    public function create(Request $request, GelombangPelatihan $gelombang_pelatihan_model)
    {
        $gelombang_id = $request->query('gelombang_id');
        $datas = $gelombang_pelatihan_model->findOrFail($gelombang_id);
        $payload = compact('datas');
        return view('client.pelatihan.pendaftaran-pelatihan.create', $payload);
    }
    public function store(
        PendaftaranPelatihanRequest $request,
        PendaftaranPelatihan $pendaftaran_pelatihan_model,
        GelombangPelatihan $gelombang_pelatihan_model,
        Rekening $rekening_model
    ) {
        $request->validated();

        // Setup data for store
        $user = auth()->user();
        $data_pendaftaran = $request->only($pendaftaran_pelatihan_model->getFillable());
        $data_skema_pembayaran = $data_pendaftaran['skema_pembayaran'];
        $data_bukti_pembayaran_dp = $request->file('bukti_pembayaran_dp');
        $data_bukti_pembayaran_cash = $request->file('bukti_pembayaran_cash');
        $data_gelombang_pelatihan = $gelombang_pelatihan_model->findOrFail($request->query('gelombang_id'));

        // Rekening
        $rekening_bendahara = $rekening_model->rekening_bendahara()->first();

        // Storage
        $private_storage = Storage::disk('local');

        // Pendaftaran
        $pendaftaran = $user->pendaftaran_pelatihan()->create([
            'pelatihan_id' => $data_gelombang_pelatihan->pelatihan_id,
            'gelombang_pelatihan_id' => $data_gelombang_pelatihan->id,
            'status' => StatusPendaftaranPelatihanEnum::DALAM_PROSES,
            ...$data_pendaftaran
        ]);

        // Input data pendaftaran
        if ($data_skema_pembayaran === SkemaPembayaranEnum::CASH->value) {

            $bayar_cash = $rekening_bendahara->transaksi_rekening()->create([
                'nominal_transaksi' => $data_gelombang_pelatihan->pelatihan->nominal_biaya,
                'tipe_transaksi' => TipeTransaksiEnum::PEMASUKAN,
                'keterangan' => "Pembayaran cash untuk pelatihan {$data_gelombang_pelatihan->pelatihan->nama_pelatihan} dari {$user->name}",
            ]);

            // Bukti cash
            if ($bayar_cash->wasRecentlyCreated) {
                // Simpan bukti pembayaran 
                $ext_cash = $data_bukti_pembayaran_cash->getClientOriginalExtension();
                $safeName_cash = Str::slug($user->name);
                $fileName_cash = "dp_{$safeName_cash}_{$data_gelombang_pelatihan->pelatihan->nama_pelatihan}.{$ext_cash}";
                $path_cash = $private_storage->putFileAs('users/pembayaran_pelatihan', $data_bukti_pembayaran_cash, $fileName_cash);
                // Catat pembayaran pelatihan
                // Tambah saldo
                $rekening_bendahara->increment('saldo', $data_gelombang_pelatihan->pelatihan->nominal_biaya);
                // catat pembayaran
                $pendaftaran->pembayaran_pelatihan()->create([
                    'nominal' => $bayar_cash->nominal_transaksi,
                    'status' => StatusPembayaranPelatihanEnum::SUDAH_BAYAR,
                    'jenis_pembayaran' => JenisPembayaranEnum::CASH,
                    'bukti_pembayaran' => $path_cash,
                    'catatan' => "Pembayaran cash untuk pelatihan {$data_gelombang_pelatihan->pelatihan->nama_pelatihan} dari {$user->name}",
                    'tanggal_pembayaran' => now(),
                ]);
            }


        }

        if ($data_skema_pembayaran === SkemaPembayaranEnum::CICILAN->value) {
            $persentase_dp = $data_gelombang_pelatihan->pelatihan->persentase_dp / 100;
            $nominal_dp = $persentase_dp * $data_gelombang_pelatihan->pelatihan->nominal_biaya;

            $bayar_dp = $rekening_bendahara->transaksi_rekening()->create([
                'nominal_transaksi' => $nominal_dp,
                'tipe_transaksi' => TipeTransaksiEnum::PEMASUKAN,
                'keterangan' => "Pembayaran dp untuk pelatihan {$data_gelombang_pelatihan->pelatihan->nama_pelatihan} dari {$user->name}",
            ]);

            // Bukti dp
            if ($bayar_dp->wasRecentlyCreated) {
                // Simpan bukti pembayaran 
                $ext_dp = $data_bukti_pembayaran_dp->getClientOriginalExtension();
                $safeName_dp = Str::slug($user->name);
                $fileName_dp = "dp_{$safeName_dp}_{$data_gelombang_pelatihan->pelatihan->nama_pelatihan}.{$ext_dp}";
                $path_dp = $private_storage->putFileAs('users/pembayaran_pelatihan', $data_bukti_pembayaran_dp, $fileName_dp);
                // Catat pembayaran pelatihan
                // Tambah saldo
                $rekening_bendahara->increment('saldo', $bayar_dp->nominal_transaksi);
                // catat pembayaran
                $pendaftaran->pembayaran_pelatihan()->create([
                    'nominal' => $bayar_dp->nominal_transaksi,
                    'status' => StatusPembayaranPelatihanEnum::SUDAH_BAYAR,
                    'jenis_pembayaran' => JenisPembayaranEnum::DP,
                    'bukti_pembayaran' => $path_dp,
                    'catatan' => "Pembayaran cash untuk pelatihan {$data_gelombang_pelatihan->pelatihan->nama_pelatihan} dari {$user->name}",
                    'tanggal_pembayaran' => now(),
                ]);
                // Buat cicilan 
                $tenor = $data_pendaftaran['tenor'];
                $nominal_cicilan = ($data_gelombang_pelatihan->pelatihan->nominal_biaya - $nominal_dp) / $tenor;
                $tanggal_mulai_cicilan = Carbon::parse($data_gelombang_pelatihan->tanggal_mulai);
                for ($i = 0; $i < $tenor; $i++) {
                    $pendaftaran->pembayaran_pelatihan()->create([
                        'nominal' => $nominal_cicilan,
                        'status' => StatusPembayaranPelatihanEnum::BELUM_BAYAR,
                        'jenis_pembayaran' => JenisPembayaranEnum::ANGSURAN,
                        'bukti_pembayaran' => null,
                        'tanggal_pembayaran' => $tanggal_mulai_cicilan->clone()->addMonths($i),
                    ]);
                }
            }

        }


        if ($pendaftaran->wasRecentlyCreated) {
            Toast::success("Data akun pengguna {$user->name} berhasil diperbarui.");
        } else {
            Toast::error('Terjadi kesalahan.');
        }

        return redirect()->route('client.pelatihan.pendaftaran-pelatihan.index');
    }
    public function show(string $id, PendaftaranPelatihan $pendaftaran_pelatihan_model)
    {
        $datas = $pendaftaran_pelatihan_model->findOrFail($id);
        $payload = compact('datas');
        return view('client.pelatihan.pendaftaran-pelatihan.show', $payload);
    }
}
