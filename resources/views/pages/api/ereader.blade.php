@extends('layouts.default')

@section('title', 'eReader')

@section('content')
    <div class="relative px-4 pt-6 pb-20 bg-gray-50 sm:px-6 lg:pt-12 lg:pb-28 lg:px-8">
        <div class="relative mx-auto max-w-7xl">
            <div class="text-center">
                <h2 class="text-3xl font-semibold tracking-tight text-gray-900 font-handlee sm:text-4xl">
                    Search
                </h2>
                <p class="max-w-2xl mx-auto mt-3 text-xl text-gray-500 sm:mt-4">
                    Find now the book what you want from book's title, book's series or book's author.
                </p>
            </div>
            <div class="mt-10">
                <form action="/api/ereader/search" method="GET">
                    <input type="search" name="q" class="block w-full mt-1 rounded-md"
                        placeholder="Search by book title, by author name or by series title">

                    <button class="px-3 py-2 mt-3 font-semibold">
                        Search
                    </button>
                </form>
            </div>
            <div class="my-10"></div>
            @isset($authors)
                @include('components.blocks.list-search', [
                'title' => 'Authors',
                'type' => 'author',
                'data' => $authors
                ])
            @endisset
            @isset($series)
                @include('components.blocks.list-search', [
                'title' => 'Series',
                'type' => 'serie',
                'data' => $series
                ])
            @endisset
            @isset($books)
                @include('components.blocks.list-search', [
                'title' => 'Books',
                'type' => 'book',
                'data' => $books
                ])
            @endisset
        </div>
    </div>

@endsection
