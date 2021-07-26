@extends('layouts.base', ['route' => 'wiki.index'])

@section('styles')
    <link rel="stylesheet" href="{{ mix('css/wiki.css') }}">
    <link rel="stylesheet" href="{{ mix('css/markdown.css') }}">
@endsection

@section('title-template', 'Wiki')
@section('title-text', 'Installation and usage')

@section('content-markdown')
    {{ $device }}
    @yield('content')
@endsection

@section('scripts')
    <script src="{{ asset('css/wiki.js') }}"></script>
@endsection
