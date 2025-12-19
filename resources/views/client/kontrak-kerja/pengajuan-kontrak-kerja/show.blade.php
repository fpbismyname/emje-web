<x-layouts.client-app title="Detail pengajuan kontrak kerja">

    {{-- Data kontrak kerja --}}
    <div class="grid md:grid-cols-2 gap-4 rounded-box">
        <div class="grid md:col-span-2">
            <h6>Data kontrak kerja</h6>
        </div>

        {{-- Nama perusahaan --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nama perusahaan</legend>
            <p>{{ $datas->kontrak_kerja->nama_perusahaan }}</p>
        </fieldset>

        {{-- Durasi kontrak kerja --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Durasi kontrak kerja</legend>
            <p>{{ $datas->kontrak_kerja->formatted_durasi_kontrak_kerja }}</p>
        </fieldset>

        {{-- Kategori kontrak kerja --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Kategori kontrak kerja</legend>
            <p>{{ $datas->kontrak_kerja->kategori_kontrak_kerja->label() }}</p>
        </fieldset>

        {{-- Deskripsi kontrak kerja --}}
        <div class="grid md:col-span-2">
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Deskripsi</legend>
                <p class="whitespace-pre-line">{{ $datas->kontrak_kerja->deskripsi }}</p>
            </fieldset>
        </div>

        {{-- Maksimal pelamar --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Maksimal pelamar</legend>
            <p>{{ $datas->kontrak_kerja->maksimal_pelamar }}</p>
        </fieldset>

        {{-- Gaji tertinggi --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Gaji tertinggi</legend>
            <p>{{ $datas->kontrak_kerja->formatted_gaji_tertinggi }}</p>
        </fieldset>

        {{-- Gaji terendah --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Gaji terendah</legend>
            <p>{{ $datas->kontrak_kerja->formatted_gaji_terendah }}</p>
        </fieldset>

        {{-- Catatan --}}
        @if ($datas->catatan)
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Catatan</legend>
                <p>{{ $datas->catatan }}</p>
            </fieldset>
        @endif

        {{-- Sumber dana pemberangkatan --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Sumber dana pemberangkatan</legend>
            <p>{{ $datas->sumber_dana->label() }}</p>
        </fieldset>

        {{-- Surat pengajuan kontrak kerja --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Surat pengajuan kontrak kerja</legend>
            <a target="_blank" href="{{ route('storage.private.show', ['file' => $datas->surat_pengajuan_kontrak]) }}"
                class="link link-hover link-primary">Lihat selengkapnya</a>
        </fieldset>
    </div>

    {{-- Action  --}}
    <div class="grid place-items-center mt-4">
        <div class="flex flex-row gap-2">
            @if ($datas->status === App\Enums\KontrakKerja\StatusPengajuanKontrakKerja::PROSES_PENGAJUAN)
                <a href="{{ route('client.kontrak-kerja.pengajuan-kontrak-kerja.edit', [$datas->id]) }}"
                    class="btn btn-primary">Edit</a>
            @endif
            <a href="{{ route('client.kontrak-kerja.pengajuan-kontrak-kerja.index') }}"
                class="btn btn-neutral">Kembali</a>
        </div>
    </div>
</x-layouts.client-app>
