<style>
    .entity {
        clear: both;
        min-height: 90px;
        position: relative;
        border-bottom: 1px solid black;
        display: block;
        padding-bottom: 1rem;
        margin-bottom: 1rem;
    }

    .entity__cover {
        float: left;
        margin: 4px 10px 4px 4px;
        width: 60px;
        height: 100%;
        position: absolute;
    }

    .entity__right {
        float: right;
        line-height: 40px;
        text-align: right;
        margin: 6px;
    }

    .entity__center {
        margin: 0px 0px 4px 75px;
    }

</style>
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
        <article class="entity">
            <a href="{{ $route }}">
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
                            <div>
                                <i>Authors</i> : {{ $item->author }}
                            </div>
                        @endif
                        <div>
                            <i>Tags</i> : Action &amp; Adventure, Fiction, Historical, Romance
                        </div>
                        <div><i>Series</i> : D'Artagnan Romances (1.0)</div>
                    </div>
                </div>
            </a>
        </article>
    @endforeach
</section>
