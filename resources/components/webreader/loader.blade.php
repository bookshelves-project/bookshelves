<div>
    <div x-show="$store.webreader.isLoading" x-transition
        class="fixed top-5 left-5 bg-gray-700 rounded-md py-2 px-3 flex items-center space-x-2">
        <x-icons.loading class="w-5 h-5 text-gray-300" />
        <span>{{ $book->title }} is loading... <span id="downloadStatus"></span>
            ({{ $book->size_human }})</span>
    </div>
</div>
