<x-layouts.admin-app title="Periksa pendaftaran pelatihan">
    {{-- Data pendaftaran --}}
    <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
        <div class="grid md:col-span-2">
            Data pendaftaran
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
            <p class="py-2">{{ $pendaftaran_pelatihan?->pelatihan_durasi_bulan }} bulan</p>
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

        {{-- Metode pembayaran --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Metode pembayaran</legend>
            <p class="py-2">{{ $pendaftaran_pelatihan->metode_pembayaran->label() }}</p>
        </fieldset>

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
            Data pelatihan
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
            <p class="py-2">{{ $pendaftaran_pelatihan?->pelatihan_durasi_bulan }} bulan</p>
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

    {{-- Data User  --}}
    <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
        <div class="grid md:col-span-2">
            <h6>Data {{ $pendaftaran_pelatihan->users_profil_user_nama_lengkap }}</h6>
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
    {{-- Divider --}}
    <div class="divider"></div>
    {{-- Data dokumen  --}}
    <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
        <div class="grid md:col-span-2">
            <h6>Data dokumen</h6>
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
    <div class="grid place-items-center">
        <div class="flex flex-row gap-2">
            <button onclick="window.open_modal('periksa-pendaftaran')" class="btn btn-primary">Keputusan</button>
            <a href="{{ route('admin.pendaftaran-pelatihan.index') }}" class="btn btn-neutral">Kembali</a>
        </div>
    </div>

    <x-ui.modal id="periksa-pendaftaran">
        <x-slot:modal_box>
            <form action="{{ route('admin.pendaftaran-pelatihan.update', $pendaftaran_pelatihan->id) }}" method="POST"
                class="space-y-4">
                @csrf
                @method('put')
            </form>
        </x-slot:modal_box>
    </x-ui.modal>
</x-layouts.admin-app>
