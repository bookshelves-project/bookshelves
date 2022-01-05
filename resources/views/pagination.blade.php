@if ($paginator->hasPages())
    <nav class="flex items-center justify-end mt-8">
        @if ($paginator->onFirstPage())
            <span
                class="mr-3 text-sm opacity-25 cursor-not-allowed flex items-center">
                <x-icon-prev class="w-3 h-3 mr-2" />
                Précédent
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
                class="mr-3 text-sm flex items-center hover:text-yellow-900">
                <x-icon-prev class="w-3 h-3 mr-2" />
                Précédent
            </a>
        @endif
        <div class="hidden md:-mt-px md:flex md:items-center">
            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span aria-disabled="true">
                        <span
                            class="inline-flex items-center mx-3 text-sm text-gray-500">{{ $element }}</span>
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page">
                                <span
                                    class="inline-flex items-center justify-center text-sm text-white bg-yellow-900 rounded-full w-7 h-7 mx-3">{{ $page }}</span>
                            </span>
                        @else
                            <a href="{{ $url }}"
                                class="inline-flex items-center mx-3 text-sm text-gray-500 hover:text-yellow-900"
                                aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

        </div>
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                class="ml-3 text-sm flex items-center hover:text-yellow-900"
                aria-label="Suivant">
                Suivant
                <x-icon-next class="w-3 h-3 ml-2" />
            </a>
        @else
            <span aria-disabled="true" aria-label="Suivant">
                <span
                    class="ml-3 text-sm opacity-25 cursor-not-allowed flex items-center"
                    aria-hidden="true">
                    Suivant
                    <x-icon-next class="w-3 h-3 ml-2" />
                </span>
            </span>
        @endif
    </nav>
@endif
