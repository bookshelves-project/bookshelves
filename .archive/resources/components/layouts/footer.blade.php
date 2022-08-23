<footer {{ $attributes }}>
    <div class="max-w-7xl mx-auto pt-12 pb-6 px-4 overflow-hidden sm:px-6 lg:px-8">
        <div class="mt-6 text-sm text-gray-400 mx-auto w-max">
            <div class="lg:flex lg:items-center space-y-2 lg:space-y-0">
                <a href="https://creativecommons.org/" target="_blank" rel="noopener noreferrer"
                    class="flex items-center hover:text-gray-300 transition-colors duration-75 text-center">
                    <x-icons.cc class="w-5 h-5" />
                    <span class="ml-1">
                        {{ $date }}
                    </span>
                </a>
                <span class="mx-1 hidden lg:flex">·</span>
                <a href="{{ config('app.repository_url') }}" target="_blank" rel="noopener noreferrer"
                    class="hover:text-gray-300 transition-colors duration-75 block text-center">{{ config('app.name') }}
                    v{{ $composer->version }}</a><span class="hidden lg:flex">,</span>
                <a href="{{ config('app.documentation_url') }}/development/license"
                    class="hover:text-gray-300 transition-colors duration-75 block lg:ml-1 text-center">{{ $composer->license }}
                    license</a><span class="hidden lg:flex">.</span>
            </div>
        </div>
    </div>
</footer>
