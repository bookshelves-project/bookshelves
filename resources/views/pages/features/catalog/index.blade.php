@extends('layouts.default', ['title' => 'Catalog, get eBooks from your eReader'])

@section('content')
    <x-content :content="$content" />
    <div class="mx-auto w-max mt-6">
        <a href="{{ route('features.catalog.search') }}" target="_blank" rel="noopener noreferrer" class="mx-auto">
            <button type="button"
                class="inline-flex items-center px-4 py-2 border border-transparent text-base font-semibold rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Access to Catalog
            </button>
        </a>
    </div>
    <div class="prose prose-lg dark:prose-light mt-6">
        To access to Catalog from your eReader, just put this address to your web browser*:
        <pre>{{ route('features.catalog.index') }}</pre>
        <div class="mt-3">
            <small>
                *: Works only on phone, tablet or eReader.
            </small>
        </div>
    </div>
@endsection
