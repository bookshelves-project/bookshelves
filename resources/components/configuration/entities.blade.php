<section {{ $attributes }}>
    <h2 class="text-2xl font-quicksand font-semibold text-white mb-5 text-center">
        Current {{ config('app.name') }} data
    </h2>
    <div class="flex flex-col mt-6 max-w-lg">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-600 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-600">
                        <thead class="bg-gray-800">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Entities
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Count
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($table)
                                @foreach ($table as $key => $item)
                                    <tr class="{{ $key % 2 === 0 ? 'bg-gray-700' : 'bg-gray-800' }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-100">
                                            {{ $item->entity }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                            {{ $item->count }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endisset
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
