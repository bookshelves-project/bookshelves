<a href="{{ $route ? route($route) : null }}" class="flex items-center justify-center mt-4 font-handlee">
    <table class="mx-auto">
        <tr>
            <td>
                <img src="{{ asset('images/bookshelves.svg') }}" alt="Bookshelves" class="w-24">
            </td>
            <td>
                <div class="ml-4">
                    <div class="text-4xl">
                        {{ $title }}
                    </div>
                    <div class="text-sm">
                        {{ $text }}
                    </div>
                </div>
            </td>
        </tr>
    </table>
</a>
