<div x-show="!$store.webreader.isLoading" x-transition class="fixed z-20 bottom-0 w-full h-20"
    @mouseover="$store.webreader.navigationIsLock ? '' : $store.webreader.showNavigation = true"
    @mouseleave="$store.webreader.navigationIsLock ? '' : $store.webreader.showNavigation = false">
    <div class="fixed bottom-0 left-0">
        <div x-show="$store.webreader.showNavigation" x-transition
            class="bg-gray-700 p-1 lg:py-2 lg:px-3 lg:mb-3 lg:ml-3 rounded-md bg-opacity-75 flex-col lg:flex-row flex items-center space-y-1 lg:space-y-0 lg:space-x-1">
            <x-webreader.action x-show="!$store.webreader.isFullscreen" icon="fullscreen" title="Fullscreen (E)"
                @click="fullscreen" />
            <x-webreader.action x-show="$store.webreader.isFullscreen" icon="fullscreen-exit"
                title="Exit fullscreen (E)" @click="fullscreenExit" />
            <x-webreader.action icon="grid" title="See all pages (G)" action="$store.webreader.showGrid"
                @click="displayGrid()" />
            {{-- <x-webreader.action x-show="$store.webreader.gridIsAvailable" icon="grid" title="See all pages (G)"
                action="$store.webreader.showGrid" @click="displayGrid()" />
            <div x-show="!$store.webreader.gridIsAvailable" class="w-10 flex justify-center">
                <x-icons.loading />
            </div> --}}
            <x-webreader.action-divider />
            <x-webreader.action icon="chevron-double-left" title="First page" @click="first" />
            <x-webreader.action icon="chevron-double-left" title="Last page" class="transform rotate-180"
                @click="last" />
            <x-webreader.action-divider />
            <x-webreader.action icon="arrow-left" title="Previous page (arrow left)" @click="previous" />
            <x-webreader.action icon="arrow-left" title="Next page (arrow right or ctrl)" class="transform rotate-180"
                @click="next" />
            <x-webreader.action-divider />
            <x-webreader.action icon="size-full" action="$store.webreader.sizeFull" title="Size full width (F)"
                @click="switchSize('sizeFull')" class="hidden lg:block" />
            <x-webreader.action icon="size-large" action="$store.webreader.sizeLarge" title="Size large (L)"
                @click="switchSize('sizeLarge')" class="hidden lg:block" />
            <x-webreader.action icon="size-screen" action="$store.webreader.sizeScreen" title="Size screen height (S)"
                @click="switchSize('sizeScreen')" class="hidden lg:block" />
            <x-webreader.action-divider />
            <x-webreader.action x-show="$store.webreader.currentPage !== 0" icon="trash" title="Delete progression"
                @click="deleteProgression" />
            <x-webreader.action icon="download" title="Download" download :download-link="$book->download" />
            <x-webreader.action icon="information" title="Information" action="$store.webreader.informationEnabled"
                @click="$store.webreader.informationEnabled = !$store.webreader.informationEnabled" />
            <x-webreader.action icon="lock-open" action="$store.webreader.navigationIsLock" title="Lock navigation (O)"
                @click="lock" />
        </div>
    </div>
    <x-webreader.pagination />
</div>
