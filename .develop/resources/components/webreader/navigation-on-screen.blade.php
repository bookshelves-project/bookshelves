<div x-show="$store.webreader.bookIsReady">
  <div
    x-show="$store.webreader.tutorialIsEnabled"
    class="on-screen-tuto fixed top-20 left-1/2 z-30 -translate-x-1/2 transform"
  >
    <div class="font-quicksand text-center text-3xl text-black">Welcome on Webreader.</div>
    <p class="mt-3 text-black">
      This is tutorial to use this tool, you can click on left to get previous page and right to next page, if
      you click on center, you can have option menu on top.
    </p>
    <div x-ref="navigationOnScreenDisableTutoBtn">
      <x-steward-button
        button
        @click="$store.webreader.disableTutorial()"
        class="text-black"
      >
        I understand how to read
      </x-steward-button>
    </div>
  </div>
  <div
    :class="$store.webreader.tutorialIsEnabled ? 'on-screen-tuto-color' : ''"
    class="fixed z-20 grid h-full w-full grid-cols-3"
  >
    <button
      class="on-screen-btn"
      @click="previous"
    >
      <div
        x-show="$store.webreader.tutorialIsEnabled"
        class="on-screen-tuto"
      >
        Click on me to get previous page
      </div>
    </button>
    <button
      x-data
      @click="$store.webreader.toggleMenu()"
      class="on-screen-btn"
    >
      <div
        x-show="$store.webreader.tutorialIsEnabled"
        class="on-screen-tuto"
      >
        Click on me to get options
      </div>
    </button>
    <button
      class="on-screen-btn"
      @click="next"
    >
      <div
        x-show="$store.webreader.tutorialIsEnabled"
        class="on-screen-tuto"
      >
        Click on me to get next page
      </div>
    </button>
  </div>
</div>
