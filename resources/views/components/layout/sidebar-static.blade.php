<div class="hidden xl:flex xl:flex-shrink-0">
    <div class="flex flex-col w-64">
        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <div class="flex-1 flex flex-col min-h-0">
            <x-layout.logo />
            <div class="flex-1 flex flex-col overflow-y-auto">
                <nav class="flex-1 px-2 py-4 dark:bg-gray-800 bg-gray-200 dark:text-white">
                    @include('components.layout.components.sidebar', ['links' => $links])
                </nav>
                <x-layout.components.admin-entry />
            </div>
        </div>
    </div>
</div>
