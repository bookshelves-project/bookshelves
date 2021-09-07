<div id="slide-over-wrapper" class="fixed z-50 inset-0 overflow-hidden hidden" role="dialog" aria-modal="true">

    <div class="absolute inset-0 overflow-hidden">
        {{-- <div id="slide-over-backdrop"
        class="fixed inset-0 bg-gray-600 bg-opacity-75 transition-opacity ease-linear duration-300 opacity-0"
        aria-hidden="true"></div> --}}
        <div id="slide-over-backdrop" class="absolute inset-0" aria-hidden="true">
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
                <div id="slide-over"
                    class="w-screen max-w-md transform transition ease-in-out duration-300 translate-x-full">
                    <div
                        class="h-full flex flex-col py-6 dark:bg-gray-800 shadow-xl overflow-y-scroll scrollbar-thin bg-gray-200">
                        <div class="px-4 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100" id="slide-over-title">

                                </h2>
                                <div id="slide-over-close-button" class="ml-3 h-7 flex items-center">
                                    <button type="button"
                                        class="bg-white dark:bg-gray-800 rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <span class="sr-only">Close panel</span>
                                        <!-- Heroicon name: outline/x -->
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 relative flex-1 px-4 sm:px-6 dark:text-gray-100">
                            <div id="toc-slide-over"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
