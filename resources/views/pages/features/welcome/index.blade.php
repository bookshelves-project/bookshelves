@extends('layouts.default', ['title' => 'Features, extra options for '.config('app.name')])

@section('content')
    <div class="prose prose-lg dark:prose-light">
        <x-content :content="$content" />
    </div>

    <x-entities-data :table="$table" />
    <x-config-data :table="$tableConfig" />
@endsection
