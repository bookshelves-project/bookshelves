@extends('layouts.catalog')

@section('title', 'Home')

@section('content')
    <div class="relative px-4 pb-20 sm:px-6 lg:pb-28 lg:px-8">
        <div class="relative mx-auto max-w-7xl">
            <div class="mt-10">
                <form action="/api/catalog/search" method="GET">
                    <input type="search" name="q" class="block w-full max-w-xl mx-auto mt-1 rounded-md"
                        placeholder="Search by book title, by author name or by series title">
                    <button class="block px-3 py-2 mx-auto mt-3 text-3xl font-semibold text-center">
                        Launch search
                    </button>
                </form>
            </div>
            <div class="">
                <div class="max-w-2xl mx-auto mt-3 text-xl text-gray-500 sm:mt-4">
                    <div>
                        Find now the book what you want from book's title, book's series or book's author. If you have an
                        author
                        or a series as result, you can't download books directly, you have to download one by one but don't
                        hesitate to tap on an author or a series, you will see list of books associated with, just tap on
                        the book that you want.
                    </div>
                </div>
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
