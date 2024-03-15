<x-stw-app>
  <x-slot name="head">
    <title inertia>{{ config('app.name', 'Bookshelves') }}</title>

    {{-- <x-stw-meta-tags
      description="For people with eReaders, download eBooks and reading in complete tranquility, your digital library that goes everywhere with you."
    /> --}}
    {{-- <meta
      name="author"
      content="{{ config('app.name') }}"
    />
    @if (isset($page['props']['event']))
      <meta
        name="twitter:card"
        content="{{ isset($page['props']['event']['card']) ? $page['props']['event']['card'] : 'summary_large_image' }}"
      />
      <meta
        property="og:title"
        content="{{ isset($page['props']['event']['title']) ? config('app.name') . ' · ' . $page['props']['event']['title'] : config('app.name') }}"
      />
      <meta
        property="og:description"
        content="{{ isset($page['props']['event']['description']) ? $page['props']['event']['description'] : '' }}"
      />
      <meta
        property="og:image"
        content="{{ isset($page['props']['event']['image']) ? $page['props']['event']['image'] : asset('/default.jpg') }}"
      />
    @endif
    <meta
      property="og:url"
      content="{{ url()->current() }}"
    /> --}}

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
