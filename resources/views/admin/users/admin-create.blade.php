<x-layouts.admin-app title="Tambah akun pengguna - Akun admin">
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
                <input type="text" name="name" id="name" class="input validator w-full"
                    value="{{ old('name') }}" required />
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
                <input type="email" name="email" class="input validator w-full" value="{{ old('email') }}"
                    required />
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
                <input type="text" name="password" class="input validator w-full" value="{{ old('password') }}"
                    minlength="6" required />
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
                    <option value="" disabled selected>Pilih role</option>
                    @foreach (App\Enums\User\RoleEnum::admin_user() as $role)
                        <option value="{{ $role->value }}" {{ old('role') == $role->value ? 'selected' : '' }}>
                            {{ $role->label() }}</option>
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


        {{-- Action  --}}
        <div class="grid place-items-center mt-4">
            <div class="flex flex-row gap-2">
                <button type="submit" class="btn btn-primary">Tambah</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-neutral">Kembali</a>
            </div>
        </div>
    </form>
</x-layouts.admin-app>
