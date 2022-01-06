<div x-data="toc" class="fixed inset-0 overflow-hidden xl:hidden" aria-labelledby="slide-over-title" role="dialog"
    aria-modal="true">
    <div class="absolute inset-0 overflow-hidden">
        <!-- Background overlay, show/hide based on slide-over state. -->
        <div class="absolute inset-0" aria-hidden="true">
            <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
                <!--
          Slide-over panel, show/hide based on slide-over state.

          Entering: "transform transition ease-in-out duration-500 sm:duration-700"
            From: "translate-x-full"
            To: "translate-x-0"
          Leaving: "transform transition ease-in-out duration-500 sm:duration-700"
            From: "translate-x-0"
            To: "translate-x-full"
        -->
                <div class="w-screen max-w-md">
                    <div class="h-full flex flex-col py-6 bg-gray-800 shadow-xl overflow-y-scroll">
                        <div class="px-4 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-lg font-medium text-gray-100" id="slide-over-title">
                                    Panel title
                                </h2>
                                <div class="ml-3 h-7 flex items-center">
                                    <button type="button"
                                        class="bg-gray-700 rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <span class="sr-only">Close panel</span>
                                        <!-- Heroicon name: outline/x -->
                                        @svg('icon-x', 'w-6 h-6')
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 relative flex-1 px-4 sm:px-6">
                            <div id="toc"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
