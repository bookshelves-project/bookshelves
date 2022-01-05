<x-layouts.app>
    <div class="mx-auto py-12 px-4 max-w-7xl sm:px-6 lg:px-8 lg:py-12">
        <x-title>
            {{ config('app.name') }}
            Features{{ SEO::getTitle(true) !== 'Features' ? ': ' . SEO::getTitle(true) : '' }}
        </x-title>
        <div class="divide-y divide-gray-400 space-y-4">
            @isset($route)
                <div class="flex justify-between items-center">
                    <a href="{{ $route }}" class="flex items-center space-x-1">
                        @svg('icon-arrow-sm-right', 'w-6 h-6 rotate-180')
                        <span class="mb-1">{{ config('app.name') }} Features</span>
                    </a>
                    <a href="{{ config('app.front_url') }}" class="flex items-center space-x-1">
                        <span class="mb-1">Main application</span>
                        @svg('icon-arrow-sm-right', 'w-6 h-6')
                    </a>
                </div>
            @endisset
            <div>{{ $slot }}</div>
        </div>
    </div>
</x-layouts.app>
