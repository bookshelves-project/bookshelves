@extends('layouts.webreader')

@section('title', $title)

@section('style')
    <style>
        main {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .content {
            flex: 1 0 auto;
        }

        .page-number {
            flex-shrink: 0;
        }

    </style>
@endsection

@section('content')
    <div id="top"></div>
    <div class="fixed top-0 flex lg:block right-0 bg-gray-400 bg-opacity-75 text-white">
        <a href="{{ route('webreader.cover', ['author' => request()->author, 'book' => request()->book]) }}"
            class="hover:bg-gray-500 transition-colors duration-100 block p-3">
            <span class="my-auto">
                {!! getIcon('home', 30) !!}
            </span>
        </a>
        @if ($prev)
            <a href="{{ $prev }}" class="hover:bg-gray-500 transition-colors duration-100 block p-3">
                <span class="my-auto">
                    {!! getIcon('arrow-left', 30) !!}
                </span>
            </a>
        @endif
        @if ($next)
            <a href="{{ $next }}" class="hover:bg-gray-500 transition-colors duration-100 block p-3">
                <span class="my-auto">
                    {!! getIcon('arrow-right', 30) !!}
                </span>
            </a>
        @endif
        <a href="{{ $last }}" class="hover:bg-gray-500 transition-colors duration-100 block p-3">
            <span class="my-auto">
                {!! getIcon('arrow-double-right', 30) !!}
            </span>
        </a>
    </div>
    <div class="fixed bottom-0 right-0">
        <a href="#top" class="hover:bg-gray-400 bg-gray-300 transition-colors duration-100 block p-3">
            <span class="my-auto">
                {!! getIcon('arrow-top', 30) !!}
            </span>
        </a>
    </div>
    <main class="text-justify px-3 py-16 prose prose-lg mx-auto min-h-screen">
        <section class="content">
            {!! $current_page_content !!}
        </section>
        <div class="page-number">
            <div class="text-center font-semibold">
                Page {{ $page }}
            </div>
        </div>
    </main>
@endsection
