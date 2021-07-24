<div class="flex items-center justify-center mt-4 font-handlee w-max mx-auto dark:text-gray-100">
    <table class="mx-auto">
        <tr>
            <td>
                <a href="{{ $route ? route($route) : null }}">
                    <img src="{{ asset('images/bookshelves.svg') }}" alt="{{ config('app.name') }}"
                        class="w-12 lg:w-24">
                </a>
            </td>
            <td>
                <a href="{{ $route ? route($route) : null }}">
                    <div class="ml-4">
                        <div class="text-lg lg:text-4xl">
                            {{ config('app.name') }} {{ $title }}
                        </div>
                        <div class="text-sm">
                            {{ $text }}
                        </div>
                    </div>
                </a>
            </td>
            <td>
                @include('components.blocks.color-switch')
            </td>
        </tr>
    </table>
</div>
