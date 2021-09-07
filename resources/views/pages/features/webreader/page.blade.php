@extends('layouts.webreader')

@section('title', $title)

@section('content')
    <div class="fixed transform -translate-x-1/2 top-0 left-1/2 flex items-center bg-gray-200 bg-opacity-75 z-50 text-white">
        <x-webreader.navigation :route="$first" icon="arrow-double-left" />
        <x-webreader.navigation :route="$prev" icon="arrow-left" />
        <x-webreader.navigation
            :route="route('features.webreader.cover', ['author' => request()->author, 'book' => request()->book])"
            icon="home" />
        <x-webreader.navigation :route="$next" icon="arrow-right" />
        <x-webreader.navigation :route="$last" icon="arrow-double-right" />
    </div>
    <div class="fixed top-0 right-0 bg-gray-300 text-gray-800 dark:bg-gray-700 dark:text-gray-300 bg-opacity-40">
        <x-switch-color-mode />
    </div>
    <div class="flex w-full">
        <main
            class="text-justify px-3 pb-3 prose prose-lg dark:prose-light mx-auto min-h-screen content-wrapper prose prose-lg dark:prose-light">
            <section class="content content-content pt-14">
                {!! $current_page_content !!}
            </section>
            <div class="page-number content-footer">
                <div class="text-center font-semibold">
                    Page {{ $page }}
                </div>
                <div class="text-center">
                    <div>
                        {{ $bookTitle }}
                    </div>
                    <div>
                        {{ $bookSerie }}
                    </div>
                    <div>
                        {{ $bookAuthors }}
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
