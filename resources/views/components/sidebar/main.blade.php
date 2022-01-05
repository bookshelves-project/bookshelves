<x-layouts.app>
    <div x-data="$store.sidebar" class="min-h-full">
        <x-layouts.sidebar />
        <x-layouts.sidebar-static />

        <div class="lg:pl-64 flex flex-col flex-1">
            <x-layouts.navigation />
            <main class="flex-1 pb-8">
                <x-layouts.header />
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

{{-- <div class="flex flex-col min-h-screen"> --}}
{{-- <nav> --}}
{{-- <x-sections.navbar /> --}}
{{-- </nav> --}}

{{-- <x-main-cta-sticky /> --}}

{{-- <main class="flex-1">
            {{ $slot }}
        </main> --}}

{{-- <footer> --}}
{{-- <x-sections.newsletter /> --}}

{{-- <x-sections.footer /> --}}
{{-- </footer> --}}
{{-- </div> --}}
