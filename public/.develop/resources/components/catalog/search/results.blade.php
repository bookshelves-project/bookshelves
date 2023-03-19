@isset($results['authors'])
<x-catalog.entities :type="'author'" :collection="$results['authors']" />
@endisset
@isset($results['series'])
<x-catalog.entities :type="'serie'" :collection="$results['series']" />
@endisset
@isset($results['books'])
<x-catalog.entities :type="'book'" :collection="$results['books']" />
@endisset
