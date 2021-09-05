@extends('layouts.default', ['title' => 'OPDS · Open Publication Distibution System', 'route' => 'opds.index',
'slideover' => true])

@section('styles')
    <link rel="stylesheet" href="{{ mix('css/wiki.css') }}">
    <link rel="stylesheet" href="{{ mix('css/markdown.css') }}">
@endsection

@section('content')
    @yield('opds')
@endsection
