<x-app>
    @push('head')
        @vite(['resources/webreader/css/app.css', 'resources/webreader/ts/app.ts'])
    @endpush
    @yield('default')
</x-app>
