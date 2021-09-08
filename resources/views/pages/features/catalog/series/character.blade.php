@extends('layouts.catalog', ['title' => 'Series'])

@section('content')
    @if (sizeof($series))
        <x-catalog.entities :entities="$series" type="serie" />
    @endif
@endsection
