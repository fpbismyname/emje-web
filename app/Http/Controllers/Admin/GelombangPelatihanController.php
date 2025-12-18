<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Pelatihan\SesiGelombangPelatihanEnum;
use App\Enums\Utils\PaginateSize;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GelombangPelatihanRequest;
use App\Models\GelombangPelatihan;
use App\Models\Pelatihan;
use App\Services\Utils\Toast;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class GelombangPelatihanController extends Controller
{
    public function index(Request $request, GelombangPelatihan $gelombang_pelatihan_model)
    {
        $filters = $request->only('search', 'sesi');

        $query = $gelombang_pelatihan_model->query();

        foreach ($filters as $key => $value) {
            match ($key) {
                'search' => $query->search($value),
                default => $query->search_by_column($key, $value)
            };
        }

        $datas = $query->latest()->paginate(PaginateSize::SMALL->value)->withQueryString();

        $payload = compact('datas');
        return view('admin.gelombang-pelatihan.index', $payload);
    }
    public function create()
    {
        return view('admin.gelombang-pelatihan.create');

    }
    public function store(GelombangPelatihanRequest $request, Pelatihan $pelatihan_model)
    {
        $create_entries = $request->validated();

        $pelatihan = $pelatihan_model->findOrFail($create_entries['pelatihan_id']);

        $durasi_pelatihan = $pelatihan->durasi_pelatihan;
        // $create_entries['tanggal_selesai'] = Carbon::parse($create_entries['tanggal_mulai'])->addMonths($durasi_pelatihan);

        match (true) {
            Carbon::parse($create_entries['tanggal_mulai'])->isFuture() => $create_entries['sesi'] = SesiGelombangPelatihanEnum::PENDAFTARAN,
            Carbon::parse($create_entries['tanggal_mulai'])->isToday() || Carbon::parse($create_entries['tanggal_mulai'])->isPast() => $create_entries['sesi'] = SesiGelombangPelatihanEnum::BERLANGSUNG,
        };

        $gelombang_pelatihan = $pelatihan->gelombang_pelatihan()->create($create_entries);

        if ($gelombang_pelatihan->wasRecentlyCreated) {
            Toast::success("Data gelombang pelatihan {$gelombang_pelatihan->nama_gelombang} berhasil ditambahkan.");
        } else {
            Toast::error("Terjadi kesalahan.");
        }
        return redirect()->route('admin.gelombang-pelatihan.index');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id, GelombangPelatihan $gelombang_pelatihan_model)
    {
        $gelombang_pelatihan = $gelombang_pelatihan_model->findOrFail($id);
        $jadwal_ujian_pelatihan = $gelombang_pelatihan->jadwal_ujian_pelatihan()->paginate(PaginateSize::SMALL->value);
        $payload = compact('gelombang_pelatihan', 'jadwal_ujian_pelatihan');
        return view('admin.gelombang-pelatihan.show', $payload);
    }
    public function edit(string $id, GelombangPelatihan $gelombang_pelatihan_model)
    {
        $gelombang_pelatihan = $gelombang_pelatihan_model->findOrFail($id);
        $payload = compact('gelombang_pelatihan');
        return view('admin.gelombang-pelatihan.edit', $payload);
    }
    public function update(GelombangPelatihanRequest $request, string $id, GelombangPelatihan $gelombang_pelatihan_model)
    {
        $update_entries = $request->validated();
        $gelombang_pelatihan = $gelombang_pelatihan_model->findOrFail($id);

        $durasi_pelatihan = $gelombang_pelatihan->pelatihan->durasi_pelatihan;
        // $update_entries['tanggal_selesai'] = Carbon::parse($update_entries['tanggal_mulai'])->addMonths($durasi_pelatihan);

        match (true) {
            Carbon::parse($update_entries['tanggal_mulai'])->isFuture() => $update_entries['sesi'] = SesiGelombangPelatihanEnum::PENDAFTARAN,
            Carbon::parse($update_entries['tanggal_mulai'])->isToday() || Carbon::parse($update_entries['tanggal_mulai'])->isPast() => $update_entries['sesi'] = SesiGelombangPelatihanEnum::BERLANGSUNG,
        };

        $gelombang_pelatihan->update($update_entries);

        if ($gelombang_pelatihan->wasChanged()) {
            Toast::success('Gelombang pelatihan berhasil diperbarui.');
        } else {
            Toast::error('Terjadi kesalahan.');
        }
        return redirect()->back();
    }
    public function destroy(string $id, GelombangPelatihan $gelombang_pelatihan_model)
    {
        $gelombang_pelatihan = $gelombang_pelatihan_model->findOrFail($id);
        $delete_gelombang_pelatihan = $gelombang_pelatihan->delete();
        if ($delete_gelombang_pelatihan) {
            Toast::success("Data gelombang pelatihan {$gelombang_pelatihan->nama_gelombang} berhasil dihapus.");
        } else {
            Toast::error("Terjadi kesalahan.");
        }
        return redirect()->back();
    }
}
