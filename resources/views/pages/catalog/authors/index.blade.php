@extends('layouts.catalog')

@section('title', 'Authors')

@section('content')
    <div class="relative px-4 pt-6 pb-20 sm:px-6 lg:pt-12 lg:pb-28 lg:px-8">
        <div class="relative mx-auto max-w-7xl">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <tbody>
                                    @foreach ($chunks as $key => $item)
                                        <tr
                                            class="{{ $key % 2 === 0 ? 'bg-white dark:bg-gray-900' : 'bg-gray-50 dark:bg-gray-800' }}">
                                            @foreach ($item as $charKey => $char)
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100 text-center">
                                                    <a href="{{ route('catalog.authors.character', ['character' => strtolower($charKey)]) }}"
                                                        class="w-full px-5 text-5xl">
                                                        {{ $charKey }}
                                                    </a>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
