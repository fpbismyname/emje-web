<x-layouts.admin-app title="Periksa pengajuan kontrak kerja">

    {{-- Data pengajuan --}}
    <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
        <div class="grid md:col-span-2">
            <h6>Data pengajuan</h6>
        </div>
        {{-- Nama Pelatihan --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nama perusahaan</legend>
            <p class="py-2">{{ $pengajuan_kontrak_kerja->kontrak_kerja->nama_perusahaan }}</p>
        </fieldset>

        {{-- Nama peserta --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nama peserta</legend>
            <p class="py-2">{{ $pengajuan_kontrak_kerja->users->profil_user->nama_lengkap }}</p>
        </fieldset>

        {{-- Status --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Status pengajuan</legend>
            <p class="py-2">{{ $pengajuan_kontrak_kerja->status->label() }}</p>
        </fieldset>

        {{-- Durasi kontak --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Durasi kontrak kerja</legend>
            <p class="py-2">{{ $pengajuan_kontrak_kerja->kontrak_kerja->formatted_durasi_kontrak_kerja }}</p>
        </fieldset>

        {{-- Durasi kontak --}}
        @if ($pengajuan_kontrak_kerja->catatan)
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Durasi kontrak kerja</legend>
                <p class="py-2 whitespace-pre-wrap">{{ $pengajuan_kontrak_kerja->catatan }}</p>
            </fieldset>
        @endif

        {{-- Sumber dana --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Sumber dana pemberangkatan</legend>
            <p class="py-2">{{ $pengajuan_kontrak_kerja->sumber_dana->label() }}</p>
        </fieldset>

        {{-- Surat lamaran --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Surat pengajuan kontrak</legend>
            <a target="_blank" class="link link-hover link-primary"
                href="{{ route('storage.private.show', ['file' => $pengajuan_kontrak_kerja->surat_pengajuan_kontrak]) }}">Lihat
                selengkapnya</a>
        </fieldset>
    </div>


    {{-- Action  --}}
    <div class="grid place-items-center gap-4">
        @if (!$pengajuan_kontrak_kerja->layak_diterima)
            <p>Kuota pendaftaran sudah mencapai maksimal.</p>
        @endif
        <div class="flex flex-row gap-2">
            @if (!$pengajuan_kontrak_kerja->has_reviewed && $pengajuan_kontrak_kerja->layak_diterima)
                <button onclick="window.open_modal('review-pengajuan')" class="btn btn-primary">Review</button>
            @endif
            <a href="{{ route('admin.pengajuan-kontrak-kerja.index') }}" class="btn btn-neutral">Kembali</a>
        </div>
    </div>

    {{-- Modal review --}}
    @if (!$pengajuan_kontrak_kerja->has_reviewed)
        <x-ui.modal id="review-pengajuan">
            <x-slot:card_title>
                Review pendaftaran
            </x-slot:card_title>
            <x-slot:modal_box>
                <form action="{{ route('admin.pengajuan-kontrak-kerja.update', $pengajuan_kontrak_kerja->id) }}"
                    method="POST" class="grid gap-4 py-4">
                    @csrf
                    @method('put')
                    {{-- Status pendaftaran --}}
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Status</legend>
                        <select name="status" class="select validator w-full">
                            <option value="" selected disabled>Pilih status</option>
                            @foreach (App\Enums\KontrakKerja\StatusPengajuanKontrakKerja::case_review() as $status)
                                <option value="{{ $status->value }}" @selected($status === old('status'))>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="text-error">{{ $message }}</p>
                        @enderror
                        <p class="validator-hint hidden">
                            Status pendaftaran wajib dipilih.
                        </p>
                    </fieldset>
                    {{-- Catatan review --}}
                    <fieldset class="fieldset">
                        <legend class="fieldset-label">Catatan (Opsional)</legend>
                        <textarea name="catatan" class="textarea w-full"></textarea>
                    </fieldset>
                    <div class="grid place-items-center">
                        <div class="flex flex-row gap-2">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="reset" onclick="window.close_modal('review-pengajuan')"
                                class="btn btn-neutral">Batal</button>
                        </div>
                    </div>
                </form>
            </x-slot:modal_box>
        </x-ui.modal>
    @endif
</x-layouts.admin-app>
