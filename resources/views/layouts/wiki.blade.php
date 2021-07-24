@extends('layouts.base')

@section('styles')
    <link rel="stylesheet" href="{{ mix('css/wiki.css') }}">
    <link rel="stylesheet" href="{{ mix('css/markdown.css') }}">
@endsection

{{-- @section('title', 'OPDS') --}}

@section('content-base')
    @include('components.blocks.sidebar')
    <div class="prose prose-xl dark:prose-light markdown-body mx-auto">
        @yield('content')
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('css/wiki.js') }}"></script>
@endsection
