@php
$latest_feed = $feeds[sizeof($feeds) - 1];
$list = [
    [
        'title' => 'OPDS project',
        'url' => 'https://opds.io/index.html',
        'text' => 'Easy to use, Open & Decentralized Content Distribution',
    ],
    [
        'title' => 'OPDS specifications',
        'url' => 'https://specs.opds.io',
        'text' => 'OPDS (Open Publication Distribution System) is a family of specifications dedicated to the distribution of digital publications.',
    ],
    [
        'title' => 'OPDS Test Catalog',
        'url' => 'https://feedbooks.github.io/opds-test-catalog',
        'text' => 'An OPDS catalog designed to test the features supported by OPDS clients',
    ],
    [
        'title' => 'Open Publication Distribution System',
        'url' => 'http://opds-validator.appspot.com',
        'text' => 'Unofficial Validator',
    ],
];
@endphp

@extends('front::layouts.app')

@section('default')
    <div
        class="prose prose-lg dark:prose-invert prose-headings:font-handlee prose-headings:font-medium mx-auto mt-6">
        <h1 class="mt-6 text-center">
            Use OPDS feed
        </h1>
        <div class="not-prose">
            @include('front::components.features')
        </div>
        <p>
            The Open Publication Distribution System (OPDS) format is a syndication
            format for electronic publications based on Atom and HTTP, with an
            <strong>OPDS
                feed
                you can get all books available on
                {{ config('app.name') }}</strong>. OPDS enable the
            aggregation,
            distribution, discovery, and acquisition of electronic publications.OPDS
            use
            existing or emergent open standards and conventions, with a priority on
            simplicity.
        </p>
        <section>
            <h2>
                Feeds by version
            </h2>
            <ul>
                @foreach ($feeds as $feed)
                    <li>
                        <a href="{{ $feed['route'] }}"
                            target="_blank"
                            rel="noopener noreferrer">
                            {{ $feed['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <x-button route="{{ $latest_feed['route'] }}">Latest feed</x-button>
        </section>
        <section>
            <h2>
                More about OPDS
            </h2>
            <ul>
                @foreach ($list as $item)
                    <li>
                        <a href="{{ $item['url'] }}"
                            target="_blank"
                            rel="noopener noreferrer">{{ $item['title'] }}</a>:
                        {{ $item['text'] }}
                    </li>
                @endforeach
            </ul>
        </section>
    </div>
@endsection
