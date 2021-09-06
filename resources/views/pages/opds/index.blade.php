@extends('layouts.opds')

@section('opds')
    <div class="prose prose-lg dark:prose-light">
        {!! $content !!}
        <ul>
            @foreach ($feeds as $item)
                <li>
                    <a href="{{ route('opds.feed', ['version' => $item['param']]) }}" target="_blank"
                        rel="noopener noreferrer">
                        {{ $item['title'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
