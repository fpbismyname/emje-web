<x-layouts.admin-app title="Detail pelatihan">
    {{-- Data pelatihan --}}
    <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
        {{-- Nama Pelatihan --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nama Pelatihan</legend>
            <p class="py-2">{{ $pelatihan->nama_pelatihan }}</p>
        </fieldset>

        {{-- Nominal Biaya --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nominal Biaya</legend>
            <p class="py-2">{{ $pelatihan->formatted_nominal_biaya }}</p>
        </fieldset>

        {{-- Durasi (Bulan) --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Durasi (Bulan)</legend>
            <p class="py-2">{{ $pelatihan->durasi_bulan }} bulan</p>
        </fieldset>

        {{-- Kategori Pelatihan --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Kategori Pelatihan</legend>
            <p class="py-2">{{ $pelatihan->kategori_pelatihan->label() }}</p>
        </fieldset>

        {{-- Deskripsi --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Deskripsi</legend>
            <p class="py-2 whitespace-pre-wrap">{{ $pelatihan->deskripsi }}</p>
        </fieldset>

        {{-- Status --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Status</legend>
            <p class="py-2">{{ ucfirst($pelatihan->status->label()) }}</p>
        </fieldset>
    </div>

    {{-- Action  --}}
    <div class="grid place-items-center">
        <div class="flex flex-row gap-2">
            <a href="{{ route('admin.pelatihan.index') }}" class="btn btn-neutral">Kembali</a>
        </div>
    </div>
</x-layouts.admin-app>
