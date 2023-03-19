<div
  x-show="!$store.webreader.isLoading"
  x-transition
  class="fixed right-3 bottom-2 flex items-center space-x-1 rounded-md bg-gray-700 bg-opacity-50 px-3 py-2"
>
  <div
    x-show="$store.webreader.showNavigation"
    class="flex"
  >
    <input
      type="range"
      x-model="$store.webreader.pageRange"
      id="pageRange"
      name="pageRange"
      min="0"
      :max="$store.webreader.lastPage"
      @input="changePageRange"
    >
    <label
      for="pageRange"
      class="sr-only"
    >Change page</label>
  </div>
  <div
    x-text="$store.webreader.currentPage"
    class="w-8 text-right"
  ></div>
  <span>/</span>
  <div
    x-show="$store.webreader.lastPage != 0"
    x-text="$store.webreader.lastPage"
  ></div>
  <div
    x-show="$store.webreader.lastPage == 0"
    class="flex w-6 justify-center"
  >
    <x-icon.loading />
  </div>
</div>
