@extends('layouts.opds')

{{-- @section('title', 'Catalog') --}}

@section('navbar')
    @php
    $nav = [
        [
            'name' => 'v1.2',
            'route' => route('opds', ['version' => 'v1.2']),
        ],
        [
            'name' => 'v1.2',
            'route' => route('catalog.index'),
        ],
    ];
    @endphp
    <nav>
        <table class="mx-auto" cellpadding="20px" cellspacing="0" height="100%" class="table-fixed">
            <tbody>
                <tr>
                    <td class="text-xl font-semibold">
                        <a href="{{ route('opds', ['version' => 'v1.2']) }}">
                            v1.2
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </nav>
@endsection

@section('content')
    <div class="relative px-4 pb-20 sm:px-6 lg:pb-28 lg:px-8">
        <div class="relative mx-auto max-w-7xl">
            <div class="mt-5">
                The Open Publication Distribution System (OPDS) format is a syndication format for electronic
                publications based on Atom and HTTP. OPDS enable the aggregation, distribution, discovery, and
                acquisition of electronic publications.OPDS use existing or emergent open standards and
                conventions, with a priority on simplicity.
            </div>
            <a href="https://opds.io/" target="_blank" rel="noopener noreferrer"
                class="block px-3 py-2 mx-auto mt-3 text-xl font-semibold text-center">
                More about OPDS
            </a>
        </div>
    </div>
@endsection
