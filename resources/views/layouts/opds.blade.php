@extends('layouts.base', ['route' => 'opds.index', 'slideover' => true])

@section('styles')
    <link rel="stylesheet" href="{{ mix('css/wiki.css') }}">
    <link rel="stylesheet" href="{{ mix('css/markdown.css') }}">
@endsection

@section('title-template', 'OPDS')
@section('title-text', 'Open Publication Distibution System')

@section('content-markdown')
    @yield('content')
@endsection
