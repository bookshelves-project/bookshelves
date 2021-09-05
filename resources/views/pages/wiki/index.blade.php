@extends('layouts.wiki')

@section('wiki')
    <div class="text-sm italic">
        Last update: {{ $date }}
    </div>
    <main id="content" class="overflow-hidden max-w-full">
        {!! $content !!}
    </main>
@endsection
