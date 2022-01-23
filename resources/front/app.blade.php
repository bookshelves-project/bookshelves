<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    @livewireStyles

    @vite('front', 'app.ts', 3100)
</head>

<body class="antialiased">
    <div class="min-h-screen flex flex-col justify-center items-center bg-primary-400 text-white px-6">
        <div class="mb-12 bg-white rounded-full p-8">
            <img src="{{ asset('logo.svg') }}" alt="Laravel RAD Stack" width="128" height="128" />
        </div>

        <a href="{{ route('admin.login') }}"
            class="text-center uppercase text-primary font-bold sm:max-w-md px-12 py-8 bg-white shadow-md overflow-hidden rounded-sm">
            Go to admin !
        </a>

        <p class="mt-12 text-center max-w-196 font-600">
            This frontend part is initialized for Windi CSS + Livewire + AlpineJS v3 + Typescript.<br>
            No front-end pages are provided in this demo.<br>
            The admin panel which is build on Inertia + Vue 3 with composition API + Typescript.<br>
            Give a 🌟 to <a href="https://github.com/adr1enbe4udou1n/laravel-rad-stack" target="_blank"
                class="underline">my repo</a> !
        </p>
    </div>

    @livewireScripts
</body>

</html>
