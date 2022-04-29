<div x-show="!$store.webreader.isLoading" x-transition
    class="fixed right-5 bottom-5 bg-gray-700 bg-opacity-50 px-3 py-2 rounded-md flex items-center space-x-1">
    <div x-text="$store.webreader.currentPage"></div>
    <span>/</span>
    <div x-text="$store.webreader.lastPage"></div>
</div>
