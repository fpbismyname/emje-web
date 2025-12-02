<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Pelatihan\StatusJadwalUjianPelatihanEnum;
use App\Enums\Utils\PaginateSize;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JadwalUjianPelatihanRequest;
use App\Models\GelombangPelatihan;
use App\Models\JadwalUjianPelatihan;
use App\Services\Utils\Toast;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class JadwalUjianPelatihanController extends Controller
{
    public function index(Request $request, JadwalUjianPelatihan $jadwal_ujian_pelatihan_model)
    {
        $filters = $request->only('search', 'status');

        $query = $jadwal_ujian_pelatihan_model->query();

        foreach ($filters as $key => $value) {
            match ($key) {
                'search' => $query->search($value),
                default => $query->search_by_column($key, $value)
            };
        }

        $datas = $query->latest()->paginate(PaginateSize::SMALL->value)->withQueryString();

        $payload = compact('datas');
        return view('admin.jadwal-ujian-pelatihan.index', $payload);
    }
    public function show(string $id, string $jadwal_ujian_id, GelombangPelatihan $gelombang_pelatihan_model, JadwalUjianPelatihan $jadwal_ujian_pelatihan_model)
    {
        $jadwal_ujian_pelatihan = $gelombang_pelatihan_model->findOrFail($id)->jadwal_ujian_pelatihan()->findOrFail($jadwal_ujian_id);
        $payload = compact('jadwal_ujian_pelatihan');
        return view('admin.gelombang-pelatihan.jadwal-ujian-pelatihan.show', $payload);
    }
    public function create(string $id, GelombangPelatihan $gelombang_pelatihan_model)
    {
        $gelombang_pelatihan = $gelombang_pelatihan_model->findOrFail($id);
        $payload = compact('gelombang_pelatihan');
        return view('admin.gelombang-pelatihan.jadwal-ujian-pelatihan.create', $payload);
    }
    public function store(string $id, JadwalUjianPelatihanRequest $request, GelombangPelatihan $gelombang_pelatihan_model)
    {
        $create_entries = $request->validated();

        $gelombang_pelatihan = $gelombang_pelatihan_model->findOrFail($id);

        $tanggal_mulai = $request->get('tanggal_mulai');

        match (true) {
            Carbon::parse($tanggal_mulai)->isPast() => $create_entries['status'] = StatusJadwalUjianPelatihanEnum::BERLANGSUNG,
            Carbon::parse($tanggal_mulai)->isFuture() => $create_entries['status'] = StatusJadwalUjianPelatihanEnum::TERJADWAL,
        };

        $jadwal_ujian_pelatihan = $gelombang_pelatihan->jadwal_ujian_pelatihan()->create($create_entries);

        if ($jadwal_ujian_pelatihan->wasRecentlyCreated) {
            Toast::success("Data jadwal ujian {$jadwal_ujian_pelatihan->nama_ujian} berhasil ditambahkan.");
        } else {
            Toast::error("Terjadi kesalahan.");
        }
        return redirect()->route('admin.gelombang-pelatihan.show', [$id]);
    }
    public function edit(string $id, string $jadwal_ujian_id, GelombangPelatihan $gelombang_pelatihan_model, JadwalUjianPelatihan $jadwal_ujian_pelatihan_model)
    {
        $jadwal_ujian = $gelombang_pelatihan_model->findOrFail($id)->jadwal_ujian_pelatihan()->findOrFail($jadwal_ujian_id);
        $payload = compact('jadwal_ujian');
        return view('admin.gelombang-pelatihan.jadwal-ujian-pelatihan.edit', $payload);
    }
    public function update(string $id, string $jadwal_ujian_id, JadwalUjianPelatihanRequest $request, GelombangPelatihan $gelombang_pelatihan_model)
    {
        $update_entries = $request->validated();

        $gelombang_pelatihan = $gelombang_pelatihan_model->findOrFail($id);

        $tanggal_mulai = $request->get('tanggal_mulai');

        match (true) {
            Carbon::parse($tanggal_mulai)->isPast() => $update_entries['status'] = StatusJadwalUjianPelatihanEnum::BERLANGSUNG,
            Carbon::parse($tanggal_mulai)->isFuture() => $update_entries['status'] = StatusJadwalUjianPelatihanEnum::TERJADWAL,
        };

        $jadwal_ujian_pelatihan = $gelombang_pelatihan->jadwal_ujian_pelatihan()->findOrFail($jadwal_ujian_id);
        $jadwal_ujian_pelatihan->update($update_entries);

        if ($jadwal_ujian_pelatihan->wasChanged()) {
            Toast::success("Data jadwal ujian {$jadwal_ujian_pelatihan->nama_ujian} berhasil ditambahkan.");
        } elseif (!$jadwal_ujian_pelatihan->getChanges()) {
            Toast::info("Tidak ada perubahan yang dilakukan.");
        } else {
            Toast::error("Terjadi kesalahan.");
        }

        return redirect()->back();
    }
    public function destroy(string $id, string $jadwal_ujian_id, GelombangPelatihan $gelombang_pelatihan_model, JadwalUjianPelatihan $jadwal_ujian_pelatihan_model)
    {
        $gelombang_pelatihan = $gelombang_pelatihan_model->findOrFail($id);
        $jadwal_ujian = $gelombang_pelatihan->jadwal_ujian_pelatihan()->findOrFail($jadwal_ujian_id);
        $delete_jadwal = $jadwal_ujian->delete();
        if ($delete_jadwal) {
            Toast::success("Data pelatihan {$jadwal_ujian->nama_ujian} berhasil dihapus.");
        } else {
            Toast::error("Terjadi kesalahan.");
        }
        return redirect()->back();
    }
}
