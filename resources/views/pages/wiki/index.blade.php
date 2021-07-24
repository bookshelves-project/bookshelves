@extends('layouts.wiki')

@section('content')
    <div class="text-xl italic">
        Last update: {{ $lastModified }}
    </div>
    <main id="content">
        {!! $content !!}
    </main>
@endsection
