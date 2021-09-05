@extends('layouts.webreader-page')

@section('title', $title)

@section('content')
    <div class="fixed transform -translate-x-1/2 top-0 left-1/2 flex items-center bg-gray-200 bg-opacity-75 z-50 text-white">
        <a href="{{ $first }}"
            class="hover:bg-gray-300 transition-colors duration-100 block p-3 rotate-180 transform">
            <span class="my-auto">
                <x-icon-arrow-double-right class="w-6 h-6" />
            </span>
        </a>
        <a href="{{ $prev }}" class="hover:bg-gray-300 transition-colors duration-100 block p-3">
            <span class="my-auto">
                <x-icon-arrow-left class="w-6 h-6" />
            </span>
        </a>
        <a href="{{ route('webreader.cover', ['author' => request()->author, 'book' => request()->book]) }}"
            class="hover:bg-gray-300 transition-colors duration-100 block p-3">
            <span class="my-auto">
                <x-icon-home class="w-6 h-6" />
            </span>
        </a>
        <a href="{{ $next }}" class="hover:bg-gray-300 transition-colors duration-100 block p-3">
            <span class="my-auto">
                <x-icon-arrow-right class="w-6 h-6" />
            </span>
        </a>
        <a href="{{ $last }}" class="hover:bg-gray-300 transition-colors duration-100 block p-3">
            <span class="my-auto">
                <x-icon-arrow-double-right class="w-6 h-6" />
            </span>
        </a>
    </div>
    <div class="flex w-full">
        <main
            class="text-justify px-3 pb-3 prose prose-lg mx-auto min-h-screen content-wrapper prose prose-lg dark:prose-light">
            <section class="content content-content pt-14">
                {!! $current_page_content !!}
            </section>
            <div class="page-number content-footer">
                <div class="text-center">
                    @yield('title')
                </div>
                <div class="text-center font-semibold">
                    Page {{ $page }}
                </div>
            </div>
        </main>
    </div>
@endsection
