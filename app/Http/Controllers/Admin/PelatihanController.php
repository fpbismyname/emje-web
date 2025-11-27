<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Utils\PaginateSize;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PelatihanRequest;
use App\Models\Pelatihan;
use App\Services\Utils\Toast;
use Illuminate\Http\Request;

class PelatihanController extends Controller
{
    public function index(Request $request, Pelatihan $pelatihan_model)
    {

        $filters = $request->only('search', 'status', 'kategori_pelatihan');

        $query = $pelatihan_model->query();

        foreach ($filters as $key => $value) {
            match ($key) {
                'search' => $query->search($value),
                default => $query->search_by_column($key, $value)
            };
        }

        $datas = $query->latest()->paginate(PaginateSize::SMALL->value)->withQueryString();

        $payload = compact('datas');
        return view('admin.pelatihan.index', $payload);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pelatihan.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PelatihanRequest $request, Pelatihan $pelatihan_model)
    {
        $create_entries = $request->validated();
        $pelatihan = $pelatihan_model->create($create_entries);
        if ($pelatihan->wasRecentlyCreated) {
            Toast::success("Data pelatihan {$pelatihan->nama_pelatihan} berhasil ditambahkan.");
        } else {
            Toast::error("Terjadi kesalahan.");
        }
        return redirect()->route('admin.pelatihan.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Pelatihan $pelatihan_model)
    {
        $pelatihan = $pelatihan_model->findOrFail($id);
        $payload = compact('pelatihan');
        return view('admin.pelatihan.show', $payload);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Pelatihan $pelatihan_model)
    {
        $pelatihan = $pelatihan_model->findOrFail($id);
        $payload = compact('pelatihan');
        return view('admin.pelatihan.edit', $payload);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PelatihanRequest $request, string $id, Pelatihan $pelatihan_model)
    {
        $update_entries = $request->validated();
        $pelatihan = $pelatihan_model->findOrFail($id);
        $pelatihan->update($update_entries);
        if ($pelatihan->wasChanged()) {
            Toast::success("Data pelatihan {$pelatihan->nama_pelatihan} berhasil diperbarui.");
        } elseif (empty($pelatihan->getChanges())) {
            Toast::info('Tidak ada perubahan yang dilakukan.');
        } else {
            Toast::error('Terjadi kesalahan.');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Pelatihan $pelatihan_model)
    {
        $pelatihan = $pelatihan_model->findOrFail($id);
        $delete_pelatihan = $pelatihan->delete();
        if ($delete_pelatihan) {
            Toast::success("Data pelatihan {$pelatihan->nama_pelatihan} berhasil dihapus.");
        } else {
            Toast::error("Terjadi kesalahan.");
        }
        return redirect()->back();
    }
}
