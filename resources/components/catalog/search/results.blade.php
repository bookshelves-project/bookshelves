@isset($results['relevant'])
<x-catalog.table>
    Most relevant
</x-catalog.table>
@isset($results['relevant']['authors'])
<x-catalog.entities :type="'author'" :collection="$results['relevant']['authors']" />
@endisset
@isset($results['relevant']['series'])
<x-catalog.entities :type="'serie'" :collection="$results['relevant']['series']" />
@endisset
@isset($results['relevant']['books'])
<x-catalog.entities :type="'book'" :collection="$results['relevant']['books']" />
@endisset
@endisset
@isset($results['other'])
<x-catalog.table>
    Other results
</x-catalog.table>
@isset($results['other']['authors'])
<x-catalog.entities :type="'author'" :collection="$results['other']['authors']" />
@endisset

@isset($results['other']['series'])
<x-catalog.entities :type="'serie'" :collection="$results['other']['series']" />
@endisset

@isset($results['other']['books'])
<x-catalog.entities :type="'book'" :collection="$results['other']['books']" />
@endisset
@endisset
