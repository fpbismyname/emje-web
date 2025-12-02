<x-layouts.admin-app title="Detail pelatihan - {{ $gelombang_pelatihan->nama_gelombang }}">
    {{-- Data gelombang pelatihan --}}
    <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
        {{-- Nama Gelombang --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nama Gelombang</legend>
            <p class="w-full">{{ $gelombang_pelatihan->nama_gelombang }}</p>
        </fieldset>

        {{-- Sesi Gelombang --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Sesi Gelombang</legend>
            <p class="w-full">{{ $gelombang_pelatihan->sesi->label() }}</p>
        </fieldset>

        {{-- Tanggal Mulai --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Tanggal Mulai</legend>
            <p class="w-full">{{ $gelombang_pelatihan->formatted_tanggal_mulai }}</p>
        </fieldset>

        {{-- Tanggal Selesai --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Tanggal Selesai</legend>
            <p class="w-full">{{ $gelombang_pelatihan->formatted_tanggal_selesai }}</p>
        </fieldset>

        {{-- Maksimal peserta --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Maksimal peserta</legend>
            <p class="w-full">{{ $gelombang_pelatihan->total_maksimal_peserta }}</p>
        </fieldset>

    </div>

    <div class="divider"></div>

    {{-- Data ujian gelombang pelatihan --}}
    <div class="flex flex-col gap-4 p-4">
        <div class="flex flex-row justify-between items-center">
            <h6>Jadwal Ujian pelatihan</h6>
            <a href="{{ route('admin.gelombang-pelatihan.jadwal-ujian-pelatihan.create', [$gelombang_pelatihan->id]) }}"
                class="btn btn-primary btn-sm">Buat jadwal</a>
        </div>
        <div class="list bg-base-200 rounded-box">
            @if ($jadwal_ujian_pelatihan->isNotEmpty())
                @foreach ($jadwal_ujian_pelatihan as $jadwal_ujian)
                    <div class="list-row">
                        <div class="tabular-nums">
                            {{ $loop->iteration + ($jadwal_ujian_pelatihan->currentPage() - 1) * $jadwal_ujian_pelatihan->perPage() }}
                        </div>
                        <div class="list-col-grow">
                            <div class="flex flex-col gap-2">
                                <h6>
                                    {{ $jadwal_ujian->nama_ujian }}
                                </h6>
                                <small>Lokasi : {{ $jadwal_ujian->lokasi }}</small>
                                <small>
                                    {{ $jadwal_ujian->formatted_tanggal_mulai }} -
                                    {{ $jadwal_ujian->formatted_tanggal_selesai }}
                                </small>
                                <small
                                    class="badge badge-sm badge-primary">{{ $jadwal_ujian->status->label() }}</small>
                            </div>
                        </div>
                        <div class="flex flex-row gap-4">
                            <a href="{{ route('admin.gelombang-pelatihan.jadwal-ujian-pelatihan.show', [$gelombang_pelatihan->id, $jadwal_ujian->id]) }}"
                                class="btn btn-sm btn-primary">
                                Detail
                            </a>
                            <a href="{{ route('admin.gelombang-pelatihan.jadwal-ujian-pelatihan.edit', [$gelombang_pelatihan->id, $jadwal_ujian->id]) }}"
                                class="btn btn-sm btn-accent">
                                Edit
                            </a>
                            <form
                                action="{{ route('admin.gelombang-pelatihan.jadwal-ujian-pelatihan.destroy', [$gelombang_pelatihan->id, $jadwal_ujian->id]) }}"
                                method="post">
                                @csrf
                                @method('delete')
                                <button type="submit"
                                    onclick="return confirm('Apakah anda yakin ingin menghapus {{ $jadwal_ujian->nama_ujian }} ?')"
                                    class="btn btn-sm btn-error">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="list-row">
                    <div>Tidak ada jadwal ujian</div>
                </div>
            @endif
            {{ $jadwal_ujian_pelatihan->links('vendor.pagination.daisyui') }}
        </div>
    </div>

    {{-- Action  --}}
    <div class="grid place-items-center">
        <div class="flex flex-row gap-2"> {{-- Changed route from pelatihan.index to gelombang-pelatihan.index --}}
            <a href="{{ route('admin.gelombang-pelatihan.index') }}" class="btn btn-neutral">Kembali</a>
        </div>
    </div>
</x-layouts.admin-app>
