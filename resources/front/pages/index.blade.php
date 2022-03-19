<x-layouts.app>
    <main class="relative min-h-screen lg:grid h-full">
        <div class=" pt-10 lg:pt-0">
            <div
                class="lg:absolute lg:transform lg:top-1/2 lg:left-1/2 lg:-translate-y-1/2 lg:-translate-x-1/2 text-white">
                <div class="flex">
                    <div class="font-handlee text-xl lg:text-3xl flex items-center space-x-2 max-content mx-auto">
                        <x-icons.bookshelves class="w-6 h-6 lg:w-10 lg:h-10 text-primary-600" />
                        <span>{{ config('app.name') }}</span>
                    </div>
                </div>
                <div class="mt-6 max-w-lg mx-auto">
                    <ul role="list" class="lg:flex lg:flex-wrap justify-center">
                        @foreach (config('bookshelves.navigation.features') as $route)
                            <x-link :data="$route"
                                class="text-base text-gray-400 hover:text-gray-300 hover:bg-gray-800 p-2 rounded-md !mx-auto !lg:mx-2 max-content" />
                        @endforeach
                    </ul>
                    <div class="border-t border-gray-600 mt-3 max-w-sm mx-auto"></div>
                    <nav class="lg:flex lg:flex-wrap justify-center mt-3" aria-label="Footer">
                        @foreach (config('bookshelves.navigation.footer') as $route)
                            <x-link :data="$route"
                                class="text-base text-gray-400 hover:text-gray-300 hover:bg-gray-800 p-2 rounded-md !mx-auto !lg:mx-2 max-content" />
                        @endforeach
                    </nav>
                </div>
            </div>
        </div>
        <x-layouts.footer class="lg:row-start-2 lg:row-end-3" />
    </main>
</x-layouts.app>
