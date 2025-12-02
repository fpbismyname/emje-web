<?php

namespace App\Http\Controllers\Admin;

use App\Enums\KontrakKerja\StatusKontrakKerjaPesertaEnum;
use App\Enums\Pelatihan\StatusPelatihanPesertaEnum;
use App\Enums\User\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\KontrakKerja;
use App\Models\KontrakKerjaPeserta;
use App\Models\Pelatihan;
use App\Models\PelatihanPeserta;
use App\Models\PendaftaranPelatihan;
use App\Models\PengajuanKontrakKerja;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = [
            'total_pelatihan' => Pelatihan::get()->count(),
            'total_pendaftaran' => PendaftaranPelatihan::get()->count(),
            'total_peserta' => User::where('role', RoleEnum::PESERTA)->get()->count(),
            'total_kontrak_kerja' => KontrakKerja::get()->count(),
            'total_lamaran' => PengajuanKontrakKerja::get()->count(),
            'total_peserta_lulus' => PelatihanPeserta::where('status', StatusPelatihanPesertaEnum::LULUS)->count(),
            'total_kontrak_kerja_diterima' => KontrakKerjaPeserta::where('status', StatusKontrakKerjaPesertaEnum::BERLANGSUNG)->count()
        ];
        $payload = compact('datas');
        return view('admin.dashboard.index', $payload);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
