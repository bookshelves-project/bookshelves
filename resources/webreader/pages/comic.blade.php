<x-layouts.webreader>
    <div id="fullScreen" x-data="comic()">
        <div x-show="informationEnabled"
            class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 transform bg-gray-900 p-6 rounded-md shadow max-w-lg">
            <h2 class="text-lg mb-2">
                {{ $title }}
            </h2>
            <p>
                You progression is automatically saved but you can remove it with trash icon.
            </p>
            <ul class="list-none list-inside space-y-2">
                <template x-for="command in commands()">
                    <li>
                        <template x-for="key in command.key">
                            <span x-text="key" class="bg-gray-700 px-2 py-0.5 rounded-md mr-1"></span>
                        </template>
                        <span x-text="command.label"></span>
                    </li>
                </template>
            </ul>
            <div class="text-sm mt-2 text-right">
                {{ config('app.name') }} Webreader
            </div>
        </div>
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
                    class="bg-gray-700 p-1 lg:py-2 lg:px-3 lg:mb-3 lg:ml-3 rounded-md bg-opacity-75 flex-col lg:flex-row flex items-center space-y-1 lg:space-y-0 lg:space-x-1">
                    <x-webreader.action x-show="!isFullscreen" icon="fullscreen" title="Fullscreen (E)"
                        @click="fullscreen" />
                    <x-webreader.action x-show="isFullscreen" icon="fullscreen-exit" title="Exit fullscreen (E)"
                        @click="fullscreenExit" />
                    <x-webreader.action icon="grid" title="See all pages" @click="fullscreen" />
                    <x-webreader.action-divider />
                    <x-webreader.action icon="chevron-double-left" title="First page" @click="first" />
                    <x-webreader.action icon="chevron-double-left" title="Last page" class="transform rotate-180"
                        @click="last" />
                    <x-webreader.action-divider />
                    <x-webreader.action icon="arrow-left" title="Previous page (arrow left)" @click="previous" />
                    <x-webreader.action icon="arrow-left" title="Next page (arrow right or ctrl)"
                        class="transform rotate-180" @click="next" />
                    <x-webreader.action-divider />
                    <x-webreader.action icon="size-full" action="sizeFull" title="Size full width (F)"
                        @click="switchSize('sizeFull')" class="hidden lg:block" />
                    <x-webreader.action icon="size-large" action="sizeLarge" title="Size large (L)"
                        @click="switchSize('sizeLarge')" class="hidden lg:block" />
                    <x-webreader.action icon="size-screen" action="sizeScreen" title="Size screen height (S)"
                        @click="switchSize('sizeScreen')" class="hidden lg:block" />
                    <x-webreader.action-divider />
                    <x-webreader.action x-show="currentPage !== 0" icon="trash" title="Delete progression"
                        @click="deleteProgression" />
                    <x-webreader.action icon="download" title="Download" download :download-link="$full_download" />
                    <x-webreader.action icon="information" title="Information"
                        @click="informationEnabled = !informationEnabled" />
                    <x-webreader.action icon="lock-open" action="navigationIsLock" title="Lock navigation (O)"
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
                sizeFull ? 'lg:w-full' : '',
                sizeLarge ? 'lg:h-[170vh]' : '',
                sizeScreen ? 'lg:h-screen' : '',
                'mx-auto min-w-[60rem] min-w-[auto]',
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
