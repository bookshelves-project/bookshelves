@extends('layouts.opds-web')

@section('title', 'Series')

@section('content')
    <div class="relative px-4 pt-6 pb-20 bg-gray-50 sm:px-6 lg:pt-12 lg:pb-28 lg:px-8">
        <div class="relative mx-auto max-w-7xl">
            @if (sizeof($authors))
                @include('components.blocks.list-search', [
                'title' => 'Authors',
                'type' => 'author',
                'data' => $authors
                ])
            @endif
        </div>
    </div>

@endsection
