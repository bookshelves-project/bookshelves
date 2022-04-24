<div x-show="!readerIsEnabled" class="dark:text-white mt-6 relative z-20 pb-6">
    <div class="flex">
        <img src="{{ $book->cover_thumbnail }}" alt="" class="object-cover w-20 h-20 rounded-md mx-auto">
    </div>
    <div class="font-quicksand text-center mt-3">
        <h1 class="text-3xl">
            {{ $book->title }}
        </h1>
        @isset($book->serie)
            <h2>
                {{ $book->serie->title }}, vol. {{ $book->volume }}
            </h2>
        @endisset
    </div>
    <div class="text-center mt-3">
        By {{ $book->authors_names }}
    </div>
    @if ($book->files && $book->files['epub'] && $book->files['epub']->size)
        <div x-show="isLoading" class="text-center">
            EPUB file ({{ $book->files['epub']->size }}) is loading...
        </div>
        <div x-show="!isLoading">
            <x-button button @click="read()">Read</x-button>
        </div>
    @endif
    <div class="italic mt-4 word-wraping">
        {!! $book->description !!}
    </div>
</div>
