@extends('layouts.default', ['title' => 'Roadmap', 'slideOver' => true])

@section('styles')
    <style>
        .prose-lg>ul>li> :first-child {
            margin: 0 !important;
        }

    </style>
@endsection

@section('content')
    <x-content :date="$date" :content="$content" />
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/blade/wiki.js') }}"></script>
@endsection
