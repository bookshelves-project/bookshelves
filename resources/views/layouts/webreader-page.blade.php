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
    <link rel="stylesheet" href="{{ mix('css/blade/index.css') }}">
    <link rel="stylesheet" href="{{ mix('css/blade/markdown.css') }}">
</head>

<body class="relative bg-yellow-200 dark:bg-gray-800">
    @yield('content')
    <script src="{{ mix('css/js/blade/index.js') }}"></script>
</body>

</html>
