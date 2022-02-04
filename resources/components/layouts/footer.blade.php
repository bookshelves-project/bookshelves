<footer>
    <div class="max-w-7xl mx-auto pt-12 pb-6 px-4 overflow-hidden sm:px-6 lg:px-8">
        <nav class="-mx-5 -my-2 flex flex-wrap justify-center" aria-label="Footer">
            @foreach (config('bookshelves.navigation.footer') as $route)
                <div class="px-5 py-2">
                    {{-- <a href="{{ $link['route'] ? route($link['route'], array_key_exists('parameters', $link) ? $link['parameters'] : []) : $link['href'] }}"
                        class="text-base text-gray-400 hover:text-gray-300">
                        {{ $route['title'] }}
                    </a> --}}
                    <x-link :array="$route" class="text-base text-gray-400 hover:text-gray-300" title />
                </div>
            @endforeach
        </nav>
        <div class="mt-6 text-base text-gray-400 mx-auto w-max">
            <div class="flex items-center space-x-2">
                <a href="https://creativecommons.org/" target="_blank" rel="noopener noreferrer"
                    class="flex items-center">
                    @svg('cc', 'w-6 h-6')
                    @svg('cc-by', 'w-6 h-6')
                    @svg('cc-nc', 'w-6 h-6')
                    <span class="ml-2">
                        {{ $date }}
                    </span>
                </a>
                <div>
                    · <a href="{{ config('app.repository_url') }}" target="_blank"
                        rel="noopener noreferrer">{{ config('app.name') }} v{{ $composer->version }}</a>,
                    <a href="{{ route('front.license') }}">{{ $composer->license }}
                        license.</a>
                </div>
            </div>
        </div>
    </div>
</footer>
