<?php

use App\Support\LaravelViteManifest;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use function Pest\testDirectory;

beforeEach(function () {
    File::makeDirectory(public_path('dist/test'), 0755, true);
    File::copy(testDirectory('manifest.json'), public_path('dist/test/manifest.json'));
});

afterEach(function () {
    File::deleteDirectory(public_path('dist/test'));
});

test('vite directive should return correct embed call', function () {
    $bladeSnippet = '@vite("test", "http://localhost:3100/app.ts")';
    $expectedCode = '<?php echo App\Facades\ViteManifest::embed("test", "http://localhost:3100/app.ts"); ?>';

    expect($expectedCode)->toBe(Blade::compileString($bladeSnippet));
});

test('vite manifest return no scripts', function () {
    Config::set('vite.dev_server', false);

    $scripts = app(LaravelViteManifest::class)->embed('test', 'empty.ts', 3100);

    expect($scripts)->toBeEmpty();
});

test('vite manifest return dev scripts', function () {
    Config::set('vite.dev_server', true);

    $scripts = app(LaravelViteManifest::class)->embed('test', 'app.ts', 3100);

    expect($scripts)->toMatch('/http:\\/\\/127.0.0.1:\\d+\\/app\\.ts/i');
});

test('vite manifest return production scripts', function () {
    Config::set('vite.dev_server', false);

    $url = Str::replace('/', '\/', asset('dist/test/assets'));

    $scripts = app(LaravelViteManifest::class)->embed('test', 'app.ts', 3100);

    expect($scripts)->toMatch("/{$url}\\/app.*\\.js/i");
    expect($scripts)->toMatch("/{$url}\\/vendor.*\\.js/i");
    expect($scripts)->toMatch("/{$url}\\/app.*\\.css/i");
});
