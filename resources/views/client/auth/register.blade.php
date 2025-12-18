<x-layouts.app title="Register ke {{ config('site.title') }}">
    <div class="flex flex-col min-h-screen">
        <x-ui.card class="bg-base-200 m-auto w-full max-w-md">
            <div class="card-body">
                <div class="flex flex-col items-center gap-4 text-center">
                    <x-ui.img src="{{ route('storage.public.show', ['file' => 'icon/company_icon.png']) }}"
                        class="aspect-square w-24" />
                    <h1>Daftar</h1>
                    <p>Ajukan pembuatan akun <br> ke admin {{ config('site.title') }}</p>
                </div>
                <a target="_blank" href="{{ config('site.contact.whatsapp') }}" class="btn btn-primary">Daftar
                    pelatihan
                    disini</a>
                <a href="{{ route('client.homepage.index') }}" class="btn btn-neutral">Kembali</a>
                <div class="grid gap-2 text-center">
                    <h6>Sudah punya akun ? <a href="{{ route('client.login') }}"
                            class="link link-hover link-primary">Login disini</a></h6>
                </div>
            </div>
        </x-ui.card>
    </div>
</x-layouts.app>
