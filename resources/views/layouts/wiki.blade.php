@extends('layouts.default', ['title' => 'Wiki, to use Bookshelves as developer', 'slideOver' => true, 'links' =>
$links])

@section('styles')
    <link rel="stylesheet" href="{{ mix('css/blade/wiki.css') }}">
    <link rel="stylesheet" href="{{ mix('css/blade/markdown.css') }}">
@endsection

@section('content')
    <div class="markdown-body prose prose-lg dark:prose-light">
        @yield('wiki')
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('css/js/blade/wiki.js') }}"></script>
@endsection
