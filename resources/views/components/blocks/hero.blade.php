<a href="{{ $route ? route($route) : null }}"
    class="flex items-center justify-center mt-4 font-handlee w-max mx-auto">
    <table class="mx-auto">
        <tr>
            <td>
                <img src="{{ asset('images/bookshelves.svg') }}" alt="{{ config('app.name') }}" class="w-24">
            </td>
            <td>
                <div class="ml-4">
                    <div class="text-4xl">
                        {{ config('app.name') }} {{ $title }}
                    </div>
                    <div class="text-sm">
                        {{ $text }}
                    </div>
                </div>
            </td>
        </tr>
    </table>
</a>
