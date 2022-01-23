<x-layouts.main :route="route('front.home')">
    <div class="text-white">
        <x-content :content="$content">
            <ul>
                @foreach ($feeds as $item)
                    <li>
                        <a href="{{ route('front.opds.feed', ['version' => $item['param']]) }}" target="_blank"
                            rel="noopener noreferrer">
                            {{ $item['title'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </x-content>
        <x-button :route="$latest_feed">
            Lastest feed
        </x-button>
    </div>
</x-layouts.main>
