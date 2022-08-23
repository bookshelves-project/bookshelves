<x-catalog.layout>

<x-catalog.panel>
    Books written by {{ $author->name }}.
</x-catalog.panel>

<x-catalog.table>
    @if (sizeof($books))
        <x-catalog.entities type="book" :collection="$books" />
    @endif
</x-catalog.table>

</x-catalog.layout>
