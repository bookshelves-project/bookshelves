<div class="flex-shrink-0 flex ">
    <a href="{{ route(config('bookshelves.navigation.admin.route')) }}"
        class="flex-shrink-0 w-full group block hover:bg-gray-200 dark:hover:bg-gray-600 bg-gray-300 dark:bg-gray-700 p-4 text-gray-900 dark:text-white">
        <div class="flex items-center">
            <x-dynamic-component component="{{ 'icon-' . config('bookshelves.navigation.admin.icon') }}"
                class="inline-block h-8 w-8 rounded-full" />
            <div class="ml-3">
                <p class="text-sm font-medium">
                    {{ config('bookshelves.navigation.admin.title') }}
                </p>
                <p
                    class="text-xs font-medium text-gray-700 dark:text-gray-300 group-hover:text-gray-800 dark:group-hover:text-gray-200">
                    For administrators only
                </p>
            </div>
        </div>
    </a>
</div>
