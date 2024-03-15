<x-stw-app>
  <x-slot name="head">
    <title inertia>{{ config('app.name', 'Bookshelves') }}</title>

    <x-stw-meta-tags />

    <meta
      inertia
      property="og:title"
      content="{{ config('app.name', 'Bookshelves') }}"
    >
    <meta
      inertia
      property="og:description"
      content="For people with eReaders, download eBooks and reading in complete tranquility, your digital library that goes everywhere with you."
    >
    <meta
      inertia
      property="og:image"
      content="{{ config('app.url') . '/default.jpg' }}"
    >
    {{-- <meta
      name="description"
      content="{{ session('meta_description', 'Default Description') }}"
    >
    <meta
      property="og:title"
      content="{{ session('meta_title', 'Default Title') }}"
    >
    <meta
      property="og:description"
      content="{{ session('meta_description', 'Default Description') }}"
    >
    <meta
      property="og:image"
      content="{{ session('meta_image', 'Default Image URL') }}"
    >
    <meta
      property="og:url"
      content="{{ session('meta_url', 'Default URL') }}"
    > --}}

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
