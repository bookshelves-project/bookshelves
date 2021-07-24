@extends('layouts.base', ['route' => 'catalog.index'])

@section('styles')
    <link rel="stylesheet" href="{{ mix('css/wiki.css') }}">
    <link rel="stylesheet" href="{{ mix('css/markdown.css') }}">
@endsection

@section('title-template', 'Catalog')
@section('title-text', 'eBooks catalog for eReader browser')

@section('content-base')
    @include('components.blocks.sidebar')
    <nav>
        <table class="mx-auto" cellpadding="20px" cellspacing="0" height="100%" class="table-fixed">
            <tbody>
                <tr>
                    <td class="text-xl font-semibold">
                        <a href="{{ route('catalog.index') }}">
                            Home
                        </a>
                    </td>
                    <td class="text-xl font-semibold">
                        <a href="{{ route('catalog.authors') }}">
                            Authors
                        </a>
                    </td>
                    <td class="text-xl font-semibold">
                        <a href="{{ route('catalog.series') }}">
                            Series
                        </a>
                    </td>
                    <td class="text-xl font-semibold">
                        <a href="{{ route('opds.index') }}">
                            OPDS
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </nav>
    <div class="max-w-5xl mx-auto">
        @yield('content')
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('css/wiki.js') }}"></script>
@endsection
