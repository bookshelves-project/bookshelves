<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
            @yield('title') · {{ config('app.name') }} @yield('title-template')
        @else
            {{ config('app.name') }} @yield('title-template')
        @endif
    </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Quicksand&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @yield('styles')
</head>

<body
    class="font-sans antialiased relative dark:bg-gray-900 {{ config('app.env') === 'local' ? 'debug-screens' : '' }}">
    <div id="top" class="mb-20 lg:mb-10"></div>
    @include('components.blocks.hero', [
    'route' => $route ?? null,
    ])
    @include('components.blocks.slide-over-links')
    <div class="container p-5 mx-auto dark:text-gray-100">
        @yield('content-base')
    </div>
    @include('components.blocks.to-top')
    <script src="{{ asset('css/app.js') }}"></script>
    <script src="{{ asset('css/slide-over.js') }}"></script>
    @yield('scripts')
</body>

</html>
