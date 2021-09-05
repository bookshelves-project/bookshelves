@extends('layouts.default', ['title' => 'Catalog, eBooks catalog for eReader browser', 'route' => 'catalog.index',
'slideover' => true])

@section('styles')
    <link rel="stylesheet" href="{{ mix('css/wiki.css') }}">
    <link rel="stylesheet" href="{{ mix('css/markdown.css') }}">
    <style>
        a {
            text-decoration: none !important;
        }

    </style>
@endsection

@section('content')
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
        @yield('catalog')
    </div>
@endsection

@section('content-markdown')

@endsection
