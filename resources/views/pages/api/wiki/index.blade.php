@extends('layouts.wiki')

@section('title', 'Home')

@section('content')
    <div class="flex items-center justify-center mt-4 font-handlee">
        <img src="{{ asset('images/bookshelves.svg') }}" alt="Bookshelves" class="w-24">
        <div class="ml-4">
            <div class="text-4xl">
                Bookshelves Wiki
            </div>
        </div>
    </div>
    <div class="mt-20">
        @markdown
        # About

        This Wiki is about Bookshelves project, you will find two parts covered here: the back-end part made in Laravel
        which is clearly the most important part in Bookshelves and the front-end part in NuxtJS which retrieves data from
        the API in order to display it in a nice user interface.

        If you are interested in Bookshelves, you can keep only the back-end part and create your own front-end with the
        technology you want. All the logic of Bookshelves is in the backend and it is even possible to not use an external
        frontend and use Bookshelves with the internal backend interface.

        - **PHP** v{{ $phpVersion }}
        - **Laravel** v{{ $laravelVersion }}
        - 📀 [**bookshelves-back**](https://gitlab.com/ewilan-riviere/bookshelves-back) : back-end of Bookshelves (current
        repository)
        - 🎨 [**bookshelves-front**](https://gitlab.com/ewilan-riviere/bookshelves-front) : front-end of Bookshelves
        - 💻 [**bookshelves.ink**](https://bookshelves.ink) : front demo
        - 📚 [**Documentation**](https://bookshelves.ink/api/documentation)
        @endmarkdown
        @include('pages.api.wiki.content.index')
    </div>
@endsection
