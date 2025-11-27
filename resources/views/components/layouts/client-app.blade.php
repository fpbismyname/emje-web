<x-layouts.app title="Selamat datang di {{ config('site.title') }}">
    <div class="flex flex-col min-h-screen">
        {{-- Navbar --}}
        <section id="navbar" class="sticky top-0 z-10">
            <div class="navbar bg-base-300 shadow-sm">
                <div class="flex-1">
                    <a href="/" class="py-4">
                        <x-ui.img class="w-full max-w-12 min-w-12"
                            src="{{ route('storage.public.show', ['file' => 'icon/company_icon.png']) }}" />
                    </a>
                </div>
                <div class="hidden md:flex md:flex-none">
                    <ul class="menu menu-horizontal gap-4 items-center">
                        <li>
                            <a href="#">Beranda</a>
                        </li>
                        <li>
                            <a href="#about">Tentang kami</a>
                        </li>
                        <li>
                            <a href="#services">Layanan kami</a>
                        </li>
                        <li>
                            <a href="#contact">Kontak kami</a>
                        </li>
                        @if (auth()->guest())
                            <li>
                                <a href="" class="btn btn-accent">Daftar sekarang</a>
                            </li>
                        @else
                            <li>
                                <a href="" class="btn btn-accent">Dashboard</a>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="flex-none md:hidden">
                    <div class="drawer">
                        <input id="homepage-sidebar" type="checkbox" class="drawer-toggle" />
                        <div class="drawer-content">
                            <label for="homepage-sidebar" class="btn drawer-button">
                                <x-lucide-menu class="w-4" />
                            </label>
                        </div>
                        <div class="drawer-side">
                            <label for="homepage-sidebar" aria-label="close sidebar" class="drawer-overlay"></label>
                            <ul class="menu bg-base-200 min-h-full w-64 p-4">
                                <li>
                                    <a href="#">Beranda</a>
                                </li>
                                <li>
                                    <a href="#about">Tentang kami</a>
                                </li>
                                <li>
                                    <a href="#services">Layanan kami</a>
                                </li>
                                <li>
                                    <a href="#contact">Kontak kami</a>
                                </li>
                                @if (auth()->guest())
                                    <li>
                                        <a href="" class="btn btn-accent">Daftar sekarang</a>
                                    </li>
                                @else
                                    <li>
                                        <a href="" class="btn btn-accent">Dashboard</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Content --}}
        {{ $slot }}


        {{-- Footer --}}
        <div class="flex flex-col mt-auto">
            <footer class="footer sm:footer-horizontal bg-base-300 text-base-content p-10">
                <aside>
                    <x-ui.img src="{{ route('storage.public.show', ['file' => 'icon/company_icon.png']) }}"
                        class="max-w-24 min-w-12" />
                    <p class="max-w-xs line-clamp-3">
                        {{ config('site.description') }}
                    </p>
                </aside>
                <nav>
                    <h6 class="footer-title">Layanan</h6>
                    <a class="link link-hover">Pelatihan Tenaga Kerja</a>
                    <a class="link link-hover">Kontrak Kerja</a>
                </nav>
                <nav>
                    <h6 class="footer-title">Perusahaan</h6>
                    <a class="link link-hover">Tentang kami</a>
                    <a class="link link-hover">Kontak kami</a>
                </nav>
                <nav>
                    <h6 class="footer-title">Media sosial</h6>
                    <a class="link link-hover" href="https://www.facebook.com/pt.emje.pandanjaya.indonesia/">
                        Facebook
                    </a>
                    <a class="link link-hover">
                        Instagram
                    </a>
                    <a class="link link-hover" href="https://share.google/6KwtELIqkOe9bF1iQ">
                        Maps
                    </a>
                </nav>
            </footer>
        </div>
    </div>
</x-layouts.app>
