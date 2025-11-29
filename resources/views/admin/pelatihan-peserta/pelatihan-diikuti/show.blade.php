<x-layouts.admin-app title="Detail pelatihan diikuti">
    {{-- Data peserta --}}
    <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
        <div class="grid md:col-span-2">
            <h6>Data pelatihan</h6>
        </div>
        {{-- Nama pelatihan --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nama peserta</legend>
            <p class="py-2">{{ $pelatihan_diikuti->pendaftaran_pelatihan->pelatihan->nama_pelatihan }}</p>
        </fieldset>

        {{-- Durasi pelatihan --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Durasi peserta</legend>
            <p class="py-2">{{ $pelatihan_diikuti->pendaftaran_pelatihan->pelatihan->formatted_durasi_pelatihan }}</p>
        </fieldset>

        {{-- Tanggal mulai --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Tanggal mulai</legend>
            <p class="py-2">{{ $pelatihan_diikuti->gelombang_pelatihan->formatted_tanggal_mulai }}</p>
        </fieldset>

        {{-- Tanggal selesai --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Tanggal selesai</legend>
            <p class="py-2">{{ $pelatihan_diikuti->gelombang_pelatihan->formatted_tanggal_selesai }}</p>
        </fieldset>

        {{-- Gelombang pelatihan --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Gelombang pelatihan</legend>
            <p class="py-2">{{ $pelatihan_diikuti->gelombang_pelatihan->nama_gelombang }}</p>
        </fieldset>
    </div>

    <div class="divider"></div>

    <div class="flex flex-col gap-4 p-4">
        <h6>Jadwal Ujian</h6>
        @if ($pelatihan_diikuti->gelombang_pelatihan->jadwal_ujian_pelatihan)
            <ul class="list bg-base-200 rounded-box">
                @foreach ($pelatihan_diikuti->gelombang_pelatihan->jawdal_ujian_pelatihan as $jadwal_ujian)
                    <li class="list-row">
                        <div class="tabular-nums">{{ $loop->iteration }}</div>
                    </li>
                @endforeach
            </ul>
        @else
            <p>Belum ada jadwal ujian.</p>
        @endif
    </div>

    <div class="divider"></div>

    <div class="flex flex-col gap-4 p-4">
        <h6>Sertifikasi</h6>
        @if ($pelatihan_diikuti->sertifikasi)
            <ul class="list bg-base-200 rounded-box">
                @foreach ($pelatihan_diikuti->gelombang_pelatihan->jawdal_ujian_pelatihan as $jadwal_ujian)
                    <li class="list-row">
                        <div class="tabular-nums">{{ $loop->iteration }}</div>
                    </li>
                @endforeach
            </ul>
        @else
            <p>Belum ada sertifikasi.</p>
        @endif
    </div>

    {{-- Action  --}}
    <div class="grid place-items-center">
        <div class="flex flex-row gap-2">
            <a href="{{ route('admin.pelatihan-peserta.show', [$profil_user->id]) }}"
                class="btn btn-neutral">Kembali</a>
        </div>
    </div>
</x-layouts.admin-app>
