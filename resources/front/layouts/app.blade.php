@php
$prose_class = 'prose prose-lg dark:prose-invert prose-headings:font-handlee prose-headings:font-medium';
if (!isset($prose)) {
    $prose = true;
}
if (!isset($nav_features)) {
    $nav_features = true;
}
if (!isset($nav_developer)) {
    $nav_developer = true;
}
@endphp

<x-app>
    @push('head')
        @vite(['resources/front/css/app.css', 'resources/front/ts/app.ts'])
    @endpush
    <div class="flex min-h-screen flex-col">
        <div @class(['mx-auto mt-6', $prose_class => $prose])>
            <a href="/"
                class="no-underline">
                <h1 class="mt-6 text-center">
                    @yield('title')
                </h1>
            </a>
            @if ($nav_features)
                <div class="not-prose">
                    @include('front::components.nav-features')
                </div>
            @endif
            <main>
                @yield('default')
                @if ($nav_developer)
                    <div class="pt-8">
                        @include('front::components.nav-developer')
                    </div>
                @endif
            </main>
        </div>
        <x-footer class="mt-auto" />
    </div>
</x-app>
