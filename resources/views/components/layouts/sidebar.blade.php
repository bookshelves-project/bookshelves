<x-layouts.app>
    <div x-data="$store.sidebar" class="min-h-full">
        <x-layouts.sidebar.sidebar />
        <x-layouts.sidebar.sidebar-static :links="$links" />

        <div class="lg:pl-64 flex flex-col flex-1">
            {{-- <x-layouts.sidebar.navigation /> --}}
            <main class="flex-1 pb-8">
                {{-- <x-layouts.sidebar.header /> --}}
                <div class="mt-8 min-h-[125vh]">
                    <div class="mt-8">
                        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-layouts.app>
