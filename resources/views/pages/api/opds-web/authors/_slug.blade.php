@extends('layouts.opds-web')

@section('title', $author->name)

@section('content')
    <div class="relative px-4 pt-6 pb-20 bg-gray-50 sm:px-6 lg:pt-12 lg:pb-28 lg:px-8">
        <div class="relative mx-auto max-w-7xl">
            <a href="{{ url()->previous() }}" class="block px-3 py-2 mb-6 font-semibold">
                Back
            </a>
            <div>
                <div style=" background-image: url({{ $author->picture->openGraph }})" class="h-32 bg-center bg-cover">
                </div>
                <h2 class="mt-6 text-3xl font-semibold">
                    {{ $author->name }}
                </h2>
                <div>
                    {{ $author->size }}
                </div>
                <div class="mt-5">
                    {!! $author->description !!}
                </div>
                @isset($author->books)
                    <div class="mt-8">
                        @include('components.blocks.list', [
                        'data' => collect($author->books)
                        ])
                    </div>
                @endisset
            </div>
        </div>
    </div>

@endsection
