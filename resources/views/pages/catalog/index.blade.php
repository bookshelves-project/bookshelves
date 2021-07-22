@extends('layouts.catalog')

{{-- @section('title', 'Home') --}}

@section('content')
    <div class="relative px-4 pb-20 sm:px-6 lg:pb-28 lg:px-8">
        <div class="relative mx-auto max-w-2xl">
            <div class="mt-10">
                <form action="/api/catalog/search" method="GET">
                    <article class="entity" style="min-height: 0; border: none;">
                        <h2 class="entity__right">
                            <button type="submit" class="block mx-auto text-2xl text-center">
                                Search
                            </button>
                        </h2>
                        <div style="text-decoration: none !important;">
                            <div class="entity__center" style="margin: 0 120px 4px 0;">
                                <input type="search" name="q" class="block w-full mx-auto mt-1"
                                    placeholder="Search by book title, by author name or by series title">
                            </div>
                        </div>
                    </article>
                </form>
            </div>
            <div class="">
                <div class="mx-auto mt-3 text-xl text-gray-500 sm:mt-4">
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
