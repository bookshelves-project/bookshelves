<x-layouts.webreader>
    <div id="fullScreen" x-data="comic()" x-init="initialize(`{{ json_encode($book) }}`)"
        :class="$store.webreader.showGrid ? 'overflow-hidden' : ''">

        <x-webreader.grid />
        <x-webreader.loader :book="$book" />
        <x-webreader.information :book="$book" />
        <x-webreader.navigation :book="$book" />
        {{-- <x-webreader.navigation-on-screen /> --}}

        <div x-show="$store.webreader.bookIsReady" x-transition>
            <img x-ref="reader" src=""
                :class="[
                    $store.webreader.sizeFull ? 'lg:w-full' : '',
                    $store.webreader.sizeLarge ? 'lg:h-[170vh]' : '',
                    $store.webreader.sizeScreen ? 'lg:h-screen' : '',
                    'mx-auto min-w-[30rem]',
                ]" />
        </div>
    </div>
</x-layouts.webreader>
