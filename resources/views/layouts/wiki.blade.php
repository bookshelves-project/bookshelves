<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
            @yield('title') · Wiki · {{ config('app.name') }}
        @else
            {{ config('app.name') }}
        @endif
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Handlee&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('css/markdown.css') }}">
    <link rel="stylesheet" href="{{ mix('css/code.css') }}">
    @yield('style')
</head>

<body class="font-sans antialiased markdown-body relative {{ config('app.env') === 'local' ? 'debug-screens' : '' }}">
    {{-- @include('components.layout.navbar') --}}
    <div class="container max-w-5xl p-5 mx-auto prose prose-lg">
        @yield('content')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>

</html>
