@extends('layouts.opds')

{{-- @section('title', 'Catalog') --}}

@section('navbar')
    @php
    $nav = [
        [
            'name' => 'v1.2',
            'route' => route('opds.feed', ['version' => 'v1.2']),
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
                        <a href="{{ route('opds.feed', ['version' => 'v1.2']) }}">
                            v1.2
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </nav>
@endsection

@section('content-markdown')
    <div class="mt-5">
        The Open Publication Distribution System (OPDS) format is a syndication format for electronic
        publications based on Atom and HTTP. OPDS enable the aggregation, distribution, discovery, and
        acquisition of electronic publications.OPDS use existing or emergent open standards and
        conventions, with a priority on simplicity.
    </div>
    <div>
        <h2>
            OPDS for {{ config('app.name') }} (feeds by version)
        </h2>
        <ul>
            <li>
                <a href="{{ route('opds.feed', ['version' => 'v1.2']) }}" target="_blank" rel="noopener noreferrer">
                    Version 1.2
                </a>
            </li>
        </ul>
    </div>
    <div>
        <h2>
            More about OPDS
        </h2>
        <ul>
            <li>
                <a href="https://opds.io/index.html" target="_blank" rel="noopener noreferrer">
                    OPDS project
                </a>: Easy to use, Open & Decentralized Content Distribution
            </li>
            <li>
                <a href="https://specs.opds.io/" target="_blank" rel="noopener noreferrer">
                    OPDS specifications
                </a>: OPDS (Open Publication Distribution System) is a family of specifications dedicated to the
                distribution of
                digital publications.
            </li>
        </ul>
    </div>
@endsection
