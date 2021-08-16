@php
$composer = file_get_contents(base_path('composer.json'));
$composer = json_decode($composer);

$laravelVersion = Illuminate\Foundation\Application::VERSION;
$phpVersion = PHP_VERSION;
$appVersion = $composer->version;
@endphp

<div id="slideOverLinks">
    <button id="slideBtn" type="button"
        class="inline-flex 2xl:hidden items-center px-4 py-2 border border-gray-300 dark:border-gray-700 shadow-sm text-base font-medium rounded-md text-gray-700 dark:text-gray-300 dark:bg-gray-800 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 fixed top-0 right-0 lg:top-5 lg:right-5 bg-gray-100 z-40">
        <span class="my-auto">
            <x-icon-external-link class="w-6 h-6" />
        </span>
    </button>
    <div id="panelLinks"
        class="translate-x-full 2xl:translate-x-0 max-w-xs w-full pt-5 pb-4 transform transition duration-300 fixed right-0 top-0 bg-gray-100 dark:bg-gray-800 dark:text-white z-40 overflow-y-auto pl-4 h-screen">
        @isset($links)
            <div class="mb-20">
                <ul>
                    <div class="text-center font-handlee text-2xl font-semibold mb-3">
                        Summary
                    </div>
                    @foreach ($links as $link)
                        <li>
                            <a href="/wiki/{{ $link }}"
                                class="mx-4 hover:bg-gray-200 transition-colors duration-100 block rounded-md p-2 {{ Request::url() === config('app.url') . '/wiki/' . $link ? 'bg-gray-200 dark:bg-gray-800' : '' }}">
                                {{ ucfirst($link) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="mb-20">
                <div class="text-center font-handlee text-2xl font-semibold mb-3">
                    Other features
                </div>
                <ul>
                    <li>
                        <a href="/docs" target="_blank" rel="noopener noreferrer"
                            class="mx-4 hover:bg-gray-200 transition-colors duration-100 block rounded-md p-2">
                            {{ config('app.name') }} API documentation
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
            </div>
            <div>
                <div class="text-center font-handlee text-2xl font-semibold mb-3">
                    Current versions
                </div>
                <ul class="pl-6">
                    <li>{{ config('app.name') }}: {{ $appVersion }}</li>
                    <li>Laravel: {{ $laravelVersion }}</li>
                    <li>PHP: {{ $phpVersion }}</li>
                </ul>
            </div>
        </div>

    </div>
