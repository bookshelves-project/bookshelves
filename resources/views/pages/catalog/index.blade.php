@extends('layouts.catalog')

{{-- @section('title', 'Home') --}}

@section('catalog')
    <div class="relative px-4 pb-20 sm:px-6 lg:pb-28 lg:px-8">
        <div class="relative mx-auto max-w-2xl">
            <div class="mt-10">
                @include('components.catalog.search')
            </div>
            <div class="___class_+?3___">
                <div class="mx-auto mt-3 text-xl text-gray-500 sm:mt-4 prose prose-lg">
                    <ul>
                        <li>
                            Find now the book what you want from book's title, book's series or book's author.
                        </li>
                        <li>
                            If you have an author or a series as result, you can't download books directly.
                        </li>
                        <li>
                            You have to download one by one but don't hesitate to tap on an author or a series, you will see
                            list of books associated with, just tap on
                            the book that you want.
                        </li>
                    </ul>
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
