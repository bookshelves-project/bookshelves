@extends('layouts.wiki')

@section('wiki')
    <div class="text-sm italic">
        Last update: {{ $date }}
    </div>
    <main id="content" class="overflow-hidden max-w-full">
        {!! $content !!}
    </main>
@endsection

{{-- @extends('layouts.sidebar')

@section('title', 'Welcome')

@section('content')
    <div class="text-sm italic">
        Last update: {{ $date }}
    </div>
    <main id="content" class="prose prose-lg dark:prose-light mt-6">
        {!! $content !!}
    </main>
@endsection --}}
