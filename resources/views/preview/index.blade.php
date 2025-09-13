<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
  >
  <title>{{ $title_page ?? config('app.name') }}</title>

  <link
    href="/apple-touch-icon.png"
    rel="apple-touch-icon"
    sizes="180x180"
  >
  <link
    type="image/png"
    href="/favicon-32x32.png"
    rel="icon"
    sizes="32x32"
  >
  <link
    type="image/png"
    href="/favicon-16x16.png"
    rel="icon"
    sizes="16x16"
  >

  <meta
    property="og:title"
    content="{{ $title ?? '' }}"
  >
  <meta
    property="og:description"
    content="{{ $description ?? '' }}"
  >
  <meta
    property="og:image"
    content="{{ $og_image ?? asset('images/poster-default.jpg') }}"
  >
  <meta
    property="og:url"
    content="{{ $media_url }}"
  >
  <meta
    property="og:type"
    content="website"
  >

  <meta
    name="twitter:card"
    content="summary_large_image"
  >
  <meta
    name="twitter:title"
    content="{{ $title ?? '' }}"
  >
  <meta
    name="twitter:description"
    content="{{ $description ?? '' }}"
  >
  <meta
    name="twitter:image"
    content="{{ $og_image ?? asset('images/opengraph/default.jpg') }}"
  >
  <link
    href="/assets/preview.css"
    rel="stylesheet"
  >
</head>

<body class="bg-gray-900 text-gray-400">
  <header class="absolute inset-x-0 top-0 z-50">
    <div class="mx-auto max-w-7xl">
      <div class="px-6 pt-6 xl:max-w-2xl xl:pl-8 xl:pr-0">
        <nav
          class="flex items-center justify-between xl:justify-start"
          aria-label="Global"
        >
          <a
            class="-m-1.5 p-1.5"
            href="/"
          >
            <span class="sr-only">Bookshelves</span>
            <img
              class="h-8 w-auto"
              src="/images/bookshelves-text-logo-color-dark.svg"
              alt="Bookshelves"
            />
          </a>
        </nav>
      </div>
    </div>
  </header>

  <div class="relative">
    <div class="mx-auto max-w-7xl xl:min-h-screen">
      <div class="relative z-10 pt-14 xl:w-full xl:max-w-2xl">
        <svg
          class="absolute inset-y-0 right-8 hidden h-full w-80 translate-x-1/2 transform fill-gray-900 xl:block"
          aria-hidden="true"
          viewBox="0 0 100 100"
          preserveAspectRatio="none"
        >
          <polygon points="0,0 90,0 50,100 0,100" />
        </svg>

        <div class="relative px-6 py-32 sm:py-40 xl:px-8 xl:py-56 xl:pr-0">
          <div class="mx-auto max-w-2xl xl:mx-0 xl:max-w-xl">
            <div class="hidden sm:mb-6 sm:flex">
              <div
                class="relative rounded-full px-3 py-1 text-sm/6 text-gray-400 ring-1 ring-white/10 hover:ring-white/20"
              >
                {{ $extra }}
              </div>
            </div>
            <h1 class="text-pretty text-5xl font-semibold tracking-tight text-white sm:text-5xl">
              {{ $title }}
            </h1>
            <div class="mt-3 text-lg italic text-gray-400">
              {{ $tagline }}
            </div>
            <p class="mt-8 text-pretty font-sans text-lg font-medium sm:text-xl/8">
              {!! $description !!}
            </p>
            @if ($language)
              <div class="mt-5 text-sm italic text-gray-400">
                Available in {{ $language }}
              </div>
            @endif
            <div class="mt-8 flex items-center gap-x-6">
              <a
                class="shadow-xs hover-zoom block w-40 rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500"
                href="{{ $media_url }}"
              >
                {{ $type }} page
              </a>
              <button
                class="hover-zoom text-sm/6 font-semibold text-white hover:underline"
                id="copyBtn"
                data-copy="{{ $preview_url }}"
              >
                Copy link <span aria-hidden="true">→</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="bg-gray-800 xl:absolute xl:inset-y-0 xl:right-0 xl:w-1/2">
      <img
        class="aspect-3/2 object-cover xl:aspect-auto xl:size-full"
        src="{{ $image }}"
        alt="{{ $title }}"
      />
    </div>
  </div>
  <script src="/assets/preview.js"></script>
</body>

</html>
