@extends('layouts.wiki')

{{-- @section('title', 'Home') --}}

@section('content')
    <div>
        <div class="text-lg font-semibold">
            Current versions
        </div>
        <ul>
            <li>{{ config('app.name') }}: {{ $appVersion }}</li>
            <li>Laravel: {{ $laravelVersion }}</li>
            <li>PHP: {{ $phpVersion }}</li>
        </ul>
    </div>
    <x-markdown theme="github-dark">
        {{ $content }}
    </x-markdown>
@endsection
