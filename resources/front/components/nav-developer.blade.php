@php
$developer = App\Utils\FrontNavigation::getDeveloperNavigation();
@endphp

<div class="mx-auto mt-3 max-w-sm border-t border-gray-600">
</div>
<nav class="mt-3 justify-center sm:flex sm:space-x-3">
    @foreach ($developer as $route)
        <div>
            <x-link :data="$route"
                class="max-content !mx-auto rounded-md p-2 text-base text-gray-400 no-underline hover:bg-gray-800 hover:text-gray-300" />
        </div>
    @endforeach
</nav>
