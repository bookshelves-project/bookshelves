@props(['title', 'label', 'value'])

<section {{ $attributes }}>
    <h2 class="text-2xl font-quicksand font-semibold text-white mb-5 text-center">
        {{ $title ?? '' }}
    </h2>
    <div class="flex flex-col mt-6 max-w-lg mx-auto">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-600 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-600">
                        <thead class="bg-gray-800">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    {{ $label ?? '' }}
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    {{ $value ?? '' }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($table)
                                {{ $slot ?? '' }}
                            @endisset
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
