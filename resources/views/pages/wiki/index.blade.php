@extends('layouts.wiki')

@section('content')
    <div>
        <div class="text-lg font-semibold">
            Current versions
        </div>
        <ul>
            <li>{{ config('app.name') }}: {{ $appVersion }}</li>
            <li>Laravel: {{ $laravelVersion }}</li>
            <li>PHP: {{ $phpVersion }}</li>
        </ul>
    </div>
    <button id="sidebarBtn" type="button"
        class="inline-flex 2xl:hidden items-center px-4 py-2 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 z-50 fixed top-5 left-5 ">
        <span class="my-auto">
            {!! getIcon('menu', 30) !!}
        </span>
    </button>
    <div id="toc"
        class="-translate-x-full 2xl:translate-x-0 relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-indigo-700 transform transition duration-100">
    </div>
    <main id="content" class="prose prose-lg markdown-body mt-16">
        {!! $content !!}
    </main>
@endsection
