<x-layouts.app title="{{ $title ?? null }}">
    <div class="drawer md:drawer-open">
        <input id="admin-drawer" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content">
            <!-- Navbar -->
            <nav class="navbar w-full bg-base-300">
                <label for="admin-drawer" aria-label="open sidebar" class="btn btn-square btn-ghost">
                    <!-- Sidebar toggle icon -->
                    <x-lucide-menu class="w-4" />
                </label>
                <div class="px-4">{{ $title ?? config('site.title') }}</div>
            </nav>
            <!-- Page content here -->
            <div class="flex flex-col min-h-screen">
                {{ $slot }}
            </div>
        </div>

        <div class="drawer-side is-drawer-close:overflow-visible">
            <label for="admin-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
            <div class="flex min-h-full flex-col items-start bg-base-200 is-drawer-close:w-14 is-drawer-open:w-64">
                <!-- Sidebar content here -->
                <div class="flex flex-col w-full items-center p-2 py-4">
                    {{-- Logo --}}
                    <x-ui.img src="{{ asset('default/company_icon.png') }}" class="w-full max-w-12" />
                    <label class="is-drawer-close:hidden whitespace-nowrap">PT
                        Pandajaya
                        Indonesia
                    </label>
                </div>
                <ul class="menu w-full grow">
                    <!-- List item -->
                    @foreach (config('admin_sidebar') as $item)
                        @switch($item['type'])
                            @case('menu-title')
                                <li class="menu-title is-drawer-close:hidden whitespace-nowrap">{{ $item['label'] }}</li>
                            @break

                            @case('menu')
                                <li>
                                    <a role="button" href="{{ route($item['route_name']) }}"
                                        class="is-drawer-close:tooltip is-drawer-close:tooltip-right"
                                        data-tip="{{ $item['label'] }}">
                                        <!-- Home icon -->
                                        <x-dynamic-component :component="'lucide-' . $item['icon']" class="w-4" />
                                        <span class="is-drawer-close:hidden">{{ $item['label'] }}</span>
                                    </a>
                                </li>
                            @break

                            @default
                        @endswitch
                    @endforeach
                </ul>
                <div class="flex flex-col w-full">
                    <ul class="menu w-full mt-auto">
                        <li>
                            <div class="dropdown dropdown-top">
                                <div tabindex="0" role="button" class="w-full flex gap-2">
                                    <x-lucide-user class="w-4" />
                                    {{-- {{ auth()->user()->formatted_name }} --}}
                                    <span class="is-drawer-close:hidden">
                                        Gunawan
                                    </span>
                                </div>
                                <ul tabindex="1"
                                    class="dropdown-content z-10 menu menu-vertical bg-base-300 w-64 rounded-box">
                                    <li>
                                        <a href="">Pengaturan</a>
                                    </li>
                                    <li>
                                        <a href="">Logout</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
