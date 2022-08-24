<footer {{ $attributes }}>
    <div
        class="mx-auto max-w-7xl overflow-hidden px-4 pt-12 pb-6 sm:px-6 lg:px-8">
        <div class="mx-auto mt-6 w-max text-sm text-gray-400">
            <div class="space-y-2 lg:flex lg:items-center lg:space-y-0">
                <a href="https://creativecommons.org/"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="flex items-center text-center transition-colors duration-75 hover:text-gray-300">
                    <x-icons.cc class="h-5 w-5" />
                    <span class="ml-1">
                        {{ $date }}
                    </span>
                </a>
                <span class="mx-1 hidden lg:flex">·</span>
                <a href="{{ config('bookshelves.repository_url') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="block text-center transition-colors duration-75 hover:text-gray-300">{{ config('app.name') }}
                    v{{ $composer->version }}</a><span
                    class="hidden lg:flex">,</span>
                <a href="{{ config('bookshelves.documentation_url') }}/development/license"
                    class="block text-center transition-colors duration-75 hover:text-gray-300 lg:ml-1">{{ $composer->license }}
                    license</a><span class="hidden lg:flex">.</span>
            </div>
        </div>
    </div>
</footer>
