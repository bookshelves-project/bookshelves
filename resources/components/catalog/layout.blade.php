<x-catalog.main>
    <x-slot name="header">
        <x-catalog.header>
            Laravel
        </x-catalog.header>
    </x-slot>
    <x-catalog.navbar />
    <x-catalog.search />
    {{ $slot ?? '' }}
    <x-slot name="subcopy">
        <x-catalog.subcopy>
            Catalog allow you to download directly eBooks on your eReader with Internet browser. You can <a
                href="{{ route('front.home') }}">back
                to other
                features</a>.
        </x-catalog.subcopy>
    </x-slot>

    <x-slot name="footer">
        <x-catalog.footer>
            {{ config('app.name') }} Catalog.
        </x-catalog.footer>
    </x-slot>
</x-catalog.main>
