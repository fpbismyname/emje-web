<x-layouts.client-app title="{{ $pelatihan_diikuti->gelombang_pelatihan->nama_gelombang }}">
    {{-- Data gelombang pelatihan --}}
    <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
        {{-- Nama Gelombang --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nama Gelombang</legend>
            <p class="w-full">{{ $pelatihan_diikuti->gelombang_pelatihan->nama_gelombang }}</p>
        </fieldset>

        {{-- Sesi Gelombang --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Sesi Gelombang</legend>
            <p class="w-full">{{ $pelatihan_diikuti->gelombang_pelatihan->sesi->label() }}</p>
        </fieldset>

        {{-- Tanggal Mulai --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Tanggal Mulai</legend>
            <p class="w-full">{{ $pelatihan_diikuti->gelombang_pelatihan->formatted_tanggal_mulai }}</p>
        </fieldset>

        {{-- Tanggal Selesai --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Tanggal Selesai</legend>
            <p class="w-full">{{ $pelatihan_diikuti->gelombang_pelatihan->formatted_tanggal_selesai }}</p>
        </fieldset>
    </div>

    <div class="divider"></div>

    {{-- Data hasil ujian --}}
    <div class="flex flex-col gap-4 p-4">
        <h6>Ujian pelatihan</h6>
        @if (isset($pelatihan_diikuti->gelombang_pelatihan->jadwal_ujian_pelatihan))
            <div class="flex flex-col gap-4">
                @foreach ($pelatihan_diikuti->gelombang_pelatihan->jadwal_ujian_pelatihan as $jadwal_ujian)
                    <div class="flex flex-col gap-6 rounded-box bg-base-200 p-4">
                        <div class="flex flex-col gap-2">
                            <p>{{ $jadwal_ujian->nama_ujian }}</p>
                            <small>{{ $jadwal_ujian->formatted_tanggal_mulai }} -
                                {{ $jadwal_ujian->formatted_tanggal_selesai }}</small>
                            <div class="flex flex-row gap-2">
                                <div class="badge badge-accent badge-sm">{{ $jadwal_ujian->jenis_ujian->label() }}
                                </div>
                                <div class="badge badge-secondary badge-sm">{{ $jadwal_ujian->lokasi }}</div>
                                <div class="badge badge-primary badge-sm">{{ $jadwal_ujian->status->label() }}</div>
                            </div>
                        </div>
                        @if ($jadwal_ujian->jenis_ujian === App\Enums\Pelatihan\JenisUjianEnum::PELATIHAN)
                            <x-ui.table>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama materi</th>
                                        <th>Nilai</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($jadwal_ujian->hasil_ujian_pelatihan()->exists())
                                        @foreach ($jadwal_ujian->hasil_ujian_pelatihan as $hasil_ujian)
                                            <tr>
                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>{{ $hasil_ujian->nama_materi }} </td>
                                                <td>{{ $hasil_ujian->nilai }}</td>
                                                <td>{{ $hasil_ujian->status->label() }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>Tidak ada data hasil ujian.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </x-ui.table>
                        @endif
                    </div>
                    @if (!$loop->last)
                        <div class="divider"></div>
                    @endif
                @endforeach
            </div>
        @else
            <p>Belum ada jadwal ujian.</p>
        @endif
    </div>

    <div class="divider"></div>

    <div class="flex flex-col gap-4 p-4">
        <h6>Sertifikasi</h6>
        @if ($pelatihan_diikuti->sertifikasi()->exists())
            @foreach ($pelatihan_diikuti->sertifikasi as $sertifikat)
                @if ($sertifikat->jenis_sertifikat === App\Enums\Pelatihan\JenisSertifikatEnum::PELATIHAN)
                    <a href="{{ route('client.sertifikasi.download', [$sertifikat->id]) }}"
                        class="link link-hover link-primary">
                        Unduh sertifikat {{ $sertifikat->jenis_sertifikat->value }}
                    </a>
                @else
                    <a href="{{ route('storage.private.download', ['file' => $sertifikat->sertifikat]) }}"
                        class="link link-hover link-primary">
                        Unduh sertifikat
                        {{ $sertifikat->jenis_sertifikat === App\Enums\Pelatihan\JenisSertifikatEnum::SSW ? 'Specified Skilled Worker' : $sertifikat->jenis_sertifikat->value }}
                    </a>
                @endif
            @endforeach
        @else
            <p>Belum ada sertifikasi.</p>
        @endif
    </div>

    {{-- Action  --}}
    <div class="grid place-items-center">
        <div class="flex flex-row gap-2">
            <a href="{{ route('client.pelatihan.pelatihan-diikuti.index') }}" class="btn btn-neutral">Kembali</a>
        </div>
    </div>
</x-layouts.client-app>
