@extends('layouts.catalog', ['title' => 'Authors'])

@section('content')
    @if (sizeof($authors))
        <x-catalog.entities :collection="$authors" type="author" />
    @endif
@endsection
