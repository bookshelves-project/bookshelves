@extends('layouts.webreader')

@section('title', $title)

@section('content')
    <div class="flex">
        <div id="epub_path" class="hidden">{{ $epub_path }}</div>
        <div class="mx-auto w-full md:max-w-3xl">

            <div class="flex h-screen">
                <div class="h-screen mt-auto w-full">
                    <div id="desc" class="dark:text-white mt-6 relative z-20">
                        <div class="flex">
                            <img src="{{ $book->cover->thumbnail }}" alt=""
                                class="object-cover w-20 h-20 rounded-md mx-auto">
                        </div>
                        <div class="font-quicksand text-center mt-3">
                            <h1 class="text-3xl">
                                {{ $book->title }}
                            </h1>
                            @isset($book->serie)
                                <h2>
                                    {{ $book->serie->title }}, vol.{{ $book->volume }}
                                </h2>
                            @endisset
                        </div>
                        <div class="text-center mt-3">
                            By
                            @foreach ($book->authors as $author)
                                {{ $author->name }}
                            @endforeach
                        </div>
                        <div class="italic mt-4">
                            {!! $book->description !!}
                        </div>
                        <div id="isReady" class="text-center mt-5 flex">
                            <div class="mx-auto flex items-center">
                                <x-loading />
                                <span class="ml-2">
                                    EPUB file ({{ $book->epub->size }}) is loading...
                                </span>
                            </div>
                        </div>
                    </div>
                    <div id="reader" class="h-full w-full"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ mix('assets/js/blade/webreader/index.js') }}"></script>
@endsection
