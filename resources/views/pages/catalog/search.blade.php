@extends('layouts.catalog')

@section('title', 'Search')

@section('catalog')
    <div class="relative px-4 pb-20 sm:px-6 lg:pb-28 lg:px-8">
        <div class="relative mx-auto max-w-7xl">
            <div class="mt-10">
                @include('components.catalog.search')
            </div>

            <div class="my-10"></div>
            @isset($authors)
                @if (sizeof($authors))
                    @include('components.blocks.list-search', [
                    'title' => 'Authors',
                    'type' => 'author',
                    'data' => $authors
                    ])
                @endif
                @if (sizeof($series))
                    @include('components.blocks.list-search', [
                    'title' => 'Series',
                    'type' => 'serie',
                    'data' => $series
                    ])
                @endif
                @if (sizeof($books))
                    @include('components.blocks.list-search', [
                    'title' => 'Books',
                    'type' => 'book',
                    'data' => $books
                    ])
                @endif
            @endisset
        </div>
    </div>

@endsection
