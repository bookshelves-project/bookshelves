@extends('layouts.base', ['route' => 'webreader.index'])

@section('styles')
    <link rel="stylesheet" href="{{ mix('css/wiki.css') }}">
    <link rel="stylesheet" href="{{ mix('css/markdown.css') }}">
@endsection

@section('title-template', 'Webreader')
@section('title-text', 'To read eBooks in your browser')

@section('content-base')
    @include('components.blocks.sidebar')
    <div class="prose prose-xl dark:prose-light markdown-body mx-auto hyphenate">
        @yield('content')
    </div>
@endsection
