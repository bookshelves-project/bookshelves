<section class="mb-40">
    <h3 class="text-3xl text-center pb-5 font-semibold tracking-tight text-gray-900 font-handlee sm:text-4xl mb-10">
        {{ $title }}
    </h3>
    @foreach ($data as $item)
        @php
            $item = json_decode(json_encode($item));
            $route = route('catalog.index');
            switch ($type) {
                case 'book':
                    $route = route('catalog.books.show', ['author' => $item->meta->author, 'book' => $item->meta->slug]);
                    break;
            
                case 'serie':
                    $route = route('catalog.series.show', ['author' => $item->meta->author, 'serie' => $item->meta->slug]);
                    break;
            
                case 'author':
                    $route = route('catalog.authors.show', ['character' => $item->first_char, 'author' => $item->meta->slug]);
                    break;
            
                default:
                    # code...
                    break;
            }
        @endphp
        <a href="{{ $route }}" class="entity">
            <span class="entity__cover">
                <img src="{{ $item->cover->simple }}" alt="{{ $item->title }}">
            </span>
            {{-- <h2 class="entity__right">
                <div style="text-decoration: none !important;">
                    <i class="fas fa-download"></i> EPUB
                </div>
            </h2> --}}
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
                    @isset($item->language)
                        <div>
                            <i>Language</i> : {{ $item->language }}
                        </div>
                    @endisset
                    @isset($item->serie)
                        <div>
                            <i>Serie</i> : {{ $item->serie->title }}, vol. {{ $item->volume }}
                        </div>
                    @endisset
                </div>
            </div>
        </a>
    @endforeach
</section>
