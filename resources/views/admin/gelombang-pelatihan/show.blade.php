<x-layouts.admin-app title="Detail pelatihan">
    {{-- Data pelatihan --}}
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
            <p class="w-full">{{ $gelombang_pelatihan->maksimal_peserta }}</p>
        </fieldset>

    </div>

    {{-- Action  --}}
    <div class="grid place-items-center">
        <div class="flex flex-row gap-2"> {{-- Changed route from pelatihan.index to gelombang-pelatihan.index --}}
            <a href="{{ route('admin.gelombang-pelatihan.index') }}" class="btn btn-neutral">Kembali</a>
        </div>
    </div>
</x-layouts.admin-app>
