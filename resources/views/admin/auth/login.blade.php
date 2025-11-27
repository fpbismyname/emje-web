<x-layouts.app title="Login ke halaman admin">
    @if ($errors->any())
        @dump($errors->all())
    @endif
    <div class="flex flex-col min-h-screen">
        <x-ui.card class="bg-base-200 m-auto w-full max-w-md">
            <div class="card-body">
                <div class="flex flex-col items-center gap-4">
                    <x-ui.img src="{{ route('storage.public.show', ['file' => 'icon/company_icon.png']) }}"
                        class="aspect-square w-24" />
                    <h1>Login</h1>
                    <p>Login ke halaman admin</p>
                </div>
                <form method="post" action="{{ route('admin.login.submit') }}" class="grid grid-cols-1 gap-4 my-6">
                    @csrf
                    @method('post')
                    {{-- Email --}}
                    <fieldset class="fieldset">
                        <legend class="fieldset-label">Email</legend>
                        <input type="email" name="email" class="input validator w-full" placeholder="Masukan email"
                            value="{{ old('email') }}" required />
                        <p class="validator-hint hidden">
                            Email wajib diisi
                            <br> Pastikan format email benar
                        </p>
                        @error('email')
                            <p class="label text-error">{{ $message }}</p>
                        @enderror
                    </fieldset>
                    {{-- Password --}}
                    <fieldset class="fieldset">
                        <legend class="fieldset-label">Password</legend>
                        <input type="password" name="password" class="input validator w-full" min="4"
                            placeholder="Masukan password" required />
                        <p class="validator-hint hidden">
                            Password wajib diisi
                            <br> Password minimal terdiri dari 4 karakter
                        </p>
                        @error('password')
                            <p class="label text-error">{{ $message }}</p>
                        @enderror
                    </fieldset>

                    {{-- Action form --}}
                    <div class="grid gap-2">
                        <button type="submit" class="btn btn-primary">Login</button>
                        <a href="{{ route('homepage.index') }}" class="btn btn-neutral">Kembali</a>
                    </div>
                </form>
            </div>
        </x-ui.card>
    </div>
</x-layouts.app>
