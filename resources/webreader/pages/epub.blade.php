@php
$data_object = json_decode($data);
@endphp
<x-layouts.webreader>
    <div x-data="epub()" x-init="initialize('{{ $data }}')">
        {{-- <div x-data>
            <button @click="$store.sidebar.toggle()">sidebar</button>
            <span x-show="$store.sidebar.on">opened</span>
            <div x-ref="sidebar"></div>
        </div> --}}
        {{-- <x-webreader.color-mode /> --}}
        <x-webreader.sidebar :title="$data_object->title" />
        <x-webreader.navigation :download="$data_object->url" />
        <x-webreader.navigation-on-screen />

        <div class="flex">
            <div class="mx-auto w-full md:max-w-3xl">
                <div class="flex h-screen">
                    <div class="h-screen mt-auto w-full">
                        <div x-show="isLoading" x-transition
                            class="fixed top-5 left-5 bg-gray-700 rounded-md py-2 px-3 flex items-center space-x-2">
                            <x-icons.loading class="w-5 h-5 text-gray-300" />
                            <span>Your ebook is loading... <span id="downloadStatus"></span>
                                ({{ $data_object->size_human }})</span>
                        </div>
                        {{-- <x-webreader.presentation :book="$book" /> --}}
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
            </div>
        </div>
    </div>
</x-layouts.webreader>
