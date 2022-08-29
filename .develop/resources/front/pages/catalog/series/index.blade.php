<x-catalog.layout>

    <x-catalog.panel>
        Select the letter with which the series you are looking for begins.
    </x-catalog.panel>

    <x-catalog.table>
        <x-catalog.characters :entities="$series"
            :route="'catalog.series.character'" />
    </x-catalog.table>

</x-catalog.layout>
