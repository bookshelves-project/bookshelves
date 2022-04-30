<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {!! SEO::generate() !!}

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <script src="{{ asset('assets/js/color-mode.js') }}"></script>

    @vite('webreader', 'app.ts', 3300)
</head>

<body x-data class="dark:bg-gray-900 dark:text-white"
    class="antialiased min-h-screen {{ config('app.env') === 'local' ? 'debug-screens' : '' }}">
    <div x-data="events()" class="flex flex-col min-h-screen m-0">
        {{ $slot }}
    </div>
</body>

</html>
