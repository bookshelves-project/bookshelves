<a href="/" class="flex-shrink-0 flex items-center px-4 py-4 bg-gray-200 dark:bg-gray-800 relative">
    <div class="h-8 w-auto font-handlee dark:text-white text-2xl flex items-center">
        <x-icon-bookshelves class="w-8 h-8" />
        <div>
            <span class="ml-2">
                {{ config('app.name') }}
            </span>
            <div class="absolute bottom-0 right-4 flex items-center text-xl">
                <span>
                    Features
                </span>
                <x-icon-features class="
                    w-5 h-5 ml-1" />
            </div>
        </div>
    </div>
</a>
