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

@section('opds')
    <div class="prose prose-lg dark:prose-light">
        {!! $content !!}
        <ul>
            <li>
                <a href="{{ route('opds.feed', ['version' => 'v1.2']) }}" target="_blank" rel="noopener noreferrer">
                    Version 1.2
                </a>
            </li>
        </ul>
    </div>
@endsection
