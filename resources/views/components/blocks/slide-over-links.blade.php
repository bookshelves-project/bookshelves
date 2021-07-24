@php
$composer = file_get_contents(base_path('composer.json'));
$composer = json_decode($composer);

$laravelVersion = Illuminate\Foundation\Application::VERSION;
$phpVersion = PHP_VERSION;
$appVersion = $composer->version;
@endphp

<div id="slideOverLinks">
    <button id="slideBtn" type="button"
        class="inline-flex 2xl:hidden items-center px-4 py-2 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 z-50 fixed top-5 right-5 ">
        <span class="my-auto">
            {!! svg('external-link', 30) !!}
        </span>
    </button>
    <div id="panelLinks"
        class="translate-x-full 2xl:translate-x-0 max-w-xs w-full pt-5 pb-4 transform transition duration-300 fixed right-0 top-0 bg-gray-100 z-40 overflow-y-auto pl-4 h-screen">
        <ul>
            <li>
                <a href="docs" class="mx-4 hover:bg-gray-200 transition-colors duration-100 block rounded-md p-2">
                    {{ config('app.name') }} Documentation
                </a>
            </li>
            <li>
                <a href="{{ route('wiki.index') }}"
                    class="mx-4 hover:bg-gray-200 transition-colors duration-100 block rounded-md p-2">
                    {{ config('app.name') }} Wiki
                </a>
            </li>
            <li>
                <a href="{{ route('opds.index') }}"
                    class="mx-4 hover:bg-gray-200 transition-colors duration-100 block rounded-md p-2">
                    {{ config('app.name') }} OPDS
                </a>
            </li>
            <li>
                <a href="{{ route('catalog.index') }}"
                    class="mx-4 hover:bg-gray-200 transition-colors duration-100 block rounded-md p-2">
                    {{ config('app.name') }} Catalog
                </a>
            </li>
            <li>
                <a href="{{ route('webreader.index') }}"
                    class="mx-4 hover:bg-gray-200 transition-colors duration-100 block rounded-md p-2">
                    {{ config('app.name') }} Webreader
                </a>
            </li>
        </ul>
        <div class="pl-6 mt-3">
            <div class="text-lg font-semibold">
                Current versions
            </div>
            <ul class="pl-5">
                <li>{{ config('app.name') }}: {{ $appVersion }}</li>
                <li>Laravel: {{ $laravelVersion }}</li>
                <li>PHP: {{ $phpVersion }}</li>
            </ul>
        </div>
    </div>

</div>
