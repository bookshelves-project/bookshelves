@extends('layouts.default', ['route' => 'opds.index', 'slideover' => true])

@section('styles')
    <link rel="stylesheet" href="{{ mix('css/wiki.css') }}">
    <link rel="stylesheet" href="{{ mix('css/markdown.css') }}">
@endsection

@section('title', 'OPDS · Open Publication Distibution System')

@section('content')
    @yield('opds')
@endsection
