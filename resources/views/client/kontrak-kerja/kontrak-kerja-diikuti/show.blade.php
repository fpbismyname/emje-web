<x-layouts.client-app
    title="Detail Kontrak kerja - {{ $kontrak_kerja_diikuti->pengajuan_kontrak_kerja->kontrak_kerja->nama_perusahaan }}">
    {{-- Data kontrak kerja --}}
    <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
        {{-- Nama Perusahaan --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nama Perusahaan</legend>
            <p>{{ $kontrak_kerja_diikuti->pengajuan_kontrak_kerja->kontrak_kerja->nama_perusahaan }}</p>
        </fieldset>
        {{-- Rentang Gaji --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Rentang Gaji</legend>
            <p>{{ $kontrak_kerja_diikuti->pengajuan_kontrak_kerja->kontrak_kerja->formatted_rentang_gaji }}</p>
        </fieldset>
        {{-- Status --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Status</legend>
            <p>{{ $kontrak_kerja_diikuti->pengajuan_kontrak_kerja->kontrak_kerja->status->label() }}</p>
        </fieldset>
        {{-- Tanggal kontrak berakhir --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Tanggal kontrak berakhir</legend>
            <p>{{ $kontrak_kerja_diikuti->pengajuan_kontrak_kerja->kontrak_kerja->formatted_tanggal_kontrak_berakhir }}
            </p>
        </fieldset>
        {{-- Durasi Kontrak Kerja --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Durasi Kontrak Kerja</legend>
            <p>{{ $kontrak_kerja_diikuti->pengajuan_kontrak_kerja->kontrak_kerja->formatted_durasi_kontrak_kerja }}</p>
        </fieldset>
        {{-- Deskripsi --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Deskripsi</legend>
            <p class="whitespace-pre-line">
                {{ $kontrak_kerja_diikuti->pengajuan_kontrak_kerja->kontrak_kerja->deskripsi }}</p>
        </fieldset>
    </div>

    {{-- Action  --}}
    <div class="grid place-items-center">
        <div class="flex flex-row gap-2">
            <a href="{{ route('client.pelatihan.pelatihan-diikuti.index') }}" class="btn btn-neutral">Kembali</a>
        </div>
    </div>
</x-layouts.client-app>
