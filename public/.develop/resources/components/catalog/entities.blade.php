@if (sizeof($entities))
    @foreach (array_chunk($entities, 3) as $chunk)
        <div class="u-row"
            style="Margin: 0 auto;min-width: 320px;max-width: 800px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
            <div
                style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
                @foreach ($chunk as $item)
                    @php
                        $route = route('catalog');
                        switch ($type) {
                            case 'book':
                                $route = route('catalog.books.show', [
                                    'author' => $item->meta?->author,
                                    'book' => $item->meta?->slug,
                                ]);
                                break;
                        
                            case 'serie':
                                $route = route('catalog.series.show', [
                                    'author' => $item->meta?->author,
                                    'serie' => $item->meta?->slug,
                                ]);
                                break;
                        
                            case 'author':
                                $route = route('catalog.authors.show', [
                                    'character' => $item->first_char,
                                    'author' => $item->meta?->slug,
                                ]);
                                break;
                        
                            default:
                                # code...
                                break;
                        }
                    @endphp
                    <a href="{{ $route }}"
                        class="u-col u-col-33p33"
                        style="max-width: 320px;min-width: 167px;display: table-cell;vertical-align: top;">
                        <div style="width: 100% !important;">
                            <div
                                style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
                                <table
                                    style="font-family:arial,helvetica,sans-serif;"
                                    role="presentation"
                                    cellpadding="0"
                                    cellspacing="0"
                                    width="100%"
                                    border="0">
                                    <tbody>
                                        <tr>
                                            <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;"
                                                align="left">

                                                <div
                                                    style="line-height: 140%; text-align: center; word-wrap: break-word; width: 200px">
                                                    <img src="{{ $item->media_social }}"
                                                        alt="{{ $item->title }}"
                                                        style="height: 200px; width: 200px; object-fit: cover">
                                                    <h2
                                                        style="font-size: 14px; line-height: 140%;">
                                                        {{ $item->title }}
                                                    </h2>
                                                    @if ($type !== 'author')
                                                        @isset($item->authors)
                                                            <div>
                                                                <i>Authors</i> :
                                                                @foreach ($item->authors as $author)
                                                                    {{ $author->name }}
                                                                @endforeach
                                                            </div>
                                                        @endisset
                                                    @endif
                                                    @isset($item->language)
                                                        <div>
                                                            <i>Language</i> :
                                                            {{ $item->language?->name }}
                                                        </div>
                                                    @endisset
                                                    @isset($item->serie)
                                                        <div>
                                                            <i>Serie</i> :
                                                            {{ $item->serie }},
                                                            vol. {{ $item->volume }}
                                                        </div>
                                                    @endisset
                                                </div>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
@endif
