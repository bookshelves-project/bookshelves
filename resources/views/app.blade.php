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

    <meta
      name="description"
      content="For people with eReaders, download eBooks and reading in complete tranquility, your digital library that goes everywhere with you."
    >

    <!-- Facebook Meta Tags -->
    <meta
      property="og:url"
      content="https://vivacia.bookshelves.ink/images/default.jpg"
    >
    <meta
      property="og:type"
      content="website"
    >
    <meta
      property="og:title"
      content="Bookshelves"
    >
    <meta
      property="og:description"
      content="For people with eReaders, download eBooks and reading in complete tranquility, your digital library that goes everywhere with you."
    >
    <meta
      property="og:image"
      content="https://vivacia.bookshelves.ink/images/default.jpg"
    >

    <!-- Twitter Meta Tags -->
    <meta
      name="twitter:card"
      content="summary_large_image"
    >
    <meta
      property="twitter:domain"
      content="vivacia.bookshelves.ink"
    >
    <meta
      property="twitter:url"
      content="https://vivacia.bookshelves.ink"
    >
    <meta
      name="twitter:title"
      content="Bookshelves"
    >
    <meta
      name="twitter:description"
      content="For people with eReaders, download eBooks and reading in complete tranquility, your digital library that goes everywhere with you."
    >
    <meta
      name="twitter:image"
      content="https://vivacia.bookshelves.ink/images/default.jpg"
    >
  </x-slot>
  @inertia
  @yield('default')
</x-stw-app>
