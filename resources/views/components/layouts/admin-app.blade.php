<x-layouts.app title="{{ $title ?? null }}">
    <div class="drawer md:drawer-open">

        <input id="admin-drawer" type="checkbox" class="drawer-toggle" />

        <div class="drawer-content">
            <!-- Navbar -->
            <nav class="navbar w-full bg-base-300 sticky top-0 z-10">
                <div class="flex flex-1">
                    <label for="admin-drawer" class="btn btn-ghost">
                        <!-- Sidebar toggle icon -->
                        <x-lucide-menu class="w-4" />
                    </label>
                </div>
                <div class="flex flex-none">
                    <div class="dropdown dropdown-bottom dropdown-end">
                        <div role="button" tabindex="0" class="btn btn-primary btn-circle">
                            <x-lucide-user class="w-4" />
                        </div>
                        <ul tabindex="-1" class="dropdown-content menu bg-base-100 rounded-box z-1 w-64 shadow-sm">
                            <li class="menu-title">
                                {{ auth()->user()->formatted_name }}
                            </li>
                            <li>
                                <a href="{{ route('admin.pengaturan.edit') }}">Pengaturan</a>
                            </li>
                            <form action="{{ route('admin.logout.submit') }}" method="post">
                                @csrf
                                @method('post')
                                <li>
                                    <button type="submit" class="text-error w-full">Logout</button>
                                </li>
                            </form>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Page content here -->
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

        <div class="drawer-side is-drawer-close:overflow-visible">
            <label for="admin-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
            <div class="flex min-h-full flex-col items-start bg-base-200 is-drawer-close:w-14 is-drawer-open:w-64">
                <!-- Sidebar content here -->
                <div class="flex flex-col w-full items-center p-2 py-4">
                    {{-- Logo --}}
                    <x-ui.img src="{{ route('storage.public.show', ['file' => 'icon/company_icon.png']) }}"
                        class="w-full max-w-12" />
                    <div class="flex flex-col gap-2 is-drawer-close:hidden items-center">
                        <label class="whitespace-nowrap">PT
                            Pandajaya
                            Indonesia
                        </label>
                        <div class="badge badge-primary">{{ auth()->user()->role->label() }}</div>
                    </div>
                </div>
                <ul class="menu w-full grow">
                    <!-- List item -->
                    @foreach (config('admin_sidebar') as $item)
                        @if (in_array(auth()->user()->role->value, $item['roles']))
                            @switch($item['type'])
                                @case('menu-title')
                                    <li class="menu-title is-drawer-close:hidden whitespace-nowrap">{{ $item['label'] }}</li>
                                    <span class="is-drawer-close:py-4 is-drawer-open:hidden"></span>
                                @break

                                @case('menu')
                                    @php
                                        $base_route =
                                            implode('.', array_slice(explode('.', $item['route_name']), 0, 2)) . '.';
                                        $is_active = request()->routeIs($base_route . '*');
                                    @endphp
                                    <li class="rounded-field {{ $is_active ? 'bg-base-300' : '' }}">
                                        <a role="button" href="{{ route($item['route_name']) }}"
                                            class="is-drawer-close:tooltip is-drawer-close:tooltip-right tooltip-primary whitespace-nowrap"
                                            data-tip="{{ $item['label'] }}">
                                            <x-dynamic-component :component="'lucide-' . $item['icon']" class="w-4" />
                                            <span class="is-drawer-close:hidden">{{ $item['label'] }}</span>
                                        </a>
                                    </li>
                                @break

                                @default
                            @endswitch
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-layouts.app>
