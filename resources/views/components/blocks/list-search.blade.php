<section>
    <h3 class="text-3xl text-center pb-5 font-semibold tracking-tight text-gray-900 font-handlee sm:text-4xl">
        {{ $title }}
    </h3>
    @foreach ($data as $item)
        @php
            $item = json_decode(json_encode($item));
            $route = route('api.catalog.index');
            switch ($type) {
                case 'book':
                    $route = route('api.catalog.books.show', ['author' => $item->meta->author, 'book' => $item->meta->slug]);
                    break;
            
                case 'serie':
                    $route = route('api.catalog.series.show', ['author' => $item->meta->author, 'serie' => $item->meta->slug]);
                    break;
            
                case 'author':
                    $route = route('api.catalog.authors.show', ['author' => $item->meta->slug]);
                    break;
            
                default:
                    # code...
                    break;
            }
        @endphp
        <a href="{{ $route }}" class="entity">
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
                    @if ($type !== 'author')
                        @isset($item->authors)
                            <div>
                                <i>Authors</i> : @foreach ($item->authors as $author)
                                    {{ $author->name }}
                                @endforeach
                            </div>
                        @endisset
                    @endif
                    <div>
                        <i>Tags</i> : Action &amp; Adventure, Fiction, Historical, Romance
                    </div>
                    {{-- <div><i>Series</i> : {{ $item->serie->title }}, vol. {{ $item->volume }}</div> --}}
                </div>
            </div>
        </a>
    @endforeach
</section>
