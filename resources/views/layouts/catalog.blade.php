@extends('layouts.default', ['title' => 'Catalog, eBooks catalog for eReader browser', 'route' => 'catalog.index',
'slideover' => true])

@section('styles')
    <link rel="stylesheet" href="{{ mix('assets/css/blade/wiki.css') }}">
    <link rel="stylesheet" href="{{ mix('assets/css/blade/markdown.css') }}">
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
        <div class="mt-6 mb-10">
            <x-catalog.search />
        </div>
    </nav>
    <div class="container max-w-2xl mx-auto hyphenate">
        @yield('catalog')
    </div>
@endsection
