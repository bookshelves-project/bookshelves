<x-app>
    @push('head')
        @vite(['resources/front/css/app.css', 'resources/front/ts/app.ts'])
    @endpush
    @yield('default')
</x-app>
