@extends('layouts.default')


@section('content')
    <div class="relative flex justify-center min-h-screen bg-white items-top dark:bg-gray-900 sm:items-center sm:pt-0">
        <div>
            <div class="block max-w-6xl p-5 mx-auto sm:px-6 lg:px-8 ">
                <div class="flex justify-center mt-4 font-handlee sm:items-center sm:justify-between">
                    <div class="mx-auto">
                        <div class="lg:text-6xl text-xl">
                            {{ config('app.name') }}
                        </div>
                        <div class="mt-1 ml-4 text-sm text-center text-gray-500 sm:text-right sm:ml-0">
                            Laravel v{{ $laravelVersion }} (PHP v{{ $phpVersion }})
                        </div>
                    </div>
                </div>
            </div>
            <ul class="flex mt-6">
                <a href="docs" target="_blank" rel="noopener noreferrer"
                    class="mx-4 hover:bg-gray-200 transition-colors duration-100 block rounded-md p-2">
                    API documentation
                </a>
                <a href="{{ route('wiki.index') }}"
                    class="mx-4 hover:bg-gray-200 transition-colors duration-100 block rounded-md p-2">
                    Wiki
                </a>
                <a href="{{ route('opds.index') }}"
                    class="mx-4 hover:bg-gray-200 transition-colors duration-100 block rounded-md p-2">
                    OPDS
                </a>
                <a href="{{ route('catalog.index') }}"
                    class="mx-4 hover:bg-gray-200 transition-colors duration-100 block rounded-md p-2">
                    Catalog
                </a>
                <a href="{{ route('webreader.index') }}"
                    class="mx-4 hover:bg-gray-200 transition-colors duration-100 block rounded-md p-2">
                    Webreader
                </a>
            </ul>
        </div>
    </div>
@endsection
