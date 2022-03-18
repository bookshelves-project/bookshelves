<x-app>
    {{-- <div class="space-y-12">
        <x-content :content="$welcome" full />
        <x-button :route="config('app.front_url')">
            Access to main application
        </x-button>
        <ul role="list" class="space-y-4 grid md:grid-cols-2 md:gap-6 md:space-y-0 lg:grid-cols-3 lg:gap-8">
            @foreach (config('bookshelves.navigation.cards') as $card)
                <x-layouts.navigation.card :card="$card" />
            @endforeach
        </ul>
        <x-content :content="$developers" full />
    </div> --}}
    <div class="relative min-h-screen">
        <div class="absolute transform top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 text-white">
            <div class="flex">
                <div class="font-handlee text-3xl flex items-center space-x-2 max-content mx-auto">
                    <x-icons.bookshelves class="w-10 h-10 text-primary-600" />
                    <span>{{ config('app.name') }}</span>
                </div>
            </div>
            <div class="text-center mt-6 italic">
                This is a welcome screen only for developers.
            </div>
            <div class="mt-6">
                <ul role="list" class="flex flex-wrap justify-center">
                    @foreach (config('bookshelves.navigation.features') as $route)
                        <x-link :array="$route"
                            class="text-base text-gray-400 hover:text-gray-300 hover:bg-gray-800 p-2 rounded-md mx-2"
                            title />
                    @endforeach
                </ul>
                <nav class="flex flex-wrap justify-center mt-2" aria-label="Footer">
                    @foreach (config('bookshelves.navigation.footer') as $route)
                        <x-link :array="$route"
                            class="text-base text-gray-400 hover:text-gray-300 hover:bg-gray-800 p-2 rounded-md mx-2"
                            title external />
                    @endforeach
                </nav>
            </div>
        </div>
    </div>
</x-app>
