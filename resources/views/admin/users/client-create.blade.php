<x-layouts.admin-app title="Tambah akun pengguna - Akun client">
    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('post')
        {{-- Data akun --}}
        <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
            <div class="grid md:col-span-2">
                <h6>Data akun</h6>
            </div>
            {{-- Nama --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nama</legend>
                <input type="text" name="name" id="name" class="input validator w-full" required />
                <p class="validator-hint hidden">
                    Name wajib diisi
                </p>
                @error('name')
                    <p class="text-error text-sm">{{ $message }}</p>
                @enderror
            </fieldset>
            {{-- Email --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Email</legend>
                <input type="email" name="email" class="input validator w-full" required />
                <p class="validator-hint hidden">
                    Email wajib diisi
                </p>
                @error('email')
                    <p class="text-error text-sm">{{ $message }}</p>
                @enderror
            </fieldset>
            {{-- Password --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Password baru</legend>
                <input type="text" name="password" class="input validator w-full" minlength="6" required />
                <p class="validator-hint hidden">
                    Password baru wajib diisi
                    <br>Password baru minimal terdiri dari 6 karakter
                </p>
                @error('password')
                    <p class="text-error text-sm">{{ $message }}</p>
                @enderror
            </fieldset>
            {{-- Role --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Role</legend>
                <select name="role" id="role" class="select validator w-full" required>
                    <option value="" selected disabled>Pilih role</option>
                    @foreach (App\Enums\User\RoleEnum::client_user() as $role)
                        <option value="{{ $role->value }}">{{ $role->label() }}</option>
                    @endforeach
                </select>
                <p class="validator-hint hidden">
                    Role wajib diisi
                </p>
                @error('role')
                    <p class="text-error text-sm">{{ $message }}</p>
                @enderror
            </fieldset>
        </div>

        <div class="divider"></div>

        {{-- Data profil  --}}
        <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
            <div class="grid md:col-span-2">
                <h6>Data profil</h6>
            </div>
            {{-- Nama lengkap --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nama Lengkap</legend>
                <input type="text" name="nama_lengkap" class="input validator w-full" required />
                <p class="validator-hint hidden">
                    Nama lengkap wajib diisi
                </p>
                @error('nama_lengkap')
                    <p class="text-error text-sm">{{ $message }}</p>
                @enderror
            </fieldset>
            {{-- Jenis kelamin --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Jenis Kelamin</legend>
                <select name="jenis_kelamin" class="select select-bordered w-full validator" required>
                    @foreach (App\Enums\User\JenisKelaminEnum::cases() as $jenis_kelamin)
                        <option value="{{ $jenis_kelamin->value }}">
                            {{ $jenis_kelamin->label() }}</option>
                    @endforeach
                </select>
                <p class="validator-hint hidden">
                    Jenis kelamin wajib diisi
                </p>
                @error('jenis_kelamin')
                    <p class="text-error text-sm">{{ $message }}</p>
                @enderror
            </fieldset>
            {{-- Nomor telepon --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nomor Telepon</legend>
                <input type="text" name="nomor_telepon" class="input validator w-full" required />
                <p class="validator-hint hidden">
                    Nomor telepon wajib diisi
                </p>
                @error('nomor_telepon')
                    <p class="text-error text-sm">{{ $message }}</p>
                @enderror
            </fieldset>
            {{-- Alamat  --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Alamat</legend>
                <textarea name="alamat" class="textarea validator w-full" required></textarea>
                <p class="validator-hint hidden">
                    Alamat wajib diisi
                </p>
                @error('alamat')
                    <p class="text-error text-sm">{{ $message }}</p>
                @enderror
            </fieldset>
            {{-- Pendidikan terakhir  --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Pendidikan Terakhir</legend>
                <select name="pendidikan_terakhir" class="select validator w-full" required>
                    <option value="" selected disabled>Pilih pendidikan terakhir</option>
                    @foreach (App\Enums\User\PendidikanTerakhirEnum::cases() as $pendidikan_terakhir)
                        <option value="{{ $pendidikan_terakhir->value }}">
                            {{ $pendidikan_terakhir->label() }}</option>
                    @endforeach
                </select>
                <p class="validator-hint hidden">
                    Pendidikan terakhir wajib diisi
                </p>
                @error('pendidikan_terakhir')
                    <p class="text-error text-sm">{{ $message }}</p>
                @enderror
            </fieldset>
            {{-- Tanggal lahir --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Tanggal lahir</legend>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="input validator w-full" required />
                <p class="validator-hint hidden">
                    Tanggal lahir wajib diisi
                </p>
                @error('tanggal_lahir')
                    <p class="text-error text-sm">{{ $message }}</p>
                @enderror
            </fieldset>
        </div>

        <div class="divider"></div>

        {{-- Dokumen akun  --}}
        <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
            <div class="grid md:col-span-2">
                <h6>Dokumen akun</h6>
            </div>
            {{-- Foto profil --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Foto profil</legend>
                <input type="file" name="foto_profil" class="file-input file w-full" />
                @error('foto_profil')
                    <p class="text-error text-sm">{{ $message }}</p>
                @enderror
            </fieldset>
            {{-- Ktp --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">KTP</legend>
                <input type="file" name="ktp" class="file-input file w-full" />
                @error('ktp')
                    <p class="text-error text-sm">{{ $message }}</p>
                @enderror
            </fieldset>
            {{-- Ijazah --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Ijazah</legend>
                <input type="file" name="ijazah" class="file-input file w-full" />
                @error('ijazah')
                    <p class="text-error text-sm">{{ $message }}</p>
                @enderror
            </fieldset>
        </div>

        <div class="divider"></div>

        {{-- Action  --}}
        <div class="grid place-items-center mt-4">
            <div class="flex flex-row gap-2">
                <button type="submit" class="btn btn-primary">Tambah</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-neutral">Kembali</a>
            </div>
        </div>
    </form>
</x-layouts.admin-app>
