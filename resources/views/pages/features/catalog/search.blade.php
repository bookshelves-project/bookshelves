@extends('layouts.catalog', ['title' => 'Catalog'])

@section('content')
    @isset($authors)
        <x-catalog.entities type="author" :entities="$authors" />
    @endisset
    @isset($series)
        <x-catalog.entities type="serie" :entities="$series" />
    @endisset
    @isset($books)
        <x-catalog.entities type="book" :entities="$books" />
    @endisset
@endsection
