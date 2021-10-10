<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title') · {{ config('app.name') }} Features
    </title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('assets/css/blade/index.css') }}">
    <link rel="stylesheet" href="{{ mix('assets/css/blade/webreader.css') }}">
    <script src="{{ mix('assets/js/blade/set-color-mode.js') }}"></script>
</head>

<body class="relative bg-yellow-200 dark:bg-gray-800 {{ config('app.env') === 'local' ? 'debug-screens' : '' }}">
    @php
        $links = [];
    @endphp
    <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
    <x-layout.sidebar-epub :title="$title" />
    <div
        class="fixed transform -translate-x-1/2 top-1 left-1/2 flex items-center bg-gray-200 bg-opacity-75 z-50 text-white rounded-md">
        <x-webreader.navigation-epub id="firstPage" icon="arrow-double-left" />
        <x-webreader.navigation-epub id="prevPage" icon="arrow-left" />
        <x-webreader.navigation-epub id="sidebar-header-button" icon="menu" />
        <x-webreader.navigation :route="route('features.webreader.index')" icon="home" />
        <a href="{{ $epub_download }}" download>
            <x-webreader.navigation-epub id="download" icon="download" />
        </a>
        <x-webreader.navigation-epub id="nextPage" icon="arrow-right" />
        <x-webreader.navigation-epub id="lastPage" icon="arrow-double-right" />
    </div>
    <div class="fixed z-20 top-0 right-0 bg-gray-300 text-gray-800 dark:bg-gray-700 dark:text-gray-300 bg-opacity-40">
        <x-switch-color-mode />
    </div>
    <button id="prevPageSide" class="side-button left-0">
    </button>
    <button id="nextPageSide" class="side-button right-0">
    </button>
    @yield('content')
    @yield('scripts')
    <script src="{{ mix('assets/js/blade/index.js') }}"></script>
</body>

</html>
