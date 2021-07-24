@extends('layouts.base', ['route' => 'wiki.index'])

@section('styles')
    <link rel="stylesheet" href="{{ mix('css/wiki.css') }}">
    <link rel="stylesheet" href="{{ mix('css/markdown.css') }}">
@endsection

@section('title-template', 'Wiki')
@section('title-text', 'Installation and usage')

@section('content-base')
    @include('components.blocks.sidebar')
    <div class="prose prose-xl dark:prose-light markdown-body mx-auto hyphenate">
        @yield('content')
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('css/wiki.js') }}"></script>
@endsection
