@extends('layouts.opds')

@section('title', $book->title)

@section('content')
    <div class="relative px-4 pt-6 pb-20 bg-gray-50 sm:px-6 lg:pt-12 lg:pb-28 lg:px-8">
        <div class="relative mx-auto max-w-7xl">
            <a href="{{ url()->previous() }}" class="block px-3 py-2 mb-6 font-semibold">
                Back
            </a>
            <div>
                <div style=" background-image: url({{ $book->picture->og }})" class="h-32 bg-center bg-cover">
                </div>
                <h2 class="mt-6 text-3xl font-semibold">
                    {{ $book->title }}
                </h2>
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
                <div class="mt-5">
                    {!! $book->description !!}
                </div>
                <a href="{{ $book->epub->download }}" class="block py-2 mt-6 text-3xl font-semibold">
                    Download ({{ $book->epub->size }})
                </a>
            </div>
        </div>
    </div>

@endsection
