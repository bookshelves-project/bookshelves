<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1"
  >

  <x-stw-favicon />

  <!-- Scripts -->
  @routes
  @vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue"])
  @inertiaHead
</head>

<body class="{{ config('app.env') === 'local' ? 'debug-screens' : '' }} font-sans antialiased">
  @inertia
</body>

</html>
