<x-layouts.webreader>
    <div id="fullScreen" x-data="epub()" x-init="initialize(`{{ json_encode($book) }}`)"
        :class="$store.webreader.showGrid ? 'overflow-hidden' : ''">

        <x-webreader.loader :book="$book" />
        <x-webreader.sidebar :book="$book" />
        <x-webreader.information :book="$book" />
        <x-webreader.navigation :book="$book" />
        <x-webreader.chapter />

        <div x-show="$store.webreader.bookIsReady" class="h-screen mx-auto w-full md:max-w-3xl">
            <div x-show="page"
                class="relative p-5 prose prose-lg word-wraping bg-white !text-black min-h-screen mx-auto">
                <img :class="page.isImage ? '' : 'hidden'" :src="page.src" alt=""
                    class="absolute inset-0 z-10 !mb-0 h-full w-full object-cover">
                <div :class="page.text !== undefined ? '' : 'hidden'" x-html="page.text"></div>
            </div>
        </div>
    </div>
</x-layouts.webreader>
