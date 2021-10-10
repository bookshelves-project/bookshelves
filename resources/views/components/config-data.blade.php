<section class="mt-16">
    <h3 class="text-2xl font-quicksand font-semibold mb-5">
        Current {{ config('app.name') }} config
    </h3>
    <div class="flex flex-col mt-6 max-w-lg">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 dark:border-gray-600 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Configuration
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Value
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($table as $key => $item)
                                @php
                                    $is_array = false;
                                    if (is_array(config($item))) {
                                        $is_array = true;
                                    }
                                @endphp
                                <tr
                                    class="{{ $key % 2 === 0 ? 'bg-white dark:bg-gray-700' : 'bg-gray-50 dark:bg-gray-800' }}">
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $item }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        @if ($is_array)
                                            @foreach (config($item) as $subKey => $subItem)
                                                {{ $subItem }}@if ($subKey < sizeof(config($item)) - 1),@endif
                                            @endforeach
                                        @else
                                            {{ config($item) }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
