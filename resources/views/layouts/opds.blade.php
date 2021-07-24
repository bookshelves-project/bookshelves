@extends('layouts.base', ['route' => 'opds.index'])

@section('styles')
    <link rel="stylesheet" href="{{ mix('css/wiki.css') }}">
    <link rel="stylesheet" href="{{ mix('css/markdown.css') }}">
@endsection

@section('title-template', 'OPDS')
@section('title-text', 'Open Publication Distibution System')

@section('content-base')
    @include('components.blocks.sidebar')
    <div class="prose prose-xl dark:prose-light markdown-body mx-auto hyphenate">
        @yield('content')
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('css/wiki.js') }}"></script>
@endsection
