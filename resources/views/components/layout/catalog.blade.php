<x-app>
  @push('head')
    @vite(['resources/catalog/css/app.css', 'resources/catalog/ts/app.ts'])
  @endpush
  {{ $slot }}
</x-app>
