@extends('layouts.webreader')

@section('title', $title)

@section('content')
    <div class="h-screen flex">
        <a href="{{ $open }}" class="m-auto p-5">
            <img src="{{ $cover }}" alt="" class="mx-auto h-96 max-w-full object-cover shadow-md rounded-sm">
            <div>
                <div class="text-center mt-6 text-3xl font-semibold">
                    {{ $book->title }}
                </div>
                <div class="text-center mt-3 text-xl">
                    @if ($book->serie) {{ $book->serie->title }}, vol.
                        {{ $book->volume }} @endif by {{ $book->authors_names }}
                </div>
            </div>
            <div class="mx-auto w-max mt-6">
                <button type="button"
                    class="inline-flex items-center px-4 py-2 border border-transparent font-semibold text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Open eBook
                </button>
            </div>
        </a>
    </div>
@endsection
