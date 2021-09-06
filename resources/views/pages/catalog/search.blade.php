@extends('layouts.catalog')

@section('title', 'Search')

@section('catalog')
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
@endsection
