@extends('layouts.catalog')

@section('title', $author->name)

@section('content')
    <div class="relative px-4 pt-6 pb-20 bg-gray-50 sm:px-6 lg:pt-12 lg:pb-28 lg:px-8">
        <div class="relative mx-auto max-w-7xl">
            <a href="{{ url()->previous() }}" class="block px-3 py-2 mb-6 font-semibold">
                Back
            </a>
            <article class="entity">
                <span class="entity__cover">
                    <img src="{{ $author->cover->simple }}" alt="{{ $author->name }}">
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
                                {{ $author->name }}
                            </h2>
                        </div>
                        <div>
                            {!! $author->description !!}
                        </div>
                        <div>
                            <i>Tags</i> : Action &amp; Adventure, Fiction, Historical, Romance
                        </div>
                    </div>
                </div>
            </article>
            @isset($books)
                <div class="mt-8">
                    @include('components.blocks.list', [
                    'data' => collect($books)
                    ])
                </div>
            @endisset
        </div>
    </div>

@endsection
