<div class="hidden xl:flex xl:flex-shrink-0">
    <div class="flex flex-col w-64">
        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <div class="flex-1 flex flex-col min-h-0">
            <a href="/"
                class="flex items-center h-16 flex-shrink-0 px-4 bg-gray-200 dark:bg-gray-800 hover:bg-gray-300 dark:hover:bg-gray-700 transition-colors duration-100">
                <div class="h-8 w-auto font-handlee dark:text-white text-2xl flex items-center">
                    <x-icon-bookshelves class="w-8 h-8" />
                    <span class="ml-2">
                        {{ config('app.name') }}
                    </span>
                </div>
            </a>
            <div class="flex-1 flex flex-col overflow-y-auto">
                <nav class="flex-1 px-2 py-4 dark:bg-gray-800 bg-gray-200 dark:text-white">
                    @include('components.layout.components.sidebar', ['links' => $links])
                </nav>
                <x-layout.components.admin-entry />
            </div>
        </div>
    </div>
</div>
