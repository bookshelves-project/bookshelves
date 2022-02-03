<x-catalog.layout>

<x-catalog.panel>
    Authors begin by {{ ucfirst($character) }}. Select the author than you want.
</x-catalog.panel>

<x-catalog.table>
    @if (sizeof($authors))
        <x-catalog.entities :collection="$authors" type="author" />
    @endif
</x-catalog.table>

</x-catalog.layout>
