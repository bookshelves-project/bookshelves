{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1"
  >

  <title inertia>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link
    href="https://fonts.bunny.net"
    rel="preconnect"
  >
  <link
    href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
    rel="stylesheet"
  />

  <!-- Scripts -->
  @routes
  @vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue"])
  @inertiaHead
</head>

<body class="font-sans antialiased">
  @inertia
</body>

</html> --}}

<x-stw-app>
  <x-slot name="head">
    <title inertia>{{ config('app.name', 'Bookshelves') }}</title>
    @routes
    @vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
    @if (config('app.umami.url'))
      <script
        async
        src="{{ config('app.umami.url') }}"
        data-website-id="{{ config('app.umami.id') }}"
      ></script>
    @endif
  </x-slot>
  @inertia
  @yield('default')
</x-stw-app>
