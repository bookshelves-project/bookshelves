@php
$features = App\Utils\FrontNavigation::getFeaturesNavigation();
@endphp

<ul role="list"
    class="list-none justify-center sm:flex sm:space-x-3">
    @foreach ($features as $route)
        <li
            class="{{ Route::currentRouteName() === $route['route'] ? 'bg-gray-200 dark:bg-gray-800' : '' }} rounded-md">
            <x-link :data="$route"
                class="max-content !mx-auto rounded-md p-2 text-base text-gray-400 no-underline hover:bg-gray-800 hover:text-gray-300" />
        </li>
    @endforeach
</ul>
