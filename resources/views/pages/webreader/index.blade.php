@extends('layouts.webreader')

@section('content')
    <div class="h-screen">
        @include('components.blocks.hero', ['route' => null, 'title' => 'Webreader', 'text' => 'To
        read
        eBooks in your browser'])
        <div class="prose prose-lg mx-auto mt-16">
            With Webreader, you can read any {{ config('app.name') }} eBook directly into your browser, here you can find
            a random eBook (reload page if you want to try another).
            <div>
                <div class="text-center mt-6 text-3xl font-semibold">
                    {{ $random_book->title }}
                </div>
                <div class="text-center mt-3 text-xl">
                    @if ($random_book->serie) {{ $random_book->serie->title }}, vol.
                        {{ $random_book->volume }} @endif by {{ $random_book->authors_names }}
                </div>
            </div>
            <div class="flex mt-6">
                <a href="{{ $route }}" target="_blank" rel="noopener noreferrer" class="mx-auto">
                    <button type="button"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-base font-semibold rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Try it now
                    </button>
                </a>
            </div>
        </div>
    </div>
@endsection
