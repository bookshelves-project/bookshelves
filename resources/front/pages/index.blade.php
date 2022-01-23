<x-layouts.main>
    <div class="space-y-12">
        <div class="space-y-5 sm:space-y-4 md:max-w-xl lg:max-w-3xl xl:max-w-none">
            <p class="text-xl text-gray-300">
                Features offer a lot of extra options to find and read eBooks. You can download directly eBooks from
                your eReader with Catalog or you can use OPDS (Open Publication Distribution System) feed to get all
                eBooks on your favorite application. And if you want to read eBook directly in your browser with
                Webreader. {{ config('app.name') }} Features offer options but if you want to find books, series and
                authors, you
                can consult main application.
            </p>
            <x-button :route="config('app.front_url')">
                Access to main application
            </x-button>
        </div>
        <ul role="list" class="space-y-4 grid md:grid-cols-2 md:gap-6 md:space-y-0 lg:grid-cols-3 lg:gap-8">
            @foreach (config('bookshelves.navigation.cards') as $card)
                <x-layouts.navigation.card :card="$card" />
            @endforeach
        </ul>
        <a href="{{ route('admin.login') }}"
            class="text-center uppercase text-primary font-bold sm:max-w-md px-12 py-8 bg-white shadow-md overflow-hidden rounded-sm">
            Go to admin !
        </a>
    </div>
</x-layouts.main>
