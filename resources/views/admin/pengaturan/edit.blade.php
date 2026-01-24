<x-layouts.admin-app title="Detail akun pengguna">
    <form action="{{ route('admin.pengaturan.update-pengguna') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        {{-- Data akun --}}
        <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
            <div class="grid md:col-span-2">
                <h6>Data akun</h6>
            </div>
            {{-- Nama --}}
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nama</legend>
                <input type="text" name="name" id="name" class="input validator w-full"
                    value="{{ $user->name }}" required />
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
                <input type="email" name="email" id="email" class="input validator w-full"
                    value="{{ $user->email }}" required />
                <p class="validator-hint hidden">
                    Email wajib diisi
                </p>
                @error('email')
                    <p class="text-error text-sm">{{ $message }}</p>
                @enderror
            </fieldset>
        </div>


        @if ($user->profil_user)
            <div class="divider"></div>

            {{-- Data profil  --}}
            <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
                <div class="grid md:col-span-2">
                    <h6>Data profil</h6>
                </div>
                {{-- Nama lengkap --}}
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Nama Lengkap</legend>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="input validator w-full"
                        value="{{ $user->profil_user->formatted_nama_lengkap }}" required />
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
                            <option value="{{ $jenis_kelamin->value }}" @selected($user->profil_user->jenis_kelamin == $jenis_kelamin)>
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
                    <input type="text" name="nomor_telepon" id="nomor_telepon" class="input validator w-full"
                        value="{{ $user->profil_user->nomor_telepon }}" required />
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
                    <textarea name="alamat" id="alamat" class="textarea validator w-full" required>{{ $user->profil_user->alamat }}</textarea>
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
                        @foreach (App\Enums\User\PendidikanTerakhirEnum::cases() as $pendidikan_terakhir)
                            <option value="{{ $pendidikan_terakhir->value }}" @selected($user->profil_user->pendidikan_terakhir == $pendidikan_terakhir)>
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
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="input validator w-full"
                        value="{{ $user->profil_user->formatted_date_tanggal_lahir }}" required />
                    <p class="validator-hint hidden">
                        Tanggal lahir wajib diisi
                    </p>
                    @error('tanggal_lahir')
                        <p class="text-error text-sm">{{ $message }}</p>
                    @enderror
                </fieldset>
            </div>

            <div class="divider"></div>

            {{-- Dokumen profil --}}
            <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
                <div class="grid md:col-span-2">
                    <h6>Dokumen profil</h6>
                </div>
                {{-- Foto profil --}}
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Foto profil (Unggah foto profil jika ingin diganti)</legend>
                    <input type="file" name="foto_profil" id="foto_profil" class="file-input file w-full" />
                    @error('foto_profil')
                        <p class="text-error text-sm">{{ $message }}</p>
                    @enderror
                </fieldset>
                {{-- Ktp --}}
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">KTP (Unggah KTP jika ingin diganti)</legend>
                    <input type="file" name="ktp" id="ktp" class="file-input file w-full" />
                    @error('ktp')
                        <p class="text-error text-sm">{{ $message }}</p>
                    @enderror
                </fieldset>
                {{-- Ijazah --}}
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Ijazah (Unggah ijazah jika ingin diganti)</legend>
                    <input type="file" name="ijazah" class="file-input file w-full" />
                    @error('ijazah')
                        <p class="text-error text-sm">{{ $message }}</p>
                    @enderror
                </fieldset>
            </div>
        @endif

        <div class="divider"></div>

        {{-- Reset password --}}
        <div class="grid md:grid-cols-2 gap-4 rounded-box p-4">
            <div class="grid md:col-span-2">
                <h6>Reset password</h6>
            </div>
            <div class="flex flex-col gap-4">
                {{-- Checbox reset password --}}
                <label class="label w-fit">
                    <input type="checkbox" class="checkbox" name="reset_password"
                        onchange="window.toggle_hidden_input_element(this, ['new-password','old-password'])" />
                    Ingin melakukan reset password
                </label>
                {{-- Password lama --}}
                <fieldset id="fieldset-old-password" class="fieldset" hidden>
                    <legend class="fieldset-legend">Password lama</legend>
                    <input id="input-old-password" type="text" name="old_password" class="input validator w-full"
                        minlength="6" />
                    <p class="validator-hint hidden">
                        Password lama wajib diisi
                        <br> Password baru minimal terdiri dari 6 karakter
                    </p>
                </fieldset>
                {{-- Password baru --}}
                <fieldset id="fieldset-new-password" class="fieldset" hidden>
                    <legend class="fieldset-legend">Password baru</legend>
                    <input id="input-new-password" type="text" name="new_password" class="input validator w-full"
                        minlength="6" />
                    <p class="validator-hint hidden">
                        Password baru wajib diis
                        <br> Password baru minimal terdiri dari 6 karakter
                    </p>
                </fieldset>
            </div>
        </div>
        {{-- Action  --}}
        <div class="grid place-items-center mt-4">
            <div class="flex flex-row gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-neutral">Kembali</a>
            </div>
        </div>
    </form>
</x-layouts.admin-app>
