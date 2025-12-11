<x-layouts.admin-app title="Periksa pendaftaran pelatihan">
    {{-- Data pendaftaran --}}

    <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
        <div class="grid md:col-span-2">
            <h6>Data pendaftaran</h6>
        </div>

        {{-- Nama Pelatihan --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nama Pelatihan</legend>
            <p class="py-2">{{ $pendaftaran_pelatihan->pelatihan_nama_pelatihan }}</p>
        </fieldset>

        {{-- Gelombang Pelatihan --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Gelombang pelatihan</legend>
            <p class="py-2">{{ $pendaftaran_pelatihan->gelombang_pelatihan?->nama_gelombang }}</p>
        </fieldset>

        {{-- Durasi (Bulan) --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Durasi (Bulan)</legend>
            <p class="py-2">{{ $pendaftaran_pelatihan?->pelatihan_durasi_pelatihan }}</p>
        </fieldset>

        {{-- Kategori Pelatihan --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Kategori Pelatihan</legend>
            <p class="py-2">{{ $pendaftaran_pelatihan->pelatihan_kategori_pelatihan }}</p>
        </fieldset>

        {{-- Status pendaftaran --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Status pendaftaran</legend>
            <p class="py-2">{{ $pendaftaran_pelatihan->status->label() }}</p>
        </fieldset>

        {{-- Skema pembayaran --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Skema pembayaran</legend>
            <p class="py-2">{{ $pendaftaran_pelatihan->skema_pembayaran->label() }}</p>
        </fieldset>

        {{-- Dp dibayar --}}
        @if ($pendaftaran_pelatihan->skema_pembayaran->value === 'cicila')
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Dp dibayar</legend>
                <p class="py-2">
                    {{ $pendaftaran_pelatihan->pembayaran_pelatihan_dp?->formatted_nominal ?? 'Rp 0' }}</p>
            </fieldset>
        @endif

        {{-- Bukti pembayaran --}}
        <fieldset class="fieldset w-fit">
            <legend class="fieldset-legend">Bukti pembayaran</legend>
            @if ($pendaftaran_pelatihan->pembayaran_pelatihan_dp?->bukti_pembayaran)
                <a target="_blank"
                    href="{{ route('storage.private.show', ['file' => $pendaftaran_pelatihan->pembayaran_pelatihan_dp?->bukti_pembayaran]) }}"
                    class="link link-primary link-hover">Lihat selengkapnya</a>
            @elseif($pendaftaran_pelatihan->pembayaran_pelatihan_cash?->bukti_pembayaran)
                <a target="_blank"
                    href="{{ route('storage.private.show', ['file' => $pendaftaran_pelatihan->pembayaran_pelatihan_cash?->bukti_pembayaran]) }}"
                    class="link link-primary link-hover">Lihat selengkapnya</a>
            @else
                <p>Tidak ada</p>
            @endif
        </fieldset>

        {{-- Tenor cicilan --}}
        @if ($pendaftaran_pelatihan->tenor_cicilan)
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Tenor cicilan</legend>
                <p class="py-2">{{ $pendaftaran_pelatihan->formatted_tenor_cicilan }}</p>
            </fieldset>
        @endif

        {{-- Tanggal dibayar --}}
        @if ($pendaftaran_pelatihan->tanggal_dibayar)
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Tanggal dibayar</legend>
                <p class="py-2">{{ $pendaftaran_pelatihan->formatted_tanggal_dibayar }}</p>
            </fieldset>
        @endif

        {{-- Bukti pembayaran --}}
        @if ($pendaftaran_pelatihan->bukti_pembayaran)
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Bukti pembayaran</legend>
                <a target="_blank"
                    href="{{ route('storage.public.show', ['file' => $pendaftaran_pelatihan->bukti_pembayaran]) }}">
                    Lihat selengkapnya
                </a>
            </fieldset>
        @endif

    </div>

    <div class="divider"></div>

    {{-- Data pelatihan --}}
    <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
        <div class="grid md:col-span-2">
            <h6>Data pelatihan</h6>
        </div>
        {{-- Nama Pelatihan --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nama Pelatihan</legend>
            <p class="py-2">{{ $pendaftaran_pelatihan->pelatihan_nama_pelatihan }}</p>
        </fieldset>

        {{-- Nominal Biaya --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nominal Biaya</legend>
            <p class="py-2">{{ $pendaftaran_pelatihan?->pelatihan_nominal_biaya }}</p>
        </fieldset>

        {{-- Durasi (Bulan) --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Durasi (Bulan)</legend>
            <p class="py-2">{{ $pendaftaran_pelatihan?->pelatihan_durasi_pelatihan }}</p>
        </fieldset>

        {{-- Kategori Pelatihan --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Kategori Pelatihan</legend>
            <p class="py-2">{{ $pendaftaran_pelatihan->pelatihan_kategori_pelatihan }}</p>
        </fieldset>

        {{-- Deskripsi --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Deskripsi</legend>
            <p class="py-2 whitespace-pre-wrap">{{ $pendaftaran_pelatihan->pelatihan_deskripsi_pelatihan }}</p>
        </fieldset>
    </div>

    <div class="divider"></div>

    {{-- Data peserta  --}}
    <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
        <div class="grid md:col-span-2">
            <h6>Data peserta</h6>
        </div>
        {{-- Nama lengkap --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nama</legend>
            <p>{{ $pendaftaran_pelatihan?->users?->profil_user->formatted_nama_lengkap }}</p>
        </fieldset>
        {{-- Jenis kelamin --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nama</legend>
            <p>{{ $pendaftaran_pelatihan?->users?->profil_user->formatted_jenis_kelamin }}</p>
        </fieldset>
        {{-- Nomor telepon --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nomor Telepon</legend>
            <p>{{ $pendaftaran_pelatihan?->users?->profil_user->nomor_telepon }}</p>
        </fieldset>
        {{-- Alamat  --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Alamat</legend>
            <p class="whitespace-pre-wrap">{{ $pendaftaran_pelatihan?->users?->profil_user->alamat }}</p>
        </fieldset>
        {{-- Pendidikan terakhir  --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Pendidikan terakhir</legend>
            <p>{{ $pendaftaran_pelatihan?->users?->profil_user->formatted_pendidikan_terakhir }}</p>
        </fieldset>
        {{-- Tanggal lahir --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Tanggal lahir</legend>
            <p>{{ $pendaftaran_pelatihan?->users?->profil_user->formatted_tanggal_lahir }}</p>
        </fieldset>

    </div>

    <div class="divider"></div>

    {{-- Dokumen peserta  --}}
    <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
        <div class="grid md:col-span-2">
            <h6>Dokumen peserta</h6>
        </div>
        {{-- Foto profil --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Foto profil</legend>
            @if ($pendaftaran_pelatihan?->users?->profil_user->foto_profil)
                <x-ui.img
                    src="{{ route('storage.private.show', ['file' => $pendaftaran_pelatihan?->users?->profil_user->foto_profil]) }}"
                    class="object-cover aspect-square w-32 border border-primary/75 rounded-box" />
            @else
                <p>Tidak ada</p>
            @endif
        </fieldset>
        {{-- Ktp --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Ktp</legend>
            @if ($pendaftaran_pelatihan?->users?->profil_user->ktp)
                <a href="{{ route('storage.private.show', ['file' => $pendaftaran_pelatihan?->users?->profil_user->ktp]) }}"
                    target="_blank" class="link link-hover link-primary">Lihat selengkapnya</a>
            @else
                <p>Tidak ada</p>
            @endif
        </fieldset>
        {{-- Ijazah --}}
        <fieldset class="fieldset w-fit">
            <legend class="fieldset-legend">Ijazah</legend>
            @if ($pendaftaran_pelatihan?->users?->profil_user->ijazah)
                <a href="{{ route('storage.private.show', ['file' => $pendaftaran_pelatihan?->users?->profil_user->ijazah]) }}"
                    target="_blank" class="link link-hover link-primary">Lihat selengkapnya</a>
            @else
                <p>Tidak ada</p>
            @endif
        </fieldset>
    </div>


    {{-- Action  --}}
    <div class="grid place-items-center gap-4">
        @if (!$pendaftaran_pelatihan->layak_diterima)
            <p>Kuota pendaftaran sudah mencapai maksimal.</p>
        @endif
        <div class="flex flex-row gap-2">
            @if (!$pendaftaran_pelatihan->has_reviewed && $pendaftaran_pelatihan->layak_diterima)
                <button onclick="window.open_modal('review-pendaftaran')" class="btn btn-primary">Review</button>
            @endif
            <a href="{{ route('admin.pendaftaran-pelatihan.index') }}" class="btn btn-neutral">Kembali</a>
        </div>
    </div>

    {{-- Modal review --}}
    @if (!$pendaftaran_pelatihan->has_reviewed)
        <x-ui.modal id="review-pendaftaran">
            <x-slot:card_title>
                Review pendaftaran
            </x-slot:card_title>
            <x-slot:modal_box>
                <form action="{{ route('admin.pendaftaran-pelatihan.update', $pendaftaran_pelatihan->id) }}"
                    method="POST" class="grid gap-4 py-4">
                    @csrf
                    @method('put')
                    {{-- Status pendaftaran --}}
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Status</legend>
                        <select name="status" class="select validator w-full">
                            <option value="" selected disabled>Pilih status</option>
                            @foreach (App\Enums\Pelatihan\StatusPendaftaranPelatihanEnum::cases_review() as $status)
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
                            <button type="reset" onclick="window.close_modal('review-pendaftaran')"
                                class="btn btn-neutral">Batal</button>
                        </div>
                    </div>
                </form>
            </x-slot:modal_box>
        </x-ui.modal>
    @endif
</x-layouts.admin-app>
