<x-layouts.client-app title="Detail kontrak kerja">
    {{-- Data gelombang pelatihan --}}
    <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
        {{-- Nama perusahaan --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nama perusahaan</legend>
            <p>{{ $kontrak_kerja->nama_perusahaan }}</p>
        </fieldset>

        {{-- Durasi kontrak kerja --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Durasi kontrak kerja</legend>
            <p>{{ $kontrak_kerja->formatted_durasi_kontrak_kerja }}</p>
        </fieldset>

        {{-- Kategori kontrak kerja --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Kategori kontrak kerja</legend>
            <p>{{ $kontrak_kerja->kategori_kontrak_kerja->label() }}</p>
        </fieldset>

        {{-- Deskripsi kontrak kerja --}}
        <div class="grid md:col-span-2">
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Deskripsi</legend>
                <p class="whitespace-pre-line">{{ $kontrak_kerja->deskripsi }}</p>
            </fieldset>
        </div>

        {{-- Maksimal pelamar --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Maksimal pelamar</legend>
            <p>{{ $kontrak_kerja->maksimal_pelamar }}</p>
        </fieldset>

        {{-- Gaji tertinggi --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Gaji tertinggi</legend>
            <p>{{ $kontrak_kerja->formatted_gaji_tertinggi }}</p>
        </fieldset>

        {{-- Gaji terendah --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Gaji terendah</legend>
            <p>{{ $kontrak_kerja->formatted_gaji_terendah }}</p>
        </fieldset>

    </div>

    {{-- Action  --}}
    <div class="grid place-items-center">
        <div class="flex flex-row gap-2">
            @if (auth()->user()->telah_mengikuti_pelatihan)
                <div class="{{ auth()->user()->profil_lengkap ? '' : 'tooltip' }}"
                    data-tip="Lengkapi data profil untuk melanjutkan pendaftaran">
                    @if (auth()->user()->profil_lengkap)
                        <a href="{{ route('client.kontrak-kerja.pengajuan-kontrak-kerja.create', ['kontrak_kerja_id' => $kontrak_kerja->id]) }}"
                            class="btn btn-primary">Ajukan kontrak kerja</a>
                    @endif
                @else
                    <div class="tooltip"
                        data-tip="Selesaikan salah satu pelatihan untuk dapat mengajukan kontrak kerja">
                        <a class="btn btn-error" href="{{ route('client.pelatihan.pelatihan-diikuti.index') }}">
                            <x-lucide-info class="w-4" />
                        </a>
                    </div>
            @endif
            <a href="{{ route('client.kontrak-kerja.daftar-kontrak-kerja.index') }}"
                class="btn btn-neutral">Kembali</a>
        </div>
    </div>
</x-layouts.client-app>
