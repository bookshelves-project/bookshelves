@extends('layouts.catalog')

@section('title', 'Search')

@section('content')
    <div class="relative px-4 pb-20 sm:px-6 lg:pb-28 lg:px-8">
        <div class="relative mx-auto max-w-7xl">
            <div class="mt-10">
                <form action="/api/catalog/search" method="GET">
                    <input type="search" name="q" class="block w-full max-w-xl mx-auto mt-1 rounded-md"
                        placeholder="Search by book title, by author name or by series title">
                    <button class="block px-3 py-2 mx-auto mt-3 text-3xl font-handlee text-center">
                        Launch search
                    </button>
                </form>
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
