<x-layouts.app>
    <div class="mx-auto py-12 px-4 max-w-7xl sm:px-6 lg:px-8 lg:py-12">
        <x-title>
            {{ config('app.name') }}
            Features{{ request()->route()->getName() !== 'front.home'? ': ' . SEO::getTitle(true): '' }}
        </x-title>
        <div class="divide-y divide-gray-400 space-y-4">
            @isset($route)
                <div class="flex justify-between items-center">
                    <a href="{{ $route }}"
                        class="flex items-center space-x-1 text-gray-100 hover:border-gray-100 border-b-2 border-transparent transition-colors duration-75">
                        @svg('icon-arrow-sm-right', 'w-6 h-6 transform rotate-180')
                        <span>{{ config('app.name') }} Features</span>
                    </a>
                    <a href="{{ config('app.front_url') }}"
                        class="flex items-center space-x-1 text-gray-100 hover:border-gray-100 border-b-2 border-transparent transition-colors duration-75">
                        <span>Main application</span>
                        @svg('icon-arrow-sm-right', 'w-6 h-6')
                    </a>
                </div>
            @endisset
            <div>{{ $slot }}</div>
        </div>
    </div>
</x-layouts.app>
