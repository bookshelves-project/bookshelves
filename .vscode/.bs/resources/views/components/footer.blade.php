@php
$link_class = 'block text-center transition-colors duration-75 hover:text-gray-300';
@endphp

<footer {{ $attributes }}>
    <div class="mx-auto max-w-7xl overflow-hidden px-4 pt-12 pb-6 sm:px-8">
        <div class="mx-auto mt-6 w-max space-y-2 text-sm text-gray-400">
            <div class="mx-auto flex w-max items-center">
                <a href="{{ config('bookshelves.documentation_url') }}/development/license"
                    class="{{ $link_class }} sm:ml-1">{{ $composer->license }}
                    License</a><span class="ml-1">{{ $date }}</span>
            </div>
            <div class="space-y-2 sm:flex sm:items-center sm:space-y-0">
                <a href="{{ config('bookshelves.repository_url') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="{{ $link_class }}">{{ config('app.name') }}
                    v{{ $composer->version }}</a><span
                    class="mx-1 hidden sm:flex">·</span><a
                    href="https://laravel.com/docs/9.x"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="{{ $link_class }}">Laravel
                    v{{ Illuminate\Foundation\Application::VERSION }}</a><span
                    class="mx-1 hidden sm:flex">·</span><a
                    href="https://www.php.net/releases/8.1/en.php"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="{{ $link_class }}">PHP
                    v{{ PHP_VERSION }}</a>
            </div>
        </div>
    </div>
</footer>
