@extends('layouts.opds')

@section('title', 'eReader')

@section('content')
    <div class="relative px-4 pt-6 pb-20 bg-gray-50 sm:px-6 lg:pt-12 lg:pb-28 lg:px-8">
        <div class="relative mx-auto max-w-7xl">
            <a href="{{ url()->previous() }}" class="block px-3 py-2 mb-6 font-semibold">
                Back
            </a>
            <div>
                <div style=" background-image: url({{ $serie->picture->openGraph }})" class="h-32 bg-center bg-cover">
                </div>
                <h2 class="mt-6 text-3xl font-semibold">
                    {{ $serie->title }}
                </h2>
                <div>
                    Wrote by
                    @foreach ($serie->authors as $key => $author)
                        {{ $author->name }}
                        @if (sizeof($serie->authors) !== $key + 1)
                            <span>, </span>
                        @endif
                    @endforeach
                </div>
                <div>
                    {{ $serie->size }}
                </div>
                <div class="mt-5">
                    {!! $serie->description !!}
                </div>
                @isset($serie->books)
                    <div class="mt-8">
                        @include('components.blocks.list', [
                        'data' => collect($serie->books)
                        ])
                    </div>
                @endisset
            </div>
        </div>
    </div>

@endsection
