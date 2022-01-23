<x-link :object="$route"
    class="py-8 px-6 bg-gray-800 hover:bg-gray-700 transition-colors duration-75 text-center rounded-lg xl:px-8 xl:text-left relative">
    <div class="h-full flex flex-col">
        @svg('icon-'.$route->icon, 'mx-auto w-16 h-16 xl:w-32 xl:h-32 text-white')
        <div class="space-y-5 xl:flex xl:items-center xl:justify-between mt-8">
            <div class="font-medium text-lg leading-6 space-y-3">
                <h3 class="text-white font-semibold text-3xl text-center">
                    {{ $route->title }}
                </h3>
                <div class="text-gray-400 italic text-sm">
                    {{ $route->description }}
                </div>
            </div>
        </div>
        <div class="mt-auto ml-auto">
            @svg('icon-arrow-sm-right', 'text-white h-10 w-10 ml-auto')
        </div>
    </div>
</x-link>
