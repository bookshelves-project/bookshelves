<section class="my-20">
    <h3 class="px-5 text-3xl font-semibold tracking-tight text-gray-900 font-handlee sm:text-4xl">
        {{ $title }}
    </h3>
    <table cellpadding="20px" cellspacing="0" height="100%" width="100%" class="table-fixed">
        <tbody>
            @foreach ($data->chunk(2) as $chunk)
                <tr>
                    @foreach ($chunk as $item)
                        @php
                            $item = json_decode(json_encode($item));
                            $route = route('api.opds-web.index');
                            switch ($type) {
                                case 'book':
                                    $route = route('api.opds-web.books.show', ['author' => $item->meta->author, 'slug' => $item->meta->slug]);
                                    break;
                            
                                case 'serie':
                                    $route = route('api.opds-web.series.show', ['author' => $item->meta->author, 'slug' => $item->meta->slug]);
                                    break;
                            
                                case 'author':
                                    $route = route('api.opds-web.authors.show', ['slug' => $item->meta->slug]);
                                    break;
                            
                                default:
                                    # code...
                                    break;
                            }
                        @endphp
                        <td height="300px" valign="top">
                            <a href="{{ $route }}">
                                <div style=" background-image: url({{ $item->picture->openGraph }})"
                                    class="h-32 bg-center bg-cover">
                                </div>
                                <div class="p-5">
                                    <div>
                                        {{ ucfirst($item->meta->entity) }}
                                        @if ($type !== 'author')
                                            by {{ $item->author }}
                                        @endif
                                    </div>
                                    <div class="mt-2 text-2xl font-semibold">
                                        {{ $item->title }}
                                    </div>
                                    <div class="mt-3">
                                        {{ $item->text }}
                                    </div>
                                </div>
                            </a>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</section>
