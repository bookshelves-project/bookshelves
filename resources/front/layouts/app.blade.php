<x-app>
    @push('head')
        @vite(['resources/front/css/app.css', 'resources/front/ts/app.ts'])
    @endpush
    <div class="flex min-h-screen flex-col">
        @yield('default')
        <x-footer class="mt-auto" />
    </div>
</x-app>
