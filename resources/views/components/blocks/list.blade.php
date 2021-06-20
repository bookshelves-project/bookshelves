<section>
    <h3 class="px-5 text-3xl font-semibold tracking-tight text-gray-900 font-handlee sm:text-4xl">
        Books
    </h3>
    @foreach ($data as $item)
        <a href="{{ route('api.catalog.books.show', ['author' => $item->meta->author, 'book' => $item->meta->slug]) }}"
            class="entity">
            <span class="entity__cover">
                <img src="{{ $item->picture->simple }}" alt="{{ $item->title }}">
            </span>
            <h2 class="entity__right">
                <div style="text-decoration: none !important;">
                    <i class="fas fa-download"></i> EPUB
                </div>
            </h2>
            <div style="text-decoration: none !important;">
                <div class="entity__center">
                    <div class="pb-3">
                        <h2 class="text-xl font-semibold">
                            {{ $item->title }}
                        </h2>
                    </div>
                    <div>
                        {!! $item->summary !!}
                    </div>
                    <div>
                        <i>Tags</i> : Action &amp; Adventure, Fiction, Historical, Romance
                    </div>
                    <div><i>Series</i> : {{ $item->serie->title }}, vol. {{ $item->volume }}</div>
                </div>
            </div>
        </a>
    @endforeach
</section>
