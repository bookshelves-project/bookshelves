@extends('layouts.webreader')

@section('webreader')
    <div>
        <div class="prose prose-lg dark:prose-light">
            {!! $content !!}
        </div>
        <div class="flex mt-6">
            <a href="{{ $route }}" class="mx-auto">
                <button type="button"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-base font-semibold rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Try random book now
                </button>
            </a>
        </div>
    </div>
@endsection
