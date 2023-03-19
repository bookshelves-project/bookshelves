<x-app>
  @push('head')
    {{-- <meta
      name="twitter:widgets:theme"
      content="dark"
    > --}}
    @vite(['resources/front/css/app.css', 'resources/front/ts/app.ts'])
    {{-- <script
      async
      src="//cdn.iframe.ly/embed.js?api_key={API_KEY}"
    ></script> --}}
    <meta
      name="twitter:widgets:theme"
      content="dark"
    >
    <meta
      name="twitter:dnt"
      content="on"
    >
    <script
      async
      src="https://platform.twitter.com/widgets.js"
      charset="utf-8"
    ></script>
    <script
      async
      src="https://www.tiktok.com/embed.js"
    ></script>
  @endpush
  {{-- <div class="flex min-h-screen flex-col">
    <div @class(['mx-auto mt-6', $prose_class => $prose])>
      <a
        href="/"
        class="no-underline"
      >
        <h1 class="mt-6 text-center">
          {{ $title }}
        </h1>
      </a>
      @if ($features)
        <div class="not-prose">
          @include('front::components.nav.features')
        </div>
      @endif
      <main>
        {{ $slot }}
        @if ($developer)
          <div class="pt-8">
            @include('front::components.nav.developer')
          </div>
        @endif
      </main>
    </div>
    <x-footer class="mt-auto" />
  </div> --}}
  {{ $slot }}
</x-app>
