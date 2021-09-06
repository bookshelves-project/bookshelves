<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@php
if (!isset($slideOver)) {
    $slideOver = false;
}
if (!isset($links)) {
    $links = null;
}
if (!isset($title)) {
    $title = config('app.name');
}
@endphp

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ $title }} · {{ config('app.name') }} @yield('title-template')
    </title>
    <link rel="stylesheet" href="{{ mix('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('assets/css/blade/index.css') }}">
    @yield('styles')
    <x-layout.social :title="$title" :author="config('app.name').' Team'" />
</head>

<body class="{{ config('app.env') === 'local' ? 'debug-screens' : '' }}">
    <div class="h-screen flex overflow-hidden bg-gray-100 dark:bg-gray-900">
        <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
        <x-layout.sidebar :links="$links" />
        <!-- Static sidebar for desktop -->
        <x-layout.sidebar-static :links="$links" />

        <div class="flex flex-col w-0 flex-1 overflow-hidden">
            <x-layout.header :title="$title" />

            <main class="flex-1 relative overflow-y-auto scrollbar-thin focus:outline-none dark:text-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 xl:px-8 pt-4 sm:pt-6 xl:pt-8 content-wrapper">
                    <main class="content-content mx-auto">
                        @yield('content')
                    </main>
                    <x-layout.footer class="content-footer" />
                </div>
            </main>
        </div>

        @if ($slideOver)
            <x-layout.slide-over-static />

            <x-layout.slide-over />
        @endif
    </div>

    {{-- <x-blocks.to-top /> --}}
    @yield('scripts')
    <script type="module" src="{{ mix('assets/js/blade/switch-color.js') }}"></script>
    <script src="{{ mix('assets/js/blade/index.js') }}"></script>
</body>

</html>
