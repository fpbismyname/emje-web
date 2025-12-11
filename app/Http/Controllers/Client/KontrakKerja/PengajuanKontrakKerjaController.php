<?php

namespace App\Http\Controllers\Client\KontrakKerja;

use App\Enums\KontrakKerja\StatusPengajuanKontrakKerja;
use App\Enums\Utils\PaginateSize;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\PengajuanKontrakKerjaRequest;
use App\Models\KontrakKerja;
use App\Models\PengajuanKontrakKerja;
use App\Services\Utils\Toast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PengajuanKontrakKerjaController extends Controller
{
    protected $relations = ['kontrak_kerja', 'kontrak_kerja_peserta'];
    public function index(Request $request, PengajuanKontrakKerja $pengajuan_kontrak_kerja_model)
    {
        $filters = $request->only('search', 'kategori_kontrak_kerja');

        $query = $pengajuan_kontrak_kerja_model->with($this->relations)->where('users_id', auth()->user()->id);

        foreach ($filters as $key => $value) {
            match ($key) {
                'search' => $query->whereHas('kontrak_kerja', fn($q) => $q->search($value)),
                default => $query->whereHas('kontrak_kerja', fn($q) => $q->search_by_column($key, $value))
            };
        }

        $datas = $query->latest()->paginate(PaginateSize::SMALL->value)->withQueryString();

        $payload = compact('datas');
        return view('client.kontrak-kerja.pengajuan-kontrak-kerja.index', $payload);
    }
    public function show(string $id, PengajuanKontrakKerja $pengajuan_kontrak_kerja_model)
    {
        $datas = $pengajuan_kontrak_kerja_model->findOrFail($id);
        $payload = compact('datas');
        return view('client.kontrak-kerja.pengajuan-kontrak-kerja.show', $payload);
    }
    public function create(Request $request, KontrakKerja $kontrak_kerja_model)
    {
        $kontrak_kerja_id = $request->query('kontrak_kerja_id');
        $datas = $kontrak_kerja_model->findOrFail($kontrak_kerja_id);
        $payload = compact('datas');
        return view('client.kontrak-kerja.pengajuan-kontrak-kerja.create', $payload);
    }
    public function store(PengajuanKontrakKerjaRequest $request, KontrakKerja $kontrak_kerja_model)
    {
        // Id kontrak kerja
        $data_kontrak_kerja = $request->validated();
        $id_kontrak_kerja = $request->get('kontrak_kerja_id');
        // Setup data for store
        $user = auth()->user();
        // Data kontrak kerja
        $kontrak_kerja = $kontrak_kerja_model->findOrFail($id_kontrak_kerja);
        // Private storage
        $private_storage = Storage::disk('local');
        // Upload files
        $uploaded_files = [
            'surat_pengajuan_kontrak' => $request->file('surat_pengajuan_kontrak')
        ];
        $path_uploaded = [];
        // pengajuan kontrak
        foreach ($uploaded_files as $key => $value) {
            if ($value) {
                $ext = $value->getClientOriginalExtension();
                $safeName = Str::slug($user->name);
                $fileName = "dp_{$safeName}_{$kontrak_kerja->nama_perusahaan}.{$ext}";
                $path = $private_storage->putFileAs('users/pengajuan_kontrak_kerja', $value, $fileName);
                $path_uploaded[$key] = $path;
            }
        }
        // simpan kontrak kerja path
        foreach ($path_uploaded as $key => $path) {
            $data_kontrak_kerja[$key] = $path;
        }

        // Simpan data pengajuan 
        $simpan_kontrak = $kontrak_kerja->pengajuan_kontrak_kerja()->create([
            'status' => StatusPengajuanKontrakKerja::DALAM_PROSES,
            'surat_pengajuan_kontrak' => $data_kontrak_kerja['surat_pengajuan_kontrak'],
            'users_id' => $user->id
        ]);

        if ($simpan_kontrak->wasRecentlyCreated) {
            Toast::success('Pengajuan kontrak kerja berhasil dikirim.');
        } else {
            Toast::error('Terjadi kesalahan.');
        }

        return redirect()->route('client.kontrak-kerja.pengajuan-kontrak-kerja.index');
    }
    public function edit(string $id, PengajuanKontrakKerja $pengajuan_kontrak_kerja_model)
    {
        $datas = $pengajuan_kontrak_kerja_model->findOrFail($id);
        $payload = compact('datas');
        return view('client.kontrak-kerja.pengajuan-kontrak-kerja.edit', $payload);
    }
    public function update(string $id, PengajuanKontrakKerjaRequest $request, PengajuanKontrakKerja $pengajuan_kontrak_kerja_model)
    {
        // Id kontrak kerja
        $data_kontrak_kerja = $request->validated();
        // Setup data for store
        $user = auth()->user();
        // Data kontrak kerja
        $pengajuan_kontrak_kerja = $pengajuan_kontrak_kerja_model->findOrFail($id);
        // Private storage
        $private_storage = Storage::disk('local');
        // Upload files
        $uploaded_files = [
            'surat_pengajuan_kontrak' => $request->file('surat_pengajuan_kontrak')
        ];
        $path_uploaded = [];
        // pengajuan kontrak
        foreach ($uploaded_files as $key => $value) {
            if ($value) {
                if ($private_storage->exists($pengajuan_kontrak_kerja->{$key})) {
                    $private_storage->delete($pengajuan_kontrak_kerja->{$key});
                }
                $ext = $value->getClientOriginalExtension();
                $safeName = Str::slug($user->name);
                $fileName = "dp_{$safeName}_{$pengajuan_kontrak_kerja->kontrak_kerja->nama_perusahaan}.{$ext}";
                $path = $private_storage->putFileAs('users/pengajuan_kontrak_kerja', $value, $fileName);
                $path_uploaded[$key] = $path;
            }
        }
        // simpan kontrak kerja path
        foreach ($path_uploaded as $key => $path) {
            $data_kontrak_kerja[$key] = $path;
        }

        // Simpan data pengajuan 
        $simpan_kontrak = $pengajuan_kontrak_kerja->update($data_kontrak_kerja);

        if ($simpan_kontrak) {
            Toast::success('Pengajuan kontrak kerja berhasil diperbarui.');
        } else {
            Toast::error('Terjadi kesalahan.');
        }

        return redirect()->route('client.kontrak-kerja.pengajuan-kontrak-kerja.show', [$pengajuan_kontrak_kerja->id]);
    }
}
