<x-layouts.admin-app title="Detail kontrak kerja peserta">
    {{-- Data peserta --}}
    <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
        <div class="grid md:col-span-2">
            <h6>Data peserta</h6>
        </div>
        {{-- Nama peserta --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nama peserta</legend>
            <p class="py-2">{{ $profil_user->nama_lengkap }}</p>
        </fieldset>
        {{-- Jenis kelamin --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Jenis kelamin</legend>
            <p class="py-2">{{ $profil_user->jenis_kelamin->label() }}</p>
        </fieldset>
        {{-- Pendidikan terakhir --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Pendidikan terakhir</legend>
            <p class="py-2">{{ $profil_user->pendidikan_terakhir->label() }}</p>
        </fieldset>
        {{-- Tanggal lahir --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Tanggal lahir</legend>
            <p class="py-2">{{ $profil_user->formatted_tanggal_lahir }}</p>
        </fieldset>
    </div>

    <div class="divider"></div>

    {{-- Data pelatihan --}}
    <div class="flex flex-col p-4 gap-4">
        <div class="grid md:col-span-2">
            <h6>Kontrak kerja diikuti</h6>
        </div>
        <ul class="list bg-base-200 rounded-box">
            @if ($pengajuan_kontrak_kerja->isNotEmpty())
                @foreach ($pengajuan_kontrak_kerja as $pengajuan_kontrak)
                    <li class="list-row">
                        <div class="tabular-nums">
                            {{ $loop->iteration }}
                        </div>
                        <div class="list-col-grow">
                            <div class="flex flex-col gap-2">
                                <div class="flex flex-col">
                                    <h6>{{ $pengajuan_kontrak->kontrak_kerja->nama_perusahaan }}</h6>
                                    <small>Durasi pelatihan :
                                        {{ $pengajuan_kontrak->kontrak_kerja->formatted_durasi_kontrak_kerja }}</small>
                                    <small>Tanggal kontrak berakhir :
                                        {{ $pengajuan_kontrak->kontrak_kerja->formatted_tanggal_kontrak_berakhir }}</small>
                                </div>
                                <div class="badge badge-sm badge-primary">
                                    {{ $pengajuan_kontrak->kontrak_kerja_peserta?->status->label() ?? $pengajuan_kontrak->status->label() }}
                                </div>
                            </div>
                        </div>
                        @if ($pengajuan_kontrak->status === App\Enums\KontrakKerja\StatusPengajuanKontrakKerja::DITERIMA)
                            <a class="btn btn-primary btn-sm"
                                href="{{ route('admin.kontrak-kerja-peserta.detail.show', [$profil_user->id, $pengajuan_kontrak->kontrak_kerja_peserta->id]) }}">
                                Detail
                            </a>
                        @endif
                    </li>
                @endforeach
            @else
                <li class="list-row">
                    <div class="tabular-nums">
                        Tidak ada kontrak kerja yang diikuti peserta.
                    </div>
                </li>
            @endif
        </ul>
    </div>

    {{-- Action  --}}
    <div class="grid place-items-center">
        <div class="flex flex-row gap-2">
            <a href="{{ route('admin.kontrak-kerja-peserta.index') }}" class="btn btn-neutral">Kembali</a>
        </div>
    </div>
</x-layouts.admin-app>
