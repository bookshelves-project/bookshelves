<x-catalog.layout>

@isset($q)
<x-catalog.panel>
    Your search: "{{ $q }}"
</x-catalog.panel>
@endisset

<x-catalog.table>
    For an eBook, you can download it directly. For an author or a series, you have to tap on it to get list of
    books to download them.
</x-catalog.table>

@isset($results)
<x-catalog.table>
    <x-catalog.search.results :results="$results" />
</x-catalog.table>
@endisset

</x-catalog.layout>
