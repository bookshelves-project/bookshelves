<x-catalog.layout>

<x-catalog.panel>
    Series begin by {{ ucfirst($character) }}. Select the author than you want.
</x-catalog.panel>

<x-catalog.table>
    @if (sizeof($series))
        <x-catalog.entities :collection="$series" type="serie" />
    @endif
</x-catalog.table>

</x-catalog.layout>
