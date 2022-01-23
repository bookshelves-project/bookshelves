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
    <div id="navigation-options"
        class="fixed transform -translate-x-1/2 top-1 left-1/2 flex items-center bg-gray-200 bg-opacity-75 z-50 text-white rounded-md hidden">
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
    <div id="book-nav" class="hidden">
        <div class="fixed z-30 top-20 left-1/2 -translate-x-1/2 transform book-nav-tuto">
            <div class="text-3xl font-quicksand text-center">Welcome on Webreader.</div>
            <p class="mt-3">
                This is tutorial to use this tool, you can click on left to get previous page and right to next page, if
                you click on center, you can have option menu on top.
            </p>
            <div class="flex">
                <button id="disable-nav-tuto" class="button">
                    I understand how to read
                </button>
            </div>
        </div>
        <div class="fixed z-20 grid grid-cols-3 w-full h-full">
            <button id="leftBtn" class="nav-tuto nav-tuto-color">
                <div class="book-nav-tuto">
                    Click on me to get previous page
                </div>
            </button>
            <button id="centerBtn" class="nav-tuto nav-tuto-color">
                <div class="book-nav-tuto">
                    Click on me to get options
                </div>
            </button>
            <button id="rightBtn" class="nav-tuto nav-tuto-color">
                <div class="book-nav-tuto">
                    Click on me to get next page
                </div>
            </button>
        </div>
    </div>
    {{-- <button 
        class="fixed z-10 top-0 bottom-0 right-1/2 -translate-x-1/2 transform w-1/2 lg:w-1/3 hover:bg-gray-50 transition-colors duration-75 hover:bg-opacity-10">
    </button>
    <button  class="side-button left-0">
    </button>
    <button  class="side-button right-0">
    </button> --}}
    @yield('content')
    @yield('scripts')
    <script src="{{ mix('assets/js/blade/index.js') }}"></script>
</body>

</html>
