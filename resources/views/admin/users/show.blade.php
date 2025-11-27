<x-layouts.admin-app title="Detail akun peserta">
    {{-- Data akun --}}
    <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
        <div class="grid md:col-span-2">
            <h6>Data akun</h6>
        </div>
        {{-- Nama --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nama</legend>
            <p>{{ $user->name }}</p>
        </fieldset>
        {{-- Email --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Email</legend>
            <p>{{ $user->email }}</p>
        </fieldset>
        {{-- Role --}}
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Role</legend>
            <p>{{ $user->role->label() }}</p>
        </fieldset>
    </div>
    @if ($user->profil_user)
        {{-- Divider --}}
        <div class="divider"></div>
        {{-- Data profil  --}}
        <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
            <div class="grid md:col-span-2">
                <h6>Data profil</h6>
            </div>
            {{-- Nama lengkap --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nama</legend>
                <p>{{ $user->profil_user->formatted_nama_lengkap }}</p>
            </fieldset>
            {{-- Jenis kelamin --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nama</legend>
                <p>{{ $user->profil_user->formatted_jenis_kelamin }}</p>
            </fieldset>
            {{-- Nomor telepon --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nomor Telepon</legend>
                <p>{{ $user->profil_user->nomor_telepon }}</p>
            </fieldset>
            {{-- Alamat  --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Alamat</legend>
                <p class="whitespace-pre-wrap">{{ $user->profil_user->alamat }}</p>
            </fieldset>
            {{-- Pendidikan terakhir  --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Pendidikan terakhir</legend>
                <p>{{ $user->profil_user->formatted_pendidikan_terakhir }}</p>
            </fieldset>
            {{-- Tanggal lahir --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Tanggal lahir</legend>
                <p>{{ $user->profil_user->formatted_tanggal_lahir }}</p>
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
                @if ($user->profil_user->foto_profil)
                    <x-ui.img src="{{ route('storage.private.show', ['file' => $user->profil_user->foto_profil]) }}"
                        class="object-cover aspect-square w-32 border border-primary/75 rounded-box" />
                @else
                    <p>Tidak ada</p>
                @endif
            </fieldset>
            {{-- Ktp --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Ktp</legend>
                @if ($user->profil_user->ktp)
                    <a href="{{ route('storage.private.show', ['file' => $user->profil_user->ktp]) }}" target="_blank"
                        class="link link-hover link-primary">Lihat selengkapnya</a>
                @else
                    <p>Tidak ada</p>
                @endif
            </fieldset>
            {{-- Ijazah --}}
            <fieldset class="fieldset w-fit">
                <legend class="fieldset-legend">Ijazah</legend>
                @if ($user->profil_user->ijazah)
                    <a href="{{ route('storage.private.show', ['file' => $user->profil_user->ijazah]) }}"
                        target="_blank" class="link link-hover link-primary">Lihat selengkapnya</a>
                @else
                    <p>Tidak ada</p>
                @endif
            </fieldset>
        </div>
    @endif
    {{-- Action  --}}
    <div class="grid place-items-center">
        <div class="flex flex-row gap-2">
            <a href="{{ route('admin.users.index') }}" class="btn btn-neutral">Kembali</a>
        </div>
    </div>
</x-layouts.admin-app>
