<x-catalog.layout>

<x-catalog.panel>
    Books in {{ $serie->title }}.
</x-catalog.panel>

<x-catalog.table>
    @if (sizeof($books))
        <x-catalog.entities type="book" :collection="$books" />
    @endif
</x-catalog.table>

</x-catalog.layout>
