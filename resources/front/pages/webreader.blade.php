@extends('front::layouts.app')

@section('title', 'Webreader')

@section('default')
    <p>
        With Webreader, you can read any eBook directly into your browser, here
        you can find a random eBook. If you want to read a specific eBook, just
        click on Webreader but with eye icon on any eBook detail page.
    </p>
    <img src="{{ asset('images/front/webreader/example.webp') }}"
        alt="">
    <i>An example with Webreader option at right</i>
    <x-button route="{{ route('catalog') }}">Try random book</x-button>
@endsection
