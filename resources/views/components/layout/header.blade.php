<div class="relative z-10 h-16 flex bg-white dark:bg-gray-700 shadow">
    <div class="max-w-7xl flex-shrink-0 flex m-auto w-full">
        <button id="sidebar-header-button" type="button"
            class="px-4 border-r border-gray-200 dark:border-gray-600 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 xl:hidden">
            <span class="sr-only">Open sidebar</span>
            <x-icon-menu class="h-6 w-6" />
        </button>
        <div class="flex-1 px-4 flex justify-between">
            <div class="flex-1 flex">
                <div class="w-full flex xl:ml-0">
                    <h1
                        class="xl:ml-4 text-lg lg:text-2xl font-semibold text-gray-900 dark:text-white my-auto line-clamp-1">
                        @hasSection('title')
                            @yield('title')
                        @else
                            {{ config('app.name') }}
                        @endif
                    </h1>
                </div>
            </div>
            <div class="ml-4 flex items-center xl:ml-6">
                <button id="switchColorBtn" class="p-3">
                    <span class="my-auto block dark:hidden">
                        <x-icon-sun class="w-6 h-6 dark:text-white" />
                    </span>
                    <span class="my-auto hidden dark:block">
                        <x-icon-moon class="w-6 h-6 dark:text-white" />
                    </span>
                </button>
            </div>
            <button id="slide-over-header-button" type="button"
                class="px-4 border-l border-gray-200 dark:border-gray-600 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 xl:hidden">
                <span class="sr-only">Open sidebar</span>
                <x-icon-menu-short class="h-6 w-6" />
            </button>
        </div>
    </div>
</div>
