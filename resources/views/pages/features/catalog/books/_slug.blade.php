@extends('layouts.catalog', ['title' => $book->title])

@section('content')
    <x-catalog.back-button />
    <div class="relative px-4 pt-6 pb-20 bg-gray-50 sm:px-6 lg:pt-12 lg:pb-28 lg:px-8">
        <div class="relative mx-auto max-w-7xl">
            <a href="{{ url()->previous() }}" class="block px-3 py-2 mb-6 font-semibold">
                Back
            </a>
            <article class="entity">
                <span class="entity__cover">
                    <img src="{{ $book->cover->simple }}" alt="{{ $book->title }}">
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
                                {{ $book->title }}
                            </h2>
                        </div>
                        @if ($book->serie)
                            <div class="mt-6 text-lg font-semibold">
                                {{ $book->serie->title }}, vol. {{ $book->volume }}
                            </div>
                        @endif
                        <div>
                            Wrote by
                            @foreach ($book->authors as $key => $author)
                                {{ $author->name }}
                                @if (sizeof($book->authors) !== $key + 1)
                                    <span>, </span>
                                @endif
                            @endforeach
                        </div>
                        <div>
                            {!! $book->summary !!}
                        </div>
                        <div>
                            <i>Tags</i> : Action &amp; Adventure, Fiction, Historical, Romance
                        </div>
                        @if ($book->serie)
                            <div><i>Series</i> : {{ $book->serie->title }}, vol. {{ $book->volume }}</div>
                        @endif
                    </div>
                </div>
            </article>
            <a href="{{ $book->epub->download }}" class="block py-2 mt-6 text-3xl font-semibold">
                Download ({{ $book->epub->size }})
            </a>
        </div>
    </div>

@endsection