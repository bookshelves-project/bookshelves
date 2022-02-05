<x-layouts.main>
    <div class="space-y-12">
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
    </div>
</x-layouts.main>
