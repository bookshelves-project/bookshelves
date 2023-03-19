<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta
    http-equiv="X-UA-Compatible"
    content="IE=edge"
  >
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
  >
  <meta
    name="csrf-token"
    content="{{ csrf_token() }}"
  >

  {!! SEO::generate() !!}

  <link
    rel="icon"
    type="image/x+ico"
    href="/favicon.ico"
  >
  <link
    rel="apple-touch-icon"
    sizes="180x180"
    href="/apple-touch-icon.png"
  >
  <link
    rel="icon"
    type="image/png"
    sizes="32x32"
    href="/favicon-32x32.png"
  >
  <link
    rel="icon"
    type="image/png"
    sizes="16x16"
    href="/favicon-16x16.png"
  >
  <link
    rel="manifest"
    href="/site.webmanifest"
  >

  <script src="{{ asset('/vendor/js/color-mode.js') }}"></script>

  @stack('head')
  @stack('styles')
  @stack('scripts-head')
  @livewireStyles
  @livewireScripts
</head>

<body class="{{ config('app.env') === 'local' ? 'debug-screens' : '' }} color-mode antialiased">
  {{ $slot }}

  @stack('modals')
  @stack('scripts')
  @livewire('notifications')
</body>

</html>
