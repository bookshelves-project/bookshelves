@extends('layouts.default', ['title' => 'Webreader, to read eBooks in your browser', 'route' => 'webreader.index',
'slideover' => true])

@section('styles')
    <link rel="stylesheet" href="{{ mix('css/wiki.css') }}">
    <link rel="stylesheet" href="{{ mix('css/markdown.css') }}">
@endsection

@section('content')
    <div class="prose prose-lg dark:prose-light">
        @yield('webreader')
    </div>
@endsection
