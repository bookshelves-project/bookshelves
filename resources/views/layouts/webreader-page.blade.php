<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
            @yield('title') · {{ config('app.name') }}
        @else
            {{ config('app.name') }}
        @endif
    </title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('css/markdown.css') }}">
</head>

<body class="relative">
    <a href="{{ route('webreader.index') }}"
        class="fixed top-2 left-2 text-center text-lg font-semibold flex items-center hover:bg-gray-200 rounded-md p-2">
        <x-icon-arrow-sm-right class="w-4 h-4 transform rotate-180" />
        <span class="ml-2">
            Back
        </span>
    </a>
    @yield('content')
</body>

</html>
