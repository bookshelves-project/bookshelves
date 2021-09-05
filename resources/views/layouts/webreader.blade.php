@extends('layouts.default', ['route' => 'webreader.index', 'slideover' => true])

@section('styles')
    <link rel="stylesheet" href="{{ mix('css/wiki.css') }}">
    <link rel="stylesheet" href="{{ mix('css/markdown.css') }}">
@endsection

@section('title', 'Webreader, to read eBooks in your browser')

@section('content')
    <div class="prose prose-lg dark:prose-light">
        @yield('webreader')
    </div>
@endsection
