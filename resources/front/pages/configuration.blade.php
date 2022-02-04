<x-layouts.main :route="route('front.home')">
    <div class="w-max mx-auto mt-3 text-white">
        <a href="https://www.php.net/" target="_blank" rel="noopener noreferrer">PHP v{{ $env['php'] }}</a>,
        <a href="https://laravel.com/" target="_blank" rel="noopener noreferrer">Laravel
            v{{ $env['laravel'] }}</a>
    </div>
    <section class="mt-6 max-w-3xl">
        <x-configuration.data :table="$config" />
        <x-configuration.entities :table="$entities" class="mt-6" />
    </section>
    <x-content :content="$content" class="mt-6" />
</x-layouts.main>
