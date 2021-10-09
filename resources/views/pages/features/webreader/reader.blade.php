@extends('layouts.webreader')

@section('title', $title)

@section('content')
    <div class="flex">
        <div id="epub_path" class="hidden">{{ $epub_path }}</div>
        <div class="mx-auto w-full md:max-w-3xl">
            <div id="reader" class="h-screen w-full"></div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ mix('assets/js/blade/webreader/index.js') }}"></script>
@endsection
