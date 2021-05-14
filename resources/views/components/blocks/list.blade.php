<section>
    <h3 class="px-5 text-3xl font-semibold tracking-tight text-gray-900 font-handlee sm:text-4xl">
        Books
    </h3>
    <table cellpadding="20px" cellspacing="0" height="100%" width="100%" class="table-fixed">
        <tbody>
            @foreach ($data->chunk(2) as $chunk)
                <tr>
                    @foreach ($chunk as $item)
                        <td height="300px" valign="top">
                            <a
                                href="{{ route('api.opds.books.show', ['author' => $item->author, 'slug' => $item->slug]) }}">
                                <div style=" background-image: url({{ $item->picture->openGraph }})"
                                    class="h-32 bg-center bg-cover">
                                </div>
                                <div class="p-5">
                                    <div>
                                        Book by
                                        @foreach ($item->authors as $key => $author)
                                            {{ $author->name }}
                                            @if (sizeof($item->authors) !== $key + 1)
                                                <span>, </span>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="mt-2 text-2xl font-semibold">
                                        {{ $item->title }}
                                    </div>
                                    <div class="mt-3">
                                        {{ $item->summary }}
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
