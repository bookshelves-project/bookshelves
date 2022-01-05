<div class="hidden lg:flex lg:w-64 lg:flex-col lg:fixed lg:inset-y-0">
    <!-- Sidebar component, swap this element with another sidebar if you like -->
    <div class="flex flex-col flex-grow bg-cyan-700 pt-5 overflow-y-auto">
        <div class="flex items-center flex-shrink-0 px-4">
            <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/easywire-logo-cyan-300-mark-white-text.svg"
                alt="Easywire logo">
        </div>
        <nav class="mt-5 flex-1 flex flex-col divide-y divide-cyan-800 overflow-y-auto" aria-label="Sidebar">
            <div class="px-2 space-y-1">
                <!-- Current: "", Default: "" -->
                {{-- <a href="#"
                    class="text-cyan-100 hover:text-white hover:bg-cyan-600 group flex items-center px-2 py-2 text-sm leading-6 font-medium rounded-md"
                    aria-current="page">
                    @svg('icon-home', 'mr-4 flex-shrink-0 h-6 w-6 text-cyan-200')
                    Home
                </a>
                <div x-data="{ open: false, toggle() { this.open = ! this.open } }">
                    <button @click="toggle"
                        class="text-cyan-100 hover:text-white hover:bg-cyan-600 group flex items-center px-2 py-2 text-sm leading-6 font-medium rounded-md w-full justify-between"
                        aria-current="page">
                        <span class="flex">
                            @svg('icon-collection', 'mr-4 flex-shrink-0 h-6 w-6 text-cyan-200')
                            CMS
                        </span>
                        @svg('icon-chevron-right', 'w-5 h-5 rotate-90')
                    </button>
                    <div x-show="open" x-transition class="ml-3">
                        <a href="#"
                            class="text-cyan-100 hover:text-white hover:bg-cyan-600 group flex items-center px-2 py-2 text-sm leading-6 font-medium rounded-md"
                            aria-current="page">
                            @svg('icon-arrow-sm-right', 'w-5 h-5 mr-2')
                            Home
                        </a>
                        <a href="#"
                            class="text-cyan-100 hover:text-white hover:bg-cyan-600 group flex items-center px-2 py-2 text-sm leading-6 font-medium rounded-md"
                            aria-current="page">
                            @svg('icon-arrow-sm-right', 'w-5 h-5 mr-2')
                            Home
                        </a>
                    </div>
                </div> --}}

                @foreach ($links as $key => $link)
                    <x-link :object="$link"
                        class="group flex items-center px-2 py-2 text-sm leading-6 font-medium rounded-md {{ url()->current() === route($link->route, property_exists($link, 'parameters') ? (array) $link->parameters : []) ? 'bg-cyan-800 text-white' : 'text-cyan-100 hover:text-white hover:bg-cyan-600' }}"
                        aria-current="page">
                        @svg('icon-home', 'mr-4 flex-shrink-0 h-6 w-6 text-cyan-200')
                        0{{ $key + 1 }}. {{ $link->title }}
                    </x-link>
                @endforeach
            </div>

            {{-- <div class="mt-auto">
                <a href="#" class="flex w-full group hover:bg-cyan-600 bg-cyan-700 p-4 text-white">
                    @svg('lock-closed', 'mr-4 inline-block h-8 w-8 rounded-full')
                    <div>
                        <p class="text-sm font-medium">
                            Back-office
                        </p>
                        <p
                            class="text-xs font-medium text-gray-700 dark:text-gray-300 group-hover:text-gray-800 dark:group-hover:text-gray-200">
                            For administrators only
                        </p>
                    </div>
                </a>
            </div> --}}
        </nav>
    </div>
</div>
