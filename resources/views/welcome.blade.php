<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Handlee&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body class="font-sans antialiased">
    <div
        class="relative flex justify-center min-h-screen bg-gray-100 items-top dark:bg-gray-900 sm:items-center sm:pt-0">
        <a href="{{ route('api.index') }}"
            class="block max-w-6xl p-5 mx-auto transition-colors duration-100 rounded-md sm:px-6 lg:px-8 hover:bg-gray-200">
            <div class="flex justify-center mt-4 font-handlee sm:items-center sm:justify-between">
                <div>
                    <div class="text-6xl">
                        Bookshelves
                    </div>
                    <div class="mt-1 ml-4 text-sm text-center text-gray-500 sm:text-right sm:ml-0">
                        Laravel v{{ $laravelVersion }} (PHP v{{ $phpVersion }})
                    </div>
                </div>
            </div>
        </a>
    </div>
</body>

</html>
