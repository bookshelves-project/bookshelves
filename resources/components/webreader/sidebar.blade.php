<div x-show="sidebarWrapperIsEnabled" class="fixed inset-0 z-40" role="dialog" aria-modal="true">
    {{-- <div x-show="sidebarBackdropIsEnabled" :class="sidebarIsEnabled ? 'opacity-100' : 'opacity-0'"
        class="fixed inset-0 bg-gray-600 bg-opacity-75 transition-opacity ease-linear duration-300" aria-hidden="true">
    </div> --}}
    <div :class="sidebarIsEnabled ? 'translate-x-0' : '-translate-x-full'"
        class="relative flex-1 flex flex-col max-w-xs w-full bg-gray-100 dark:bg-gray-800 transition ease-in-out duration-300 transform h-full"
        data-status="false">
        <div class="absolute top-0 right-0 -mr-12 pt-2 ease-in-out duration-300 opacity-0">
            <button type="button"
                class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                <span class="sr-only">Close sidebar</span>
                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto scrollbar-thin">
            <h1 class="text-xl font-quicksand font-semibold text-black dark:text-gray-100 p-3">
                {{ $title }}
            </h1>
            <nav class="mt-5 px-2">
                <ul class="list-none">
                    <template x-for="(item,key) in toc">
                        <li :id="`${item.id} chapter-${key}`" :data-chapter="`${item.href}`"
                            class="toc-item cursor-pointer text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-700 hover:text-gray-800 dark:hover:text-white group flex links-center px-2 py-2 text-sm font-medium rounded-md my-1 justify-between"
                            x-text="item.label" @click="setChapter(key)"></li>
                    </template>
                </ul>
            </nav>
        </div>
    </div>

    <div class="flex-shrink-0 w-14">
        <!-- Force sidebar to shrink to fit close icon -->
    </div>
</div>
