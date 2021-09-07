@extends('layouts.default', ['title' => 'Wiki, to use Bookshelves as developer', 'slideOver' => true, 'links' =>
$links])

@section('content')
    <x-content :date="$date" :content="$content">
        <x-slot name="title">
            <h1>
                {{ ucfirst($page) }}
            </h1>
        </x-slot>
    </x-content>
@endsection
