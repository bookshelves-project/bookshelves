<x-layouts.webreader>
    <div id="fullScreen" x-data="epubjs()" x-init="initialize(`{{ json_encode($book) }}`)"
        :class="$store.webreader.showGrid ? 'overflow-hidden' : ''">

        <x-webreader.loader :book="$book" />
        <x-webreader.sidebar :book="$book" />
        <x-webreader.information :book="$book" />
        <x-webreader.navigation :book="$book" />
        <x-webreader.chapter />
        <x-webreader.navigation-on-screen />

        <div x-show="$store.webreader.bookIsReady" class="h-screen mx-auto w-full md:max-w-3xl">
            <div x-ref="reader" :class="[$store.webreader.bookIsReady ? '' : 'hidden', 'h-full w-full']"></div>
        </div>
    </div>
</x-layouts.webreader>
