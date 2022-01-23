<div class="container">
    <ol class="flex flex-wrap items-center gap-x-4 py-4 text-sm md:text-base">
        @foreach ($links as $link)
            <li>
                <span class="mr-2">/</span>

                @if ($loop->last)
                    <span>{{ $link['text'] }}</span>
                @else
                    <a href="{{ $link['href'] }}" class="hover:text-primary">{{ $link['text'] }}</a>
                @endif
            </li>
        @endforeach
    </ol>
</div>
