<footer>
    <div
        class="
        mx-auto
        pb-6
        pt-10
        2xl:flex 2xl:items-center 2xl:justify-between
      ">
        <div class="md:flex md:justify-center md:space-x-6 xl:order-2 space-y-2 md:space-y-0">
            <a href="{{ $composer->homepage ?? '' }}" class="text-gray-400 block text-center hover:text-gray-500"
                target="_blank" rel="noopener noreferrer">
                Bookshelves v{{ $composer->version ?? '' }}
            </a>
            <a href="https://laravel.com/" class="text-gray-400 block text-center hover:text-gray-500" target="_blank"
                rel="noopener noreferrer">
                Laravel v{{ $laravelVersion ?? '' }}
            </a>
            <a href="https://www.php.net/" class="text-gray-400 block text-center hover:text-gray-500" target="_blank"
                rel="noopener noreferrer">
                PHP v{{ $phpVersion ?? '' }}
            </a>
        </div>
        <div class="xl:mt-0 xl:order-1">
            <div class="text-center text-base text-gray-400 md:flex items-center justify-center mt-3 2xl:mt-0">
                <a href="https://creativecommons.org/" target="_blank" rel="noopener noreferrer"
                    class="flex hover:text-gray-500">
                    <div class="flex md:mr-1 items-center mx-auto space-x-1">
                        <x-icon-cc class="w-5 h-5" />
                        <x-icon-cc-by class="w-5 h-5" />
                        <x-icon-cc-nc class="w-5 h-5" />
                        <span>
                            {{ $date }}
                        </span>
                    </div>
                </a>
                <span class="hidden md:block mr-1">·</span>
                <div>
                    {{ config('app.name') }} Team.
                    {{ $composer->license ?? '' }}
                    License.
                </div>
            </div>
        </div>
    </div>
</footer>
