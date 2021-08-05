@extends('layouts.base', ['route' => 'catalog.index', 'slideover' => true])

@section('styles')
    <link rel="stylesheet" href="{{ mix('css/wiki.css') }}">
    <link rel="stylesheet" href="{{ mix('css/markdown.css') }}">
@endsection

@section('title-template', 'Catalog')
@section('title-text', 'eBooks catalog for eReader browser')

@section('content-base')
    <button type="button"
        class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium shadow-sm text-white bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
        Button text
    </button>
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
@endsection

@section('content-markdown')
    @yield('content')
@endsection
