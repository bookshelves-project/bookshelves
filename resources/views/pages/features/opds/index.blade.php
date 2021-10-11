@extends('layouts.default', ['title' => 'OPDS, Open Publication Distibution System', 'route' => 'opds.index',
'slideover' => true])

@section('content')
    <x-content :content="$content">
        <ul>
            @foreach ($feeds as $item)
                <li>
                    <a href="{{ route('features.opds.feed', ['version' => $item['param']]) }}" target="_blank"
                        rel="noopener noreferrer">
                        {{ $item['title'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </x-content>

    <x-button>
        Lastest feed
    </x-button>
@endsection
