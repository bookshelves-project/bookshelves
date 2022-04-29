{{-- <x-layouts.webreader>
    <div x-data="epub()" x-init="initialize(`{{ json_encode($book) }}`)">
        <x-webreader.sidebar :title="$book->title" />
        <x-webreader.navigation :download="$book->url" />
        <x-webreader.navigation-on-screen />

        <x-webreader.loader :book="$book" />
        <x-webreader.information :book="$book" />

        <div class="h-screen mx-auto w-full md:max-w-3xl">
            <div x-ref="reader" :class="[readerIsEnabled ? '' : 'hidden', 'h-full w-full']"></div>
            <div x-show="!isLoading" x-transition
                class="fixed z-20 right-5 bottom-5 bg-gray-700 bg-opacity-50 px-3 py-2 rounded-md">
                <div class="flex items-center space-x-1 justify-end">
                    <div x-text="currentPage"></div>
                    <span>/</span>
                    <div x-text="lastPage"></div>
                </div>
                <div class="flex">
                    <input type="range" x-model="pageRange" id="pageRange" name="pageRange" min="0"
                        :max="lastPage" @input="changePageRange">
                    <label for="pageRange" class="sr-only">Change page</label>
                </div>
            </div>
        </div>
    </div>
</x-layouts.webreader> --}}

<x-layouts.webreader>
    <div id="fullScreen" x-data="epub()" x-init="initialize(`{{ json_encode($book) }}`)"
        :class="$store.webreader.showGrid ? 'overflow-hidden' : ''">

        <x-webreader.grid />
        <x-webreader.loader :book="$book" />
        <x-webreader.information :book="$book" />
        <x-webreader.navigation :book="$book" />
        <x-webreader.navigation-on-screen />

        {{-- <div x-show="$store.webreader.bookIsReady" x-transition>
            <img x-ref="reader" src=""
                :class="[
                    $store.webreader.sizeFull ? 'lg:w-full' : '',
                    $store.webreader.sizeLarge ? 'lg:h-[170vh]' : '',
                    $store.webreader.sizeScreen ? 'lg:h-screen' : '',
                    'mx-auto min-w-[60rem] min-w-[auto]',
                ]" />
        </div> --}}
        <div class="h-screen mx-auto w-full md:max-w-3xl">
            <div x-ref="reader" :class="[$store.webreader.bookIsReady ? '' : 'hidden', 'h-full w-full']"></div>
            {{-- <div x-show="!isLoading" x-transition
                class="fixed z-20 right-5 bottom-5 bg-gray-700 bg-opacity-50 px-3 py-2 rounded-md">
                <div class="flex items-center space-x-1 justify-end">
                    <div x-text="currentPage"></div>
                    <span>/</span>
                    <div x-text="lastPage"></div>
                </div>
                <div class="flex">
                    <input type="range" x-model="pageRange" id="pageRange" name="pageRange" min="0"
                        :max="lastPage" @input="changePageRange">
                    <label for="pageRange" class="sr-only">Change page</label>
                </div>
            </div> --}}
        </div>
    </div>
</x-layouts.webreader>
