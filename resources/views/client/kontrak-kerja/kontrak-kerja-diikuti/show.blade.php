<x-layouts.client-app title="{{ $kontrak_kerjanama_gelombang }}">
    {{-- Data gelombang pelatihan --}}
    <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
        {{-- Nama Gelombang --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nama Gelombang</legend>
            <p class="w-full">{{ $kontrak_kerjanama_gelombang }}</p>
        </fieldset>

        {{-- Sesi Gelombang --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Sesi Gelombang</legend>
            <p class="w-full">{{ $kontrak_kerjasesi->label() }}</p>
        </fieldset>

        {{-- Tanggal Mulai --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Tanggal Mulai</legend>
            <p class="w-full">{{ $kontrak_kerjaformatted_tanggal_mulai }}</p>
        </fieldset>

        {{-- Tanggal Selesai --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Tanggal Selesai</legend>
            <p class="w-full">{{ $kontrak_kerjaformatted_tanggal_selesai }}</p>
        </fieldset>
    </div>

    <div class="divider"></div>

    {{-- Data hasil ujian --}}
    <div class="flex flex-col gap-4 p-4">
        <h6>Hasil ujian</h6>
        @if (isset($kontrak_kerjajadwal_ujian_pelatihan))
            <div class="flex flex-col gap-4">
                @foreach ($kontrak_kerjajadwal_ujian_pelatihan as $jadwal_ujian)
                    <div class="flex flex-col gap-6 rounded-box bg-base-200 p-4">
                        <div class="flex flex-col gap-2">
                            <p>{{ $jadwal_ujian->nama_ujian }}</p>
                            <small>{{ $jadwal_ujian->formatted_tanggal_mulai }} -
                                {{ $jadwal_ujian->formatted_tanggal_selesai }}</small>
                        </div>
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
                                @if (isset($kontrak_kerjajadwal_ujian_pelatihan->hasil_ujian_pelatihan))
                                    @foreach ($kontrak_kerjajadwal_ujian_pelatihan->hasil_ujian_pelatihan as $hasil_ujian)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>{{ $hasil_ujian->nama_materi }} </td>
                                            <td>{{ $hasil_ujian->nilai }}</td>
                                            <td>{{ $hasil_ujian->status->label() }}</td>
                                            @if (!$pelatihan_diikuti->status_lulus)
                                                <td>
                                                    <div class="flex flex-row gap-4 items-center">
                                                        <a href="{{ route('admin.pelatihan-peserta.detail.jadwal-ujian.hasil-ujian.edit', [$profil_user->id, $pelatihan_peserta->id, $jadwal_ujian->id, $hasil_ujian->id]) }}"
                                                            class="text-sm link link-primary link-hover">
                                                            Edit
                                                        </a>
                                                        <form method="post"
                                                            onsubmit="return confirm('Apakah anda yakin ingin menghapus {{ $hasil_ujian->nama_materi }} ?')"
                                                            action="{{ route('admin.pelatihan-peserta.detail.jadwal-ujian.hasil-ujian.destroy', [$profil_user->id, $pelatihan_peserta->id, $jadwal_ujian->id, $hasil_ujian->id]) }}">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit"
                                                                class="text-sm link link-error link-hover">Hapus</button>
                                                        </form>
                                                    </div>

                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>Tidak ada data hasil ujian.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </x-ui.table>
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
        @if ($pelatihan_diikuti->sertifikasi)
            <a href="{{ route('admin.sertifikasi.download', [$pelatihan_diikuti->sertifikasi->id]) }}"
                class="link link-hover link-primary">Unduh sertifikat
                pelatihan</a>
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
