@extends('layouts.catalog', ['title' => 'Authors'])

@section('content')
    @if (sizeof($authors))
        <x-catalog.entities :entities="$authors" type="author" />
    @endif
@endsection
