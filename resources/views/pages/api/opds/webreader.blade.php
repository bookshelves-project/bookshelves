@extends('layouts.opds')

@section('title', 'WebReader')

@section('content')
    webreader
    <div id="area"></div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
    <script>
        var book = ePub("url/to/book/package.opf");
        var rendition = book.renderTo("area", {
            width: 600,
            height: 400
        });
        var displayed = rendition.display();

    </script>
@endsection
