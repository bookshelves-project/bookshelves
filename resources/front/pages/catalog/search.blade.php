<x-catalog.layout>

<x-slot name="header">
    <x-catalog.header>
        Laravel
    </x-catalog.header>
</x-slot>

<x-catalog.panel>
panel
</x-catalog.panel>

<x-catalog.table>
    table
</x-catalog.table>

<x-catalog.button url="">
    Search
</x-catalog.button>

<x-slot name="subcopy">
    <x-catalog.subcopy>
    subcopy
    </x-catalog.subcopy>
</x-slot>

<x-slot name="footer">
    <x-catalog.footer>
    © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
    </x-catalog.footer>
</x-slot>

</x-catalog.layout>

{{-- @extends('layouts.catalog', ['title' => 'Catalog'])

@section('content')
    @isset($authors_relevant)
        <div>
            <x-catalog.line>
                <h2
                    style="margin: 0px; line-height: 140%; text-align: center; word-wrap: break-word; font-weight: normal; font-family: arial,helvetica,sans-serif; font-size: 22px;">
                    Most relevant
                </h2>
            </x-catalog.line>
            @isset($authors_relevant)
                <x-catalog.entities :type="'author'" :collection="$authors_relevant" />
            @endisset

            @isset($series_relevant)
                <x-catalog.entities :type="'serie'" :collection="$series_relevant" />
            @endisset

            @isset($books_relevant)
                <x-catalog.entities :type="'book'" :collection="$books_relevant" />
            @endisset
        </div>
    @endisset
    @isset($authors_other)
        @if ($authors_other || $series_other || $books_other)
            <div>
                <x-catalog.line>
                    <h2
                        style="margin: 0px; line-height: 140%; text-align: center; word-wrap: break-word; font-weight: normal; font-family: arial,helvetica,sans-serif; font-size: 22px;">
                        Other results
                    </h2>
                </x-catalog.line>
                @isset($authors_other)
                    <x-catalog.entities :type="'author'" :collection="$authors_other" />
                @endisset

                @isset($series_other)
                    <x-catalog.entities :type="'serie'" :collection="$series_other" />
                @endisset

                @isset($books_other)
                    <x-catalog.entities :type="'book'" :collection="$books_other" />
                @endisset
            </div>
        @endisset
    @endisset
@endsection --}}
