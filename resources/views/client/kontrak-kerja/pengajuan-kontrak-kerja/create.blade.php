<x-layouts.client-app title="Pengajuan kontrak kerja - {{ $datas->nama_perusahaan }}">
    {{-- Info --}}
    {{-- <div class="flex flex-col my-6 gap-4">
        <p class="whitespace-pre-line">{{ config('site.prosedur_pengajuan_surat_kontrak') }}</p>
        <div class="flex flex-row">
            <a class="btn btn-primary"
                href="{{ route('storage.private.download', ['file' => $datas->surat_kontrak]) }}">Download surat kontrak
                kerja</a>
        </div>
    </div> --}}

    {{-- Data kontrak kerja --}}
    <div class="grid md:grid-cols-2 gap-4 rounded-box">
        <div class="grid md:col-span-2">
            <h6>Data kontrak kerja</h6>
        </div>

        {{-- Nama perusahaan --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nama perusahaan</legend>
            <p>{{ $datas->nama_perusahaan }}</p>
        </fieldset>

        {{-- Durasi kontrak kerja --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Durasi kontrak kerja</legend>
            <p>{{ $datas->formatted_durasi_kontrak_kerja }}</p>
        </fieldset>

        {{-- Kategori kontrak kerja --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Kategori kontrak kerja</legend>
            <p>{{ $datas->kategori_kontrak_kerja->label() }}</p>
        </fieldset>

        {{-- Deskripsi kontrak kerja --}}
        <div class="grid md:col-span-2">
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Deskripsi</legend>
                <p class="whitespace-pre-line">{{ $datas->deskripsi }}</p>
            </fieldset>
        </div>

        {{-- Maksimal pelamar --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Maksimal pelamar</legend>
            <p>{{ $datas->maksimal_pelamar }}</p>
        </fieldset>

        {{-- Gaji tertinggi --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Gaji tertinggi</legend>
            <p>{{ $datas->formatted_gaji_tertinggi }}</p>
        </fieldset>

        {{-- Gaji terendah --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Gaji terendah</legend>
            <p>{{ $datas->formatted_gaji_terendah }}</p>
        </fieldset>
    </div>

    <div class="divider"></div>

    <form
        action="{{ route('client.kontrak-kerja.pengajuan-kontrak-kerja.store', ['kontrak_kerja_id' => request('kontrak_kerja_id')]) }}"
        method="post" enctype="multipart/form-data">
        @csrf
        @method('post')
        {{-- Surat pengajuan kontrak kerja --}}
        <div class="grid md:grid-cols-2 gap-4 rounded-box">
            {{-- Surat pengajuan kontrak kerja --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Surat pengajuan kontrak</legend>
                <input type="file" name="surat_pengajuan_kontrak" class="file-input w-full validator" required />
                <p class="validator-hint hidden">
                    Surat pengajuan kontrak wajib dilampirkan
                </p>
                @error('surat_pengajuan_kontrak')
                    <p class="text-error text-sm">{{ $message }}</p>
                @enderror
            </fieldset>
        </div>


        {{-- Action  --}}
        <div class="grid place-items-center mt-4">
            <div class="flex flex-row gap-2">
                <button type="submit" class="btn btn-primary">Kirim pengajuan</button>
                <a href="{{ route('client.kontrak-kerja.pengajuan-kontrak-kerja.index', [$datas->id]) }}"
                    class="btn btn-neutral">Kembali</a>
            </div>
        </div>
    </form>
</x-layouts.client-app>
