<div x-show="readerIsEnabled">
    <div x-show="tutorialIsEnabled" class="fixed z-30 top-20 left-1/2 -translate-x-1/2 transform on-screen-tuto">
        <div class="text-3xl font-quicksand text-center text-black">Welcome on Webreader.</div>
        <p class="mt-3 text-black">
            This is tutorial to use this tool, you can click on left to get previous page and right to next page, if
            you click on center, you can have option menu on top.
        </p>
        <div x-ref="navigationOnScreenDisableTutoBtn">
            <x-button button @click="disableTutorial" class="text-black">
                I understand how to read
            </x-button>
        </div>
    </div>
    <div :class="tutorialIsEnabled ? 'on-screen-tuto-color' : ''" class="fixed z-20 grid grid-cols-3 w-full h-full">
        <button class="on-screen-btn" @click="previous">
            <div x-show="tutorialIsEnabled" class="on-screen-tuto">
                Click on me to get previous page
            </div>
        </button>
        <button x-data @click="navigationIsEnabled=!navigationIsEnabled" class="on-screen-btn">
            <div x-show="tutorialIsEnabled" class="on-screen-tuto">
                Click on me to get options
            </div>
        </button>
        <button class="on-screen-btn" @click="next">
            <div x-show="tutorialIsEnabled" class="on-screen-tuto">
                Click on me to get next page
            </div>
        </button>
    </div>
</div>
