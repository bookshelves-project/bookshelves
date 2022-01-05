<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {!! SEO::generate() !!}

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    @livewireStyles

    {{-- {!! JsonSettings::generate() !!} --}}
    @vite('features', 'app.ts', 3100)
</head>

<body @class([
    'antialiased bg-gray-900 min-h-screen',
    config('app.env') === 'local' ? 'debug-screens' : '',
])>
    <div class="flex flex-col min-h-screen m-0">
        <div class="mx-auto py-12 px-4 max-w-7xl sm:px-6 lg:px-8 lg:py-12">
            <h1 class="text-3xl font-handlee font-semibold text-white tracking-tight sm:text-4xl mb-5">
                {{ config('app.name') }}
                Features{{ SEO::getTitle(true) !== 'Features' ? ': ' . SEO::getTitle(true) : '' }}
            </h1>
            <div class="divide-y divide-gray-400 space-y-4">
                @isset($route)
                    <div class="flex justify-between items-center">
                        <a href="{{ $route }}" class="flex items-center space-x-1">
                            @svg('icon-arrow-sm-right', 'w-6 h-6 rotate-180')
                            <span class="mb-1">{{ config('app.name') }} Features</span>
                        </a>
                        <a href="{{ config('app.front_url') }}" class="flex items-center space-x-1">
                            <span class="mb-1">Main application</span>
                            @svg('icon-arrow-sm-right', 'w-6 h-6')
                        </a>
                    </div>
                @endisset
                <div>{{ $slot }}</div>
            </div>
        </div>

        <div class="mt-auto">
            <x-layouts.footer class="mt-auto" />
        </div>
    </div>

    @livewireScripts
</body>

</html>
