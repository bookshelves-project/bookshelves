@extends('layouts.default', ['title' => 'Wiki, for developers', 'slideOver' => true, 'links' =>
$links])

@section('content')
    @if (config('app.name') !== 'Bookshelves')
        <div class="mb-5 italic">
            "{{ config('app.name') }}" is the current application and "Bookshelves" is the name of open-source
            project
        </div>
    @endif
    <x-content :date="$date" :content="$content">
        <x-slot name="title">
            <h1>
                {{ ucfirst($page) }}
            </h1>
        </x-slot>
    </x-content>
@endsection
