@extends('layouts.opds')

@section('title', 'eReader')

@section('content')
    <div class="relative px-4 pt-6 pb-20 bg-gray-50 sm:px-6 lg:pt-12 lg:pb-28 lg:px-8">
        <div class="relative mx-auto max-w-7xl">
            <div class="text-center">
                <h2 class="text-3xl font-semibold tracking-tight text-gray-900 font-handlee sm:text-4xl">
                    Books
                </h2>
                <p class="max-w-2xl mx-auto mt-3 text-xl text-gray-500 sm:mt-4">
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsa libero labore natus atque, ducimus sed.
                </p>
            </div>
            <div class="grid gap-5 mx-auto mt-12 md:grid-cols-2 lg:grid-cols-3 lg:max-w-none">
                @foreach ($books as $book)
                    <div class="p-6 bg-white rounded-lg shadow-sm">
                        <div class="grid grid-cols-6">
                            <img class="object-cover w-12 h-12 col-span-1 rounded-full"
                                src="{{ $book->picture ? $book->picture->base : 'images/no-cover.webp' }}"
                                title="{{ $book->title }}" alt="{{ $book->title }}">
                            <div class="col-span-5">
                                @if ($book->serie)
                                    <p class="text-sm font-medium text-primary-600">
                                        {{ $book->serie?->title }}, vol. {{ $book->volume }}
                                    </p>
                                @endif
                                <p class="text-xl font-semibold text-gray-900">
                                    {{ $book->title }}
                                </p>
                            </div>
                        </div>
                        <div class="block mt-3 text-base text-gray-500 lg:h-16">
                            {{ $book->summary }}
                        </div>
                        <div class="mt-6">
                            <div class="text-sm font-medium text-gray-900">
                                @foreach ($book->authors as $key => $author)
                                    <p>
                                        {{ $author->name }}
                                    </p>
                                @endforeach
                            </div>
                            <div class="flex items-center space-x-1 text-sm text-gray-500">
                                @if ($book->publishDate)
                                    <time datetime="{{ $book->publishDate }}">
                                        {{ date('d M Y', strtotime($book->publishDate)) }}
                                    </time>
                                @endif
                                <span aria-hidden="true">
                                    &middot;
                                </span>
                                <img src="https://www.countryflags.io/{{ $book->language }}/flat/24.png"
                                    alt="{{ $book->language }}" />
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="container mt-16 max-w-7xl">
            {!! $links !!}
        </div>
    </div>

@endsection
