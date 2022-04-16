<x-layouts.webreader>
    <div x-data="cbz()">
        <div x-ref="filePath" class="hidden">{{ $file_path }}</div>
        <div x-ref="fileFormat" class="hidden">{{ $current_format }}</div>
        <div class="fixed z-10">
            <div>
                <div x-ref="isReady" class="hidden">is ready</div>
                <div x-ref="isNotReady">is not ready</div>
            </div>
            <button @click="previous" class="bg-primary-600 rounded-md px-2 py-1">previous</button>
            <button @click="next" class="bg-primary-600 rounded-md px-2 py-1">next</button>
            <button @click="switchSize('sizeFull')" class="bg-primary-600 rounded-md px-2 py-1">full screen</button>
            <button @click="switchSize('sizeHalf')" class="bg-primary-600 rounded-md px-2 py-1">half screen</button>
            <button @click="switchSize('sizeScreen')" class="bg-primary-600 rounded-md px-2 py-1">screen</button>
        </div>
        <img x-ref="current" src="" :class="[sizeFull ? 'w-full' : '', sizeHalf ? 'h-[150vh]' : '', sizeScreen ? 'h-screen' : '', 'mx-auto']" />
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
