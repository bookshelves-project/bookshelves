@extends('layouts.default')

@section('title', 'Welcome')

@section('content')
    <div class="relative flex justify-center min-h-screen bg-gray-100 items-top dark:bg-gray-900 sm:items-center sm:pt-0">
        <a href="{{ route('api.index') }}"
            class="block max-w-6xl p-5 mx-auto transition-colors duration-100 rounded-md sm:px-6 lg:px-8 hover:bg-gray-200">
            <div class="flex justify-center mt-4 font-handlee sm:items-center sm:justify-between">
                <div>
                    <div class="text-6xl">
                        Bookshelves
                    </div>
                    <div class="mt-1 ml-4 text-sm text-center text-gray-500 sm:text-right sm:ml-0">
                        Laravel v{{ $laravelVersion }} (PHP v{{ $phpVersion }})
                    </div>
                </div>
            </div>
        </a>
    </div>
@endsection
