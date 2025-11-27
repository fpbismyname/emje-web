@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}">
        {{-- Mobile --}}
        <div class="flex justify-between items-center sm:hidden">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="btn btn-sm btn-disabled text-base-content">
                    <x-lucide-chevron-left class="w-4 h-4" /> {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-sm text-base-content">
                    <x-lucide-chevron-left class="w-4 h-4" /> {!! __('pagination.previous') !!}
                </a>
            @endif

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-sm text-base-content">
                    {!! __('pagination.next') !!} <x-lucide-chevron-right class="w-4 h-4" />
                </a>
            @else
                <span class="btn btn-sm btn-disabled text-base-content">
                    {!! __('pagination.next') !!} <x-lucide-chevron-right class="w-4 h-4" />
                </span>
            @endif
        </div>

        {{-- Desktop --}}
        <div class="hidden sm:flex sm:items-center sm:justify-between">
            {{-- Info --}}
            <div class="text-sm text-base-content">
                {!! __('Showing') !!}
                @if ($paginator->firstItem())
                    <span class="font-medium">{{ $paginator->firstItem() }}</span>
                    {!! __('to') !!}
                    <span class="font-medium">{{ $paginator->lastItem() }}</span>
                @else
                    {{ $paginator->count() }}
                @endif
                {!! __('of') !!}
                <span class="font-medium">{{ $paginator->total() }}</span>
                {!! __('results') !!}
            </div>

            {{-- Pagination Buttons --}}
            <div class="inline-flex rounded-md">
                {{-- Previous --}}
                @if ($paginator->onFirstPage())
                    <span class="btn btn-sm btn-disabled mr-1 text-base-content">
                        <x-lucide-chevron-left class="w-4 h-4" />
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-sm mr-1 text-base-content">
                        <x-lucide-chevron-left class="w-4 h-4" />
                    </a>
                @endif

                {{-- Page Numbers --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="btn btn-sm btn-disabled mr-1 text-base-content">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="btn btn-sm mr-1 bg-base-300 text-base-content">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="btn btn-sm mr-1 text-base-content"
                                    aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-sm text-base-content">
                        <x-lucide-chevron-right class="w-4 h-4" />
                    </a>
                @else
                    <span class="btn btn-sm btn-disabled text-base-content">
                        <x-lucide-chevron-right class="w-4 h-4" />
                    </span>
                @endif
            </div>
        </div>
    </nav>
@endif
