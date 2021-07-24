<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Content</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body>
    <div class="text-center sm:text-left">
        Lorem ipsum dolor sit amet.
    </div>
    <div class="text-xl lg:text-4xl">
        Last update: {{ $lastModified }}
    </div>
    <main id="content">
        {!! $content !!}
    </main>
</body>

</html>
