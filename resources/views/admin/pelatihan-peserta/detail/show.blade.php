<x-layouts.admin-app title="Detail pelatihan">
    {{-- Data pelatihan --}}
    <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
        <div class="grid md:col-span-2">
            <h6>Data pelatihan</h6>
        </div>
        {{-- Nama peserta --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nama peserta</legend>
            <p class="py-2">{{ $profil_user->nama_lengkap }}</p>
        </fieldset>

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

        {{-- Sesi gelombang --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Sesi gelombang</legend>
            <p class="py-2">{{ $pelatihan_peserta->gelombang_pelatihan->sesi->label() }}</p>
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
        <h6>Ujian pelatihan</h6>
        @if ($pelatihan_peserta->gelombang_pelatihan->jadwal_ujian_pelatihan->isNotEmpty())
            <div class="flex flex-col gap-4">
                @foreach ($pelatihan_peserta->gelombang_pelatihan->jadwal_ujian_pelatihan as $jadwal_ujian)
                    <div class="flex flex-col gap-6 rounded-box bg-base-200 p-4">
                        <div class="flex flex-row gap-2 justify-between flex-wrap">
                            <div class="flex flex-col gap-2">
                                <p>{{ $jadwal_ujian->nama_ujian }}</p>
                                <small>{{ $jadwal_ujian->formatted_tanggal_mulai }} -
                                    {{ $jadwal_ujian->formatted_tanggal_selesai }}</small>
                                <div class="flex flex-row gap-2">
                                    <div class="badge badge-accent badge-sm">{{ $jadwal_ujian->jenis_ujian->label() }}
                                    </div>
                                    <div class="badge badge-secondary badge-sm">{{ $jadwal_ujian->lokasi }}</div>
                                    <div class="badge badge-primary badge-sm">{{ $jadwal_ujian->status->label() }}
                                    </div>
                                </div>
                            </div>
                            @if ($jadwal_ujian->jenis_ujian === App\Enums\Pelatihan\JenisUjianEnum::PELATIHAN)
                                <div class="flex flex-row gap-2">
                                    @if (!$pelatihan_peserta->status_lulus)
                                        <a href="{{ route('admin.pelatihan-peserta.detail.jadwal-ujian.hasil-ujian.create', [$profil_user->id, $pelatihan_peserta->id, $jadwal_ujian->id]) }}"
                                            class="btn btn-primary">Tambah hasil ujian</a>
                                    @endif
                                </div>
                            @endif
                        </div>
                        @if ($jadwal_ujian->jenis_ujian === App\Enums\Pelatihan\JenisUjianEnum::PELATIHAN)
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
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p>Belum ada jadwal ujian.</p>
        @endif
    </div>

    <div class="divider"></div>

    <div class="flex flex-col gap-4 p-4">
        <div class="flex flex-row justify-between">
            <h6>Sertifikasi</h6>
            @if ($pelatihan_peserta->status === App\Enums\Pelatihan\StatusPelatihanPesertaEnum::LULUS)
                <a href="{{ route('admin.pelatihan-peserta.detail.sertifikasi.create', [$profil_user->id, $pelatihan_peserta->id]) }}"
                    class="btn btn-primary">Upload
                    sertifikat
                    lainnya</a>
            @endif
        </div>
        <ul class="list bg-base-200 rounded-box shadow-md">
            @if ($pelatihan_peserta->sertifikasi()->exists())
                @foreach ($pelatihan_peserta->sertifikasi as $sertifikat)
                    <li class="list-row">
                        <div class="list-col-grow">Sertifikat {{ $sertifikat->jenis_sertifikat->label() }}</div>
                        @if ($sertifikat->jenis_sertifikat === App\Enums\Pelatihan\JenisSertifikatEnum::PELATIHAN)
                            <a href="{{ route('admin.sertifikasi.download', [$sertifikat->id]) }}"
                                class="btn btn-primary btn-sm">
                                <x-lucide-download class="w-4" />
                            </a>
                        @else
                            <a href="{{ route('storage.private.download', ['file' => $sertifikat->sertifikat]) }}"
                                class="btn btn-primary btn-sm">
                                <x-lucide-download class="w-4" />
                            </a>
                        @endif
                        @if ($sertifikat->jenis_sertifikat !== App\Enums\Pelatihan\JenisSertifikatEnum::PELATIHAN)
                            <a href="{{ route('admin.pelatihan-peserta.detail.sertifikasi.edit', [$profil_user->id, $pelatihan_peserta->id, $sertifikat->id]) }}"
                                class="btn btn-secondary btn-sm">
                                <x-lucide-pencil class="w-4" />
                            </a>
                            <form method="post"
                                action="{{ route('admin.pelatihan-peserta.detail.sertifikasi.destroy', [$profil_user->id, $pelatihan_peserta->id, $sertifikat->id]) }}">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-error btn-sm">
                                    <x-lucide-trash class="w-4" />
                                </button>
                            </form>
                        @endif
                    </li>
                @endforeach
            @else
                <li class="list-row">
                    <p>Belum ada sertifikasi.</p>
                </li>
            @endif
        </ul>
    </div>

    {{-- Action  --}}
    <div class="grid place-items-center">
        <div class="flex flex-row gap-2">
            <a href="{{ route('admin.pelatihan-peserta.show', [$profil_user->id]) }}"
                class="btn btn-neutral">Kembali</a>
        </div>
    </div>
</x-layouts.admin-app>
