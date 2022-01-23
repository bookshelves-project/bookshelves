@extends('layouts.catalog', ['title' => 'Series'])

@section('content')
    @if (sizeof($series))
        <x-catalog.entities :collection="$series" type="serie" />
    @endif
@endsection
