<x-catalog.layout>

<x-catalog.panel>
    Select the letter with which the author you are looking for begins.
</x-catalog.panel>

<x-catalog.table>
    <x-catalog.characters :entities="$authors" :route="'front.catalog.authors.character'" />
</x-catalog.table>

</x-catalog.layout>
