<x-layouts.admin-app title="Detail jadwal ujian - {{ $jadwal_ujian_pelatihan->nama_ujian }}">
    <div class="grid md:grid-cols-2 gap-4 p-4">
        {{-- Nama ujian --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nama ujian</legend>
            <p>{{ $jadwal_ujian_pelatihan->nama_ujian }}</p>
        </fieldset>

        {{-- Lokasi --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Lokasi ujian</legend>
            <p>{{ $jadwal_ujian_pelatihan->lokasi }}</p>
        </fieldset>

        {{-- Status --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Status</legend>
            <p>{{ $jadwal_ujian_pelatihan->status->label() }}</p>
        </fieldset>

        {{-- Tanggal mulai --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Tanggal mulai</legend>
            <p>{{ $jadwal_ujian_pelatihan->formatted_tanggal_mulai }}</p>
        </fieldset>

        {{-- Tanggal selesai --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Tanggal selesai</legend>
            <p>{{ $jadwal_ujian_pelatihan->formatted_tanggal_selesai }}</p>
        </fieldset>
    </div>

    {{-- Action  --}}
    <div class="grid place-items-center">
        <div class="flex flex-row gap-2">
            <a href="{{ route('admin.gelombang-pelatihan.show', [$jadwal_ujian_pelatihan->gelombang_pelatihan->id]) }}"
                class="btn btn-neutral">Kembali</a>
        </div>
    </div>
</x-layouts.admin-app>
