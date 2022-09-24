<div
  x-show="!$store.webreader.isLoading"
  x-transition
  class="fixed bottom-0 z-30 h-20 w-full"
  @mouseover="$store.webreader.navigationIsLock ? '' : $store.webreader.showNavigation = true"
  @mouseleave="$store.webreader.navigationIsLock ? '' : $store.webreader.showNavigation = false"
>
  <div class="fixed bottom-2 left-2">
    <div
      x-show="$store.webreader.showNavigation"
      x-transition
      class="flex flex-col items-center space-y-1 rounded-md bg-gray-700 bg-opacity-75 p-1 lg:flex-row lg:space-y-0 lg:space-x-1 lg:py-2 lg:px-3"
    >

      {{-- <div x-show="$store.webreader.navigationOptions.fullscreen"> --}}
      <x-webreader.action
        x-show="!$store.webreader.isFullscreen"
        icon="fullscreen"
        title="Fullscreen (E)"
        @click="$store.webreader.fullscreen()"
      />
      <x-webreader.action
        x-show="$store.webreader.isFullscreen"
        icon="fullscreen-exit"
        title="Exit fullscreen (E)"
        @click="$store.webreader.fullscreenExit()"
      />
      {{-- </div>s --}}

      <x-webreader.action
        x-show="$store.webreader.navigationOptions.grid && $store.webreader.gridIsAvailable"
        icon="grid"
        title="See all pages (G)"
        action="$store.webreader.showGrid"
        @click="displayGrid()"
      />
      <div
        x-show="$store.webreader.navigationOptions.grid && !$store.webreader.gridIsAvailable"
        class="flex w-10 justify-center"
      >
        <x-icon.loading />
      </div>

      <x-webreader.action
        x-show="$store.webreader.navigationOptions.sidebar"
        icon="menu"
        title="Open sidebar (G)"
        action="$store.webreader.sidebarIsEnabled"
        @click="$store.webreader.toggleSidebar()"
      />

      <x-webreader.action-divider />

      <x-webreader.action
        x-show="$store.webreader.navigationOptions.first"
        icon="chevron-double-left"
        title="First page"
        @click="first"
      />
      <x-webreader.action
        x-show="$store.webreader.navigationOptions.last"
        icon="chevron-double-left"
        title="Last page"
        class="rotate-180 transform"
        @click="last"
      />
      <x-webreader.action-divider />
      <x-webreader.action
        x-show="$store.webreader.navigationOptions.previous"
        icon="arrow-left"
        title="Previous page (arrow left)"
        @click="previous"
      />
      <x-webreader.action
        x-show="$store.webreader.navigationOptions.next"
        icon="arrow-left"
        title="Next page (arrow right or ctrl)"
        class="rotate-180 transform"
        @click="next"
      />

      <x-webreader.action-divider />

      <x-webreader.action
        x-show="$store.webreader.navigationOptions.sizeable"
        icon="size-full"
        action="$store.webreader.sizeFull"
        title="Size full width (F)"
        @click="$store.webreader.switchSize('sizeFull')"
        class="hidden lg:block"
      />
      <x-webreader.action
        x-show="$store.webreader.navigationOptions.sizeable"
        icon="size-large"
        action="$store.webreader.sizeLarge"
        title="Size large (L)"
        @click="$store.webreader.switchSize('sizeLarge')"
        class="hidden lg:block"
      />
      <x-webreader.action
        x-show="$store.webreader.navigationOptions.sizeable"
        icon="size-screen"
        action="$store.webreader.sizeScreen"
        title="Size screen height (S)"
        @click="$store.webreader.switchSize('sizeScreen')"
        class="hidden lg:block"
      />

      <x-webreader.action-divider />

      <x-webreader.action
        icon="trash"
        title="Delete progression"
        @click="$store.webreader.deleteProgression()"
      />
      <x-webreader.action
        icon="download"
        title="Download"
        download
        :download-link="$book->download"
      />
      <x-webreader.action
        x-show="$store.webreader.navigationOptions.information"
        icon="information"
        title="Information"
        action="$store.webreader.informationEnabled"
        @click="$store.webreader.informationEnabled = !$store.webreader.informationEnabled"
      />
      <x-webreader.action
        icon="lock-open"
        action="$store.webreader.navigationIsLock"
        title="Lock navigation (O)"
        @click="$store.webreader.lockMenu()"
      />
    </div>
  </div>
  <x-webreader.pagination />
</div>
