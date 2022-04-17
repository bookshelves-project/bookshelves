<x-layouts.webreader>
    <div id="fullScreen" x-data="comic()">
        <div x-show="isLoading" x-transition
            class="fixed top-5 left-5 bg-gray-700 rounded-md py-2 px-3 flex items-center space-x-2">
            <x-icons.loading class="w-5 h-5 text-gray-300" />
            <span>Your comic is loading... ({{ $file->size_human }})</span>
        </div>
        <div x-show="!isLoading" x-transition class="fixed bottom-0 w-full h-20"
            @mouseover="navigationIsLock ? '' : showNavigation = true"
            @mouseleave="navigationIsLock ? '' : showNavigation = false">
            <div class="fixed bottom-0 left-0">
                <div x-show="showNavigation" x-transition
                    class="bg-gray-700 py-2 px-3 mb-3 ml-3 rounded-md bg-opacity-75 flex items-center space-x-1">
                    <x-webreader.action x-show="!isFullscreen" icon="fullscreen" title="Fullscreen"
                        @click="fullscreen" />
                    <x-webreader.action x-show="isFullscreen" icon="fullscreen-exit" title="Exit fullscreen"
                        @click="fullscreenExit" />
                    <x-webreader.action icon="grid" title="See all pages" @click="fullscreen" />
                    <x-webreader.action icon="chevron-double-left" title="First page" @click="first" />
                    <x-webreader.action icon="arrow-left" title="Previous page" @click="previous" />
                    <x-webreader.action icon="arrow-left" title="Next page" class="transform rotate-180" @click="next" />
                    <x-webreader.action icon="chevron-double-left" title="Last page" class="transform rotate-180"
                        @click="last" />
                    <x-webreader.action icon="size-full" action="sizeFull" title="Size full width"
                        @click="switchSize('sizeFull')" />
                    <x-webreader.action icon="size-large" action="sizeLarge" title="Size large"
                        @click="switchSize('sizeLarge')" />
                    <x-webreader.action icon="size-screen" action="sizeScreen" title="Size screen height"
                        @click="switchSize('sizeScreen')" />
                    <x-webreader.action icon="sun" title="Switch color mode" @click="fullscreen" />
                    <x-webreader.action icon="information" title="Information" @click="fullscreen" />
                    <x-webreader.action icon="lock-open" action="navigationIsLock" title="Lock navigation"
                        @click="lock" />
                </div>
            </div>
            <div x-show="!isLoading" x-transition
                class="fixed right-5 bottom-5 bg-gray-700 bg-opacity-50 px-3 py-2 rounded-md flex items-center space-x-1">
                <div x-text="currentPage"></div>
                <span>/</span>
                <div x-text="lastPage"></div>
            </div>
        </div>
        <div x-ref="fileName" class="hidden">{{ $file->file_name }}</div>
        <div x-ref="url" class="hidden">{{ $full_download }}</div>
        <div x-ref="filePath" class="hidden">{{ $file_path }}</div>
        <div x-ref="fileFormat" class="hidden">{{ $current_format }}</div>
        <div x-show="imageIsReady" x-transition>
            <img x-ref="current" src="" :class="[
                sizeFull ? 'w-full' : '',
                sizeLarge ? 'h-[170vh]' : '',
                sizeScreen ? 'h-screen' : '',
                'mx-auto',
            ]" />
        </div>
        {{-- <div x-data>
            <button @click="$store.sidebar.toggle()">sidebar</button>
            <span x-show="$store.sidebar.on">opened</span>
            <div x-ref="sidebar"></div>
        </div>
        <x-webreader.color-mode />
        <x-webreader.sidebar :title="$title" />
        <x-webreader.navigation :download="$download_link" :home="$home" />
        <x-webreader.navigation-on-screen />

        <div class="flex">
            <div class="mx-auto w-full md:max-w-3xl">
                <div class="flex h-screen">
                    <div class="h-screen mt-auto w-full">
                        <x-webreader.presentation :book="$book" />
                        <x-webreader.reader />
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</x-layouts.webreader>
