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
    <script src="{{ mix('css/blade.js') }}"></script>
    <script src="{{ mix('css/slide-over.js') }}"></script>
</head>

<body
    class="font-sans antialiased relative dark:bg-gray-900 {{ config('app.env') === 'local' ? 'debug-screens' : '' }}">
    @php
        $agent = new Jenssegers\Agent\Agent();
        // $platform = $agent->platform();
        // $isEreader = $platform === 'AndroidOS' ?? false;
        $device = $agent->device();
        $isReader = str_contains(strtolower($device), 'kobo') ?? false;
    @endphp
    <div id="top" class="{{ !$isReader ? 'mb-20' : '' }} lg:mb-10"></div>
    @include('components.blocks.hero', [
    'route' => $route ?? null,
    ])
    @if (!$isReader)
        @if ($sidebar ?? false)
            @include('components.blocks.sidebar')
        @endif
        @if ($slideover ?? false)
            @include('components.blocks.slide-over-links', ['links' => $links ?? null])
        @endif
    @endif
    <div class="p-5 mx-auto dark:text-gray-100">
        @yield('content-base')
        <div class="prose lg:prose-lg dark:prose-light markdown-body mx-auto hyphenate">
            @yield('content-markdown')
        </div>
    </div>
    @include('components.blocks.to-top')
    @yield('scripts')
</body>

</html>
