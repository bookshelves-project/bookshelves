@extends('layouts.base', ['route' => 'wiki.index', 'sidebar' => true, 'slideover' => true, 'links' => $links])

@section('styles')
    <link rel="stylesheet" href="{{ mix('css/wiki.css') }}">
    <link rel="stylesheet" href="{{ mix('css/markdown.css') }}">
@endsection

@section('title-template', 'Wiki')
@section('title-text', 'Installation and usage')

@section('content-markdown')
    @yield('content')
@endsection

@section('scripts')
    <script src="{{ asset('css/js/blade/wiki.js') }}"></script>
@endsection
