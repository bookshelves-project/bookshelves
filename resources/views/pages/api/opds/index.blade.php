@extends('layouts.opds')

@section('title', 'Catalog')

@section('content')
    <div class="relative px-4 pb-20 sm:px-6 lg:pb-28 lg:px-8">
        <div class="relative mx-auto max-w-7xl">
            <div class="text-center">
                Welcome on OPDS Catalog
            </div>
            <div class="mt-5">
                The Open Publication Distribution System (OPDS) Catalog format is a syndication format for electronic
                publications based on Atom and HTTP. OPDS Catalogs enable the aggregation, distribution, discovery, and
                acquisition of electronic publications.
            </div>
            <div class="mt-3">
                OPDS Catalogs use existing or emergent open standards and conventions, with a priority on simplicity.
            </div>
            <a href="https://opds.io/" class="block px-3 py-2 mx-auto mt-3 text-3xl font-semibold text-center">
                More about OPDS
            </a>
        </div>
    </div>

@endsection
