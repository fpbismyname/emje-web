<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Utils\PaginateSize;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JadwalUjianPelatihanRequest;
use App\Models\GelombangPelatihan;
use App\Models\JadwalUjianPelatihan;
use App\Services\Utils\Toast;
use Illuminate\Http\Request;

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
    public function create(GelombangPelatihan $gelombang_pelatihan_model)
    {
        $gelombang_pelatihan = $gelombang_pelatihan_model->tersedia_untuk_jadwal_ujian()->get();
        $payload = compact('gelombang_pelatihan');
        return view('admin.jadwal-ujian-pelatihan.create', $payload);
    }
    public function store(JadwalUjianPelatihanRequest $request, JadwalUjianPelatihan $jadwal_ujian_pelatihan_model)
    {
        $create_entries = $request->validated();
        $jadwal_ujian_pelatihan = $jadwal_ujian_pelatihan_model->create($create_entries);
        if ($jadwal_ujian_pelatihan->wasRecentlyCreated) {
            Toast::success("Data jadwal ujian {$jadwal_ujian_pelatihan->nama_ujian} berhasil ditambahkan.");
        } else {
            Toast::error("Terjadi kesalahan.");
        }
        return redirect()->route('admin.jadwal-ujian-pelatihan.index');
    }
}
