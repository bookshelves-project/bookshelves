<x-catalog.layout>

<x-catalog.panel>
<div>
    {{ $book->title }}
    @if ($book->serie)
        in {{ $book->serie->title }}, vol. {{ $book->volume }}
    @endif
</div>
<div>
    Wrote by
    @foreach ($book->authors as $key => $author)
        {{ $author->name }}
        @if (sizeof($book->authors) !== $key + 1)
            <span>, </span>
        @endif
    @endforeach
</div>
@if (sizeof($book->tags) > 0)
    <div>
        <i>Tags</i> :
        @foreach ($book->tags as $tag)
            {{ $tag->name }}
        @endforeach
    </div>
@endif
</x-catalog.panel>

<x-catalog.table>
    {!! $book->description !!}
</x-catalog.table>

<a href="{{ $book->download->url }}">download</a>
<a href="{{ $book->download->url }}" target="_blank" rel="noopener noreferrer">download</a>
<a href="{{ $book->download->url }}" target="_blank" rel="noopener noreferrer" download="{{ $book->download->name }}">{{ $book->download->url }}</a>

@isset($book->download)
<x-catalog.button url="{{ $book->download->url }}" download>
    Download
</x-catalog.button>
@endisset

</x-catalog.layout>
