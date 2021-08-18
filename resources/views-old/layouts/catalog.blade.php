@extends('layouts.base', ['route' => 'catalog.index', 'slideover' => true])

@section('styles')
    <link rel="stylesheet" href="{{ mix('css/wiki.css') }}">
    <link rel="stylesheet" href="{{ mix('css/markdown.css') }}">
    <style>
        a {
            text-decoration: none !important;
        }

    </style>
@endsection

@section('title-template', 'Catalog')
@section('title-text', 'eBooks catalog for eReader browser')

@section('content-base')
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
                </tr>
            </tbody>
        </table>
    </nav>
    <div class="container max-w-2xl mx-auto hyphenate">
        @yield('content')
    </div>
@endsection

@section('content-markdown')

@endsection
