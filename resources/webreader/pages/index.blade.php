<x-layouts.webreader>
    <div x-data="epubjs()" x-init="epubjsInit()">
        <div x-ref="epubPath" class="hidden">{{ $epub_path }}</div>
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
        </div>
    </div>
</x-layouts.webreader>
