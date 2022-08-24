<x-layouts.main :route="route('front.home')">
    <x-content :content="$content">
        @isset($route)
            <div class="mx-auto w-max mt-6">
                <x-button :route="$route">
                    Try random book now
                </x-button>
            </div>
        @endisset
    </x-content>
</x-layouts.main>
