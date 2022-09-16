<div>
  <div
    x-show="$store.webreader.isLoading"
    x-transition
    class="fixed top-5 left-5 flex items-center space-x-2 rounded-md bg-gray-700 py-2 px-3"
  >
    <x-icon.loading class="h-5 w-5 text-gray-300" />
    <span x-show="!$store.webreader.bookIsDownloaded">{{ $book->title }} is loading... <span id="downloadStatus"></span>
      ({{ $book->size_human }})</span>
    <span x-show="$store.webreader.bookIsDownloaded">{{ $book->title }} is setup...</span>
  </div>
</div>
