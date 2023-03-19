<x-app>
  @push('head')
    @vite(['resources/admin/css/app.css', 'resources/admin/ts/app.ts'])
  @endpush
  {{ $slot }}
</x-app>
