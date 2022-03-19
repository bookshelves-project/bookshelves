<div x-ref="navigationOnScreen" class="hidden">
    <div class="fixed z-30 top-20 left-1/2 -translate-x-1/2 transform on-screen-tuto hidden">
        <div class="text-3xl font-quicksand text-center">Welcome on Webreader.</div>
        <p class="mt-3">
            This is tutorial to use this tool, you can click on left to get previous page and right to next page, if
            you click on center, you can have option menu on top.
        </p>
        <div x-ref="navigationOnScreenDisableTutoBtn">
            <x-button button>
                I understand how to read
            </x-button>
        </div>
    </div>
    <div x-ref="navigationOnScreenInterface" class="fixed z-20 grid grid-cols-3 w-full h-full on-screen-tuto-color">
        <button x-ref="pageLeftBtn" class="on-screen-btn">
            <div class="on-screen-tuto hidden">
                Click on me to get previous page
            </div>
        </button>
        <button x-data @click="$store.navigation.toggle()" x-ref="pageCenterBtn" class="on-screen-btn">
            <div class="on-screen-tuto hidden">
                Click on me to get options
            </div>
        </button>
        <button x-ref="pageRightBtn" class="on-screen-btn">
            <div class="on-screen-tuto hidden">
                Click on me to get next page
            </div>
        </button>
    </div>
</div>
