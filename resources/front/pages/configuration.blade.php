<x-layouts.main :route="route('front.home')">
    <div class="w-max mx-auto mt-3 text-white">
        <a href="https://www.php.net/" target="_blank" rel="noopener noreferrer">PHP v{{ $env['php'] }}</a>,
        <a href="https://laravel.com/" target="_blank" rel="noopener noreferrer">Laravel
            v{{ $env['laravel'] }}</a>
    </div>
    <section class="mt-6 max-w-3xl">
        <x-configuration.table :title="config('app.name').' config'" label="Configuration">
            @foreach ($config as $key => $item)
                <tr class="{{ $key % 2 === 0 ? 'bg-gray-700' : 'bg-gray-800' }}">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-100">
                        {{ $item }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-400">
                        @php
                            $is_array = false;
                            if (is_array(config($item))) {
                                $is_array = true;
                            }
                        @endphp
                        @if ($is_array)
                            @foreach (config($item) as $subKey => $subItem)
                                {{ $subItem }}@if ($subKey < sizeof(config($item)) - 1),@endif
                            @endforeach
                        @else
                            @if (is_bool(config($item)))
                                {{ config($item) ? 'true' : 'false' }}
                            @else
                                {{ config($item) }}
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
        </x-configuration.table>

        <x-configuration.table :title="config('app.name').' entities stats'" label="Entity" value="Count"
            class="mt-6">
            @foreach ($entities as $key => $item)
                <tr class="{{ $key % 2 === 0 ? 'bg-gray-700' : 'bg-gray-800' }}">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-100">
                        {{ $item->entity }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                        {{ $item->count }}
                    </td>
                </tr>
            @endforeach
        </x-configuration.table>
    </section>
    <x-content :content="$content" class="mt-6" />
</x-layouts.main>
