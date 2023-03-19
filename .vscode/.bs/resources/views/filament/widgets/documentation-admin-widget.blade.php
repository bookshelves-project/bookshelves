<x-filament::widget class="filament-filament-info-widget">
    <x-filament::card class="relative">
        <div
            class="relative flex h-12 flex-col items-center justify-center space-y-2">

            <div class="flex space-x-2 text-sm rtl:space-x-reverse">
                <a href="{{ config('app.front_url') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    @class([
                        'text-gray-600 hover:text-primary-500 focus:outline-none focus:underline',
                        'dark:text-gray-300 dark:hover:text-primary-500' => config(
                            'filament.dark_mode'
                        ),
                    ])>
                    Site web
                </a>

                <span>
                    &bull;
                </span>

                <a href="/api/documentation"
                    target="_blank"
                    rel="noopener noreferrer"
                    @class([
                        'text-gray-600 hover:text-primary-500 focus:outline-none focus:underline',
                        'dark:text-gray-300 dark:hover:text-primary-500' => config(
                            'filament.dark_mode'
                        ),
                    ])>
                    API
                </a>

                <span>
                    &bull;
                </span>

                <a href="https://filamentphp.com/docs"
                    target="_blank"
                    rel="noopener noreferrer"
                    @class([
                        'text-gray-600 hover:text-primary-500 focus:outline-none focus:underline',
                        'dark:text-gray-300 dark:hover:text-primary-500' => config(
                            'filament.dark_mode'
                        ),
                    ])>
                    Filament
                </a>

                <span>
                    &bull;
                </span>

                <a href="https://github.com/filamentphp/filament/issues"
                    target="_blank"
                    rel="noopener noreferrer"
                    @class([
                        'text-gray-600 hover:text-primary-500 focus:outline-none focus:underline',
                        'dark:text-gray-300 dark:hover:text-primary-500' => config(
                            'filament.dark_mode'
                        ),
                    ])>
                    Issues
                </a>
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
