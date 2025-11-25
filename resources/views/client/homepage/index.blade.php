<x-layouts.client-app>

    {{-- Hero --}}
    <section id="hero" class="relative bg-base-200">
        <div class="container mx-auto px-4 py-24 md:py-32">
            <div class="w-auto mx-auto text-start">
                <h1 class="text-4xl md:text-6xl font-bold leading-tight text-base-content mb-6">
                    {{ config('site.tagline') }}
                </h1>
                <p class="text-lg md:text-xl text-base-content/80 mb-10">
                    {{ config('site.description') }}
                </p>
                <div class="flex flex-row w-full gap-4">
                    <a href="" class="btn btn-accent     btn-lg px-10">
                        Daftar sekarang
                    </a>
                    <a href="#contact" class="btn btn-primary btn-lg px-10">
                        Konsultasi gratis
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- About --}}
    <section id="about" class="py-20 md:py-28 bg-base-100">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-base-content mb-12">
                Tentang Kami
            </h2>

            <div class="max-w-4xl mx-auto text-center md:text-left space-y-6">
                <p class="text-lg text-base-content/80">
                    {{ config('site.about.paragraph_1') }}
                </p>
                <p class="text-lg text-base-content/80">
                    {{ config('site.about.paragraph_2') }}
                </p>
            </div>
        </div>
    </section>

    {{-- Services --}}
    <section id="services" class="py-20 md:py-28 bg-base-200">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-base-content mb-14">
                Layanan Kami
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach (config('site.services') as $service)
                    <div class="card bg-base-100 shadow-lg hover:shadow-xl transition-all duration-200">
                        <div class="card-body items-center text-center">
                            @if (isset($service['icon']))
                                <x-dynamic-component :component="'lucide-' . $service['icon']" class="w-12 h-12 text-primary mb-6" />
                            @endif

                            <h3 class="card-title text-lg font-bold text-base-content mb-2">
                                {{ $service['title'] }}
                            </h3>

                            <p class="text-base-content/80 text-sm">
                                {{ $service['description'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Contact --}}
    <section id="contact" class="py-20 md:py-28 bg-base-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-14">
                <h2 class="text-3xl md:text-4xl font-bold text-base-content mb-4">
                    Hubungi Kami
                </h2>
                <p class="text-lg text-base-content/80 max-w-2xl mx-auto">
                    Tertarik dengan layanan kami? Hubungi kami melalui informasi berikut:
                </p>
            </div>

            <div class="flex flex-col md:flex-row justify-center items-center gap-10 mb-16">
                <div class="flex items-center gap-4">
                    <x-lucide-mail class="w-6 h-6 text-primary" />
                    <p class="text-lg text-base-content/80">{{ config('site.contact.email') }}</p>
                </div>

                <div class="flex items-center gap-4">
                    <x-lucide-phone class="w-6 h-6 text-primary" />
                    <p class="text-lg text-base-content/80">{{ config('site.contact.phone') }}</p>
                </div>

                <div class="flex items-center gap-4">
                    <x-lucide-map-pin class="w-6 h-6 text-primary" />
                    <p class="text-lg text-base-content/80">{{ config('site.contact.address') }}</p>
                </div>
                <a class="flex items-center link link-hover gap-4" href="{{ config('site.contact.whatsapp') }}">
                    <x-lucide-send class="w-6 h-6 text-primary" />
                    Chat ke whatsapp
                </a>
            </div>
        </div>
    </section>

</x-layouts.client-app>
