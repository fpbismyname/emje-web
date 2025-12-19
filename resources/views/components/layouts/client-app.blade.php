<x-layouts.app title="{{ $title ?? null }}">
    {{-- Navbar --}}
    <div class="sticky top-0 w-full z-10">
        <div class="navbar bg-base-100 shadow">
            <div class="flex-1">
                <a href="{{ route('client.dashboard.index') }}">
                    <x-ui.img :src="route('storage.public.show', ['file' => config('site.icon')])" class="max-w-12" />
                </a>
            </div>
            <div class="md:flex md:flex-none hidden">
                <ul class="menu menu-horizontal gap-4 items-center">
                    @foreach (config('client_navbar') as $menu)
                        @switch($menu['type'])
                            @case('dropdown')
                                @php
                                    $parent_route = $menu['route_name'];
                                    $is_parent_active = request()->routeIs($parent_route . '*');
                                @endphp
                                <li>
                                    <div class="dropdown dropdown-center">
                                        <div tabindex="0" role="button"
                                            class="{{ $is_parent_active ? 'font-bold' : null }} flex gap-2">
                                            <x-dynamic-component :component="'lucide-' . $menu['icon']" class="w-4" />
                                            {{ $menu['label'] }}
                                        </div>
                                        <ul tabindex="-1" class="dropdown-content menu bg-base-100 rounded-box w-54 shadow">
                                            @foreach ($menu['children'] as $child)
                                                @php
                                                    $child_route = $parent_route . $child['route_name'];
                                                    $is_child_active = request()->routeIs($child_route . '*');
                                                @endphp
                                                <li>
                                                    <a href="{{ route($child_route) }}"
                                                        class="{{ $is_child_active ? 'menu-active' : null }}">
                                                        <x-dynamic-component :component="'lucide-' . $child['icon']" class="w-4" />
                                                        {{ $child['label'] }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                            @break

                            @case('menu')
                                @php
                                    $base_route =
                                        implode('.', array_slice(explode('.', $menu['route_name']), 0, 2)) . '.';
                                    $is_active = request()->routeIs($base_route . '*');
                                @endphp
                                <li>
                                    <a href="{{ route($menu['route_name']) }}" class="{{ $is_active ? 'font-bold' : null }}">
                                        <x-dynamic-component :component="'lucide-' . $menu['icon']" class="w-4" />
                                        {{ $menu['label'] }}
                                    </a>
                                </li>
                            @break

                            @default
                        @endswitch
                    @endforeach
                </ul>
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn  btn-primary m-1">
                        <x-lucide-user class="w-4" />
                        {{ auth()->user()->name }}
                    </div>
                    <ul tabindex="-1" class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm">
                        <li class="menu-title">Menu</li>
                        <li><a href="{{ route('client.pengaturan.edit') }}">Pengaturan</a></li>
                        <form action="{{ route('client.logout') }}" method="post">
                            @csrf
                            @method('post')
                            <li>
                                <button type="submit" class="text-error w-full">Logout</button>
                            </li>
                        </form>
                    </ul>
                </div>
            </div>
            <div class="flex flex-none md:hidden">
                <div class="drawer drawer-end">
                    <input id="client-drawer" type="checkbox" class="drawer-toggle" />
                    <div class="drawer-content">
                        <!-- Page content here -->
                        <label for="client-drawer" class="drawer-button btn btn-ghost">
                            <x-lucide-menu class="w-4" />
                        </label>
                    </div>
                    <div class="drawer-side">
                        <label for="client-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
                        <ul class="menu bg-base-200 min-h-full w-80 p-4">
                            <div class="flex flex-row justify-between items-center p-4">
                                <h6>Menu</h6>
                                <label for="client-drawer" class="drawer-button cursor-pointer">
                                    <x-lucide-x class="w-4" />
                                </label>
                            </div>
                            <li>
                                <details>
                                    <summary>Pelatihan</summary>
                                    <ul>
                                        <li><a href="">Daftar pelatihan</a></li>
                                        <li><a href="">Pendaftaran pelatihan</a></li>
                                        <li><a href="">Pelatihan diikuti</a></li>
                                    </ul>
                                </details>
                            </li>
                            <li>
                                <details>
                                    <summary>Kontrak kerja</summary>
                                    <ul>
                                        <li><a href="">Daftar kontrak kerja</a></li>
                                        <li><a href="">Pengajuan kontrak kerja</a></li>
                                        <li><a href="">Kontrak kerja diikuti</a></li>
                                    </ul>
                                </details>
                            </li>
                            <li>
                                <details>
                                    <summary>
                                        <x-lucide-user class="w-4" />
                                        {{ auth()->user()->profil_user->nama_lengkap ?? auth()->user()->name }}
                                    </summary>
                                    <ul>
                                        <li><a href="{{ route('client.pengaturan.edit') }}">Pengaturan</a></li>
                                        <form action="{{ route('client.logout') }}" method="post">
                                            @csrf
                                            @method('post')
                                            <li><button type="submit" class="text-error w-full">Logout</button></li>
                                        </form>
                                    </ul>
                                </details>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Content --}}
    <div class="container mx-auto">
        <div class="flex flex-col gap-4 p-4">
            <div class="flex flex-row justify-between">
                @if (!empty($title))
                    <div class="flex flex-col">
                        <h3>{{ $title ?? null }}</h3>
                    </div>
                @endif
            </div>
            {{ $slot }}
        </div>
    </div>
</x-layouts.app>
