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
    <script src="{{ mix('assets/js/blade/set-color-mode.js') }}"></script>
</head>

<body class="relative bg-yellow-200 dark:bg-gray-800">
    @yield('content')
    <script src="{{ mix('assets/js/blade/index.js') }}"></script>
</body>

</html>
