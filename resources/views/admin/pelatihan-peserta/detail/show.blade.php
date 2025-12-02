<x-layouts.admin-app title="Detail pelatihan">
    {{-- Data peserta --}}
    <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
        <div class="grid md:col-span-2">
            <h6>Data pelatihan</h6>
        </div>
        {{-- Nama pelatihan --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nama pelatihan</legend>
            <p class="py-2">{{ $pelatihan_peserta->pendaftaran_pelatihan->pelatihan->nama_pelatihan }}</p>
        </fieldset>

        {{-- Durasi pelatihan --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Durasi peserta</legend>
            <p class="py-2">{{ $pelatihan_peserta->pendaftaran_pelatihan->pelatihan->formatted_durasi_pelatihan }}</p>
        </fieldset>

        {{-- Tanggal mulai --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Tanggal mulai</legend>
            <p class="py-2">{{ $pelatihan_peserta->gelombang_pelatihan->formatted_tanggal_mulai }}</p>
        </fieldset>

        {{-- Tanggal selesai --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Tanggal selesai</legend>
            <p class="py-2">{{ $pelatihan_peserta->gelombang_pelatihan->formatted_tanggal_selesai }}</p>
        </fieldset>

        {{-- Status pelatihan --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Status pelatihan</legend>
            <p class="py-2">{{ $pelatihan_peserta->status->label() }}</p>
        </fieldset>

        {{-- Gelombang pelatihan --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Gelombang pelatihan</legend>
            <p class="py-2">{{ $pelatihan_peserta->gelombang_pelatihan->nama_gelombang }}</p>
        </fieldset>
    </div>

    <div class="divider"></div>

    {{-- Jadwal ujian --}}
    <div class="flex flex-col gap-4 p-4">
        <h6>Hasil ujian</h6>
        @if ($pelatihan_peserta->gelombang_pelatihan->jadwal_ujian_pelatihan->isNotEmpty())
            <div class="flex flex-col gap-4">
                @foreach ($pelatihan_peserta->gelombang_pelatihan->jadwal_ujian_pelatihan as $jadwal_ujian)
                    <div class="flex flex-col gap-6 rounded-box bg-base-200 p-4">
                        <div class="flex flex-col gap-2">
                            <p>{{ $jadwal_ujian->nama_ujian }}</p>
                            <small>{{ $jadwal_ujian->formatted_tanggal_mulai }} -
                                {{ $jadwal_ujian->formatted_tanggal_selesai }}</small>
                            @if (!$pelatihan_peserta->status_lulus)
                                <a href="{{ route('admin.pelatihan-peserta.detail.jadwal-ujian.hasil-ujian.create', [$profil_user->id, $pelatihan_peserta->id, $jadwal_ujian->id]) }}"
                                    class="text-sm link link-hover link-primary w-fit">Tambah hasil ujian</a>
                            @endif
                        </div>
                        <x-ui.table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama materi</th>
                                    <th>Nilai</th>
                                    <th>Status</th>
                                    @if (!$pelatihan_peserta->status_lulus)
                                        <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if ($jadwal_ujian->hasil_ujian_pelatihan->isNotEmpty())
                                    @foreach ($jadwal_ujian->hasil_ujian_pelatihan as $hasil_ujian)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>{{ $hasil_ujian->nama_materi }} </td>
                                            <td>{{ $hasil_ujian->nilai }}</td>
                                            <td>{{ $hasil_ujian->status->label() }}</td>
                                            @if (!$pelatihan_peserta->status_lulus)
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
        @if ($pelatihan_peserta->sertifikasi)
            <a href="{{ route('admin.sertifikasi.download', [$pelatihan_peserta->sertifikasi->id]) }}"
                class="link link-hover link-primary">Unduh sertifikat
                pelatihan</a>
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
