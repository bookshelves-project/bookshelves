@php
$data_object = json_decode($data);
@endphp
<x-layouts.webreader>
    <div id="fullScreen" x-data="comic()" x-init="initialize(`{{ $data }}`)" :class="showGrid ? 'overflow-hidden' : ''">
        <div x-show="showGrid" class="fixed z-10 w-full overflow-auto h-screen bg-gray-900">
            <div class="grid grid-cols-4 gap-3">
                <template x-for="(file,key) in grid">
                    <button class="relative" @click="currentPage = key, setImage(), displayGrid()">
                        <div class="absolute bottom-0 left-0 p-2 bg-gray-800 z-10">
                            Page <span x-text="key"></span>
                        </div>
                        <img x-show="file.img" :src="file.img" alt="" class="object-cover">
                        <div x-show="!gridIsAvailable" class="min-h-64 w-full bg-gray-700 animate-pulse"></div>
                    </button>
                </template>
            </div>
        </div>
        <div x-show="isLoading" x-transition
            class="fixed top-5 left-5 bg-gray-700 rounded-md py-2 px-3 flex items-center space-x-2">
            <x-icons.loading class="w-5 h-5 text-gray-300" />
            <span>Your comic is loading... <span id="downloadStatus"></span>
                ({{ $data_object->size_human }})</span>
        </div>
        <div x-show="informationEnabled"
            class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 transform bg-gray-900 p-6 rounded-md shadow max-w-lg">
            <h2 class="text-lg mb-2">
                {{ $data_object->title }}
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
        <div x-show="!isLoading" x-transition class="fixed z-20 bottom-0 w-full h-20"
            @mouseover="navigationIsLock ? '' : showNavigation = true"
            @mouseleave="navigationIsLock ? '' : showNavigation = false">
            <div class="fixed bottom-0 left-0">
                <div x-show="showNavigation" x-transition
                    class="bg-gray-700 p-1 lg:py-2 lg:px-3 lg:mb-3 lg:ml-3 rounded-md bg-opacity-75 flex-col lg:flex-row flex items-center space-y-1 lg:space-y-0 lg:space-x-1">
                    <x-webreader.action x-show="!isFullscreen" icon="fullscreen" title="Fullscreen (E)"
                        @click="fullscreen" />
                    <x-webreader.action x-show="isFullscreen" icon="fullscreen-exit" title="Exit fullscreen (E)"
                        @click="fullscreenExit" />
                    <x-webreader.action x-show="grid.length === lastPage+1" icon="grid" title="See all pages (G)"
                        action="showGrid" @click="displayGrid()" />
                    <div x-show="grid.length !== lastPage+1" class="w-10 flex justify-center">
                        <x-icons.loading />
                    </div>
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
                    <x-webreader.action icon="download" title="Download" download :download-link="$data_object->url" />
                    <x-webreader.action icon="information" title="Information" action="informationEnabled"
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
        <div x-show="imageIsReady" x-transition>
            <img x-ref="currentPageImg" src=""
                :class="[
                    sizeFull ? 'lg:w-full' : '',
                    sizeLarge ? 'lg:h-[170vh]' : '',
                    sizeScreen ? 'lg:h-screen' : '',
                    'mx-auto min-w-[60rem] min-w-[auto]',
                ]" />
        </div>
    </div>
</x-layouts.webreader>
