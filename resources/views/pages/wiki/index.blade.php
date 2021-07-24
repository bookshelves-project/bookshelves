@extends('layouts.wiki')

@section('content')
    <main id="content" class="prose prose-lg markdown-body mt-16">
        {!! $content !!}
    </main>
@endsection
