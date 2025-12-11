<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Utils\PaginateSize;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\KontrakKerjaRequest;
use App\Models\KontrakKerja;
use App\Services\Utils\Toast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KontrakKerjaController extends Controller
{
    public function index(Request $request, KontrakKerja $kontrak_kerja_model)
    {

        $filters = $request->only('search', 'kategori_kontrak_kerja');

        $query = $kontrak_kerja_model->query()->kontrak_kerja_aktif();

        foreach ($filters as $key => $value) {
            match ($key) {
                'search' => $query->search($value),
                default => $query->search_by_column($key, $value)
            };
        }

        $datas = $query->latest()->paginate(PaginateSize::SMALL->value)->withQueryString();

        $payload = compact('datas');
        return view('admin.kontrak-kerja.index', $payload);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kontrak-kerja.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KontrakKerjaRequest $request, KontrakKerja $kontrak_kerja_model)
    {
        $create_entries = $request->validated();

        // Upload files
        $uploadedFiles = [
            'surat_kontrak' => $request->file('surat_kontrak'),
        ];

        $private_storage = Storage::disk('local');

        $path_uploaded_file = [];

        foreach ($uploadedFiles as $key => $file) {
            if ($file) {
                $ext = $file->getClientOriginalExtension();
                $safeName = Str::slug($create_entries['nama_perusahaan']);

                $fileName = "{$key}_{$safeName}." . $ext;

                $path_uploaded_file[$key] = $private_storage->putFileAs("kontrak_kerja/surat_kontrak/{$key}", $file, $fileName);
            }
        }

        // set path
        foreach ($path_uploaded_file as $key => $value) {
            $create_entries[$key] = $value;
        }

        $kontrak_kerja = $kontrak_kerja_model->create($create_entries);

        if ($kontrak_kerja->wasRecentlyCreated) {
            Toast::success("Data kontrak kerja {$kontrak_kerja->nama_perusahaan} berhasil ditambahkan.");
        } else {
            Toast::error("Terjadi kesalahan.");
        }
        return redirect()->route('admin.kontrak-kerja.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, KontrakKerja $kontrak_kerja_model)
    {
        $kontrak_kerja = $kontrak_kerja_model->findOrFail($id);
        $payload = compact('kontrak_kerja');
        return view('admin.kontrak-kerja.show', $payload);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, KontrakKerja $kontrak_kerja_model)
    {
        $kontrak_kerja = $kontrak_kerja_model->findOrFail($id);
        $payload = compact('kontrak_kerja');
        return view('admin.kontrak-kerja.edit', $payload);
    }

    public function update(KontrakKerjaRequest $request, string $id, KontrakKerja $kontrak_kerja_model)
    {
        $update_entries = $request->validated();
        $kontrak_kerja = $kontrak_kerja_model->findOrFail($id);

        // Upload files
        $uploadedFiles = [
            'surat_kontrak' => $request->file('surat_kontrak'),
        ];

        $private_storage = Storage::disk('local');

        $path_uploaded_file = [];

        foreach ($uploadedFiles as $key => $file) {
            if ($file) {

                if ($private_storage->exists($kontrak_kerja?->{$key})) {
                    $private_storage->delete($kontrak_kerja->{$key});
                }

                $ext = $file->getClientOriginalExtension();
                $safeName = Str::slug($update_entries['nama_perusahaan']);

                $fileName = "{$key}_{$safeName}." . $ext;

                $path_uploaded_file[$key] = $private_storage->putFileAs("kontrak_kerja/{$key}", $file, $fileName);
            }
        }

        foreach ($path_uploaded_file as $key => $value) {
            $update_entries[$key] = $value;
        }

        $update_kontrak = $kontrak_kerja->update($update_entries);

        if ($update_kontrak) {
            Toast::success("Data kontrak kerja {$kontrak_kerja->nama_perusahaan} berhasil diperbarui.");
        } else {
            Toast::error('Terjadi kesalahan.');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, KontrakKerja $kontrak_kerja_model)
    {
        $kontrak_kerja = $kontrak_kerja_model->findOrFail($id);
        $delete_kontrak_kerja = $kontrak_kerja->delete();
        if ($delete_kontrak_kerja) {
            Toast::success("Data kontrak kerja {$kontrak_kerja->nama_perusahaan} berhasil dihapus.");
        } else {
            Toast::error("Terjadi kesalahan.");
        }
        return redirect()->back();
    }
}
