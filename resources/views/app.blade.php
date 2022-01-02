<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    {{-- @routes
    @translations
    @vite('admin', 'app.ts', 3200) --}}
    @production
        @php
            $manifest = json_decode(file_get_contents(public_path('dist/manifest.json')), true);
        @endphp
        <script type="module" src="/dist/{{ $manifest['resources/js/app.ts']['file'] }}"></script>
        {{-- <link rel="stylesheet" href="/dist/{{ $manifest['resources/js/app.ts']['css'][0] }}"> --}}
    @else
        <script type="module" src="http://localhost:3001/@vite/client"></script>
        <script type="module" src="http://localhost:3001/resources/js/app.ts"></script>
    @endproduction
    @vite
</head>

<body class="antialiased">
    @inertia
</body>

</html>
