<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
            @yield('title') · {{ config('app.name') }} Webreader
        @else
            {{ config('app.name') }} Webreader
        @endif
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Handlee&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('css/markdown.css') }}">
    @yield('style')
</head>

<body
    class="font-sans antialiased bg-yellow-100 relative overflow-y-scroll {{ config('app.env') === 'local' ? 'debug-screens' : '' }}">
    @include('components.blocks.slide-over-links')
    <div class="mx-auto">
        @yield('content')
    </div>
    <script src="{{ asset('css/app.js') }}"></script>
    <script src="{{ asset('css/slide-over.js') }}"></script>
    @yield('scripts')
</body>

</html>
