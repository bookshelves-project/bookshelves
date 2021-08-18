@extends('layouts.base', ['route' => 'webreader.index', 'slideover' => true])

@section('styles')
    <link rel="stylesheet" href="{{ mix('css/wiki.css') }}">
    <link rel="stylesheet" href="{{ mix('css/markdown.css') }}">
@endsection

@section('title-template', 'Webreader')
@section('title-text', 'To read eBooks in your browser')

@section('content-base')
    @yield('content')
@endsection
