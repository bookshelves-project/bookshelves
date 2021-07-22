@extends('layouts.wiki')

{{-- @section('title', 'Home') --}}

@section('content')
    <x-markdown theme="github-dark">
        {{ $content }}
    </x-markdown>
@endsection
