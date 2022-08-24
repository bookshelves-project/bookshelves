@extends('front::layouts.app')

@section('default')
    <div
        class="prose prose-lg dark:prose-invert prose-headings:font-handlee prose-headings:font-medium mx-auto mt-6">
        <h1 class="mt-6 text-center">
            Use Webreader
        </h1>
        <div class="not-prose">
            @include('front::components.features')
        </div>
        <p>
            With Webreader, you can read any eBook directly into your browser, here
            you can find a random eBook. If you want to read a specific eBook, just
            click on Webreader but with eye icon on any eBook detail page.
        </p>
        <img src="{{ asset('images/front/webreader/example.webp') }}"
            alt="">
        <i>An example with Webreader option at right</i>
        <x-button route="{{ route('front.catalog') }}">Try random book</x-button>
    </div>
@endsection
