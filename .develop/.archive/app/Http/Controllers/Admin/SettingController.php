<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Application;
use Inertia\Inertia;
use Spatie\RouteAttributes\Attributes\Get;

class SettingController extends Controller
{
    #[Get('settings', name: 'settings')]
    public function index()
    {
        $configuration_keys = [
            'app.name',
            'app.env',
            'app.debug',
            'app.url',
            'app.repository_url',
            'app.documentation_url',
            'app.front_url',
            'mail.from.address',
            'mail.to.address',
            'bookshelves.cover_extension',
            'bookshelves.authors.order_natural',
            'bookshelves.authors.detect_homonyms',
            'bookshelves.langs',
            'bookshelves.tags.genres_list',
            'bookshelves.tags.forbidden',
            'scout.driver',
            'scout.queue',
            'scout.meilisearch',
            'telescope.enabled',
            'clockwork.enable',
            'session.domain',
            'sanctum.stateful',
            'http.pool_limit',
            'http.async_allow',
        ];
        $configuration = [];
        array_push($configuration, [
            'key' => 'php_version',
            'value' => PHP_VERSION,
        ]);
        array_push($configuration, [
            'key' => 'laravel_version',
            'value' => Application::VERSION,
        ]);
        foreach ($configuration_keys as $key) {
            $value = config($key);
            if (is_bool($value)) {
                array_push($configuration, [
                    'key' => $key,
                    'value' => $value ? 'true' : 'false',
                ]);
            } elseif (! is_array($value)) {
                array_push($configuration, [
                    'key' => $key,
                    'value' => strval($value),
                ]);
            } else {
                array_push($configuration, [
                    'key' => $key,
                    'value' => implode(', ', $value),
                ]);
            }
        }

        $data = [
            'configuration' => $configuration,
        ];

        return Inertia::render('Settings', $data);
    }
}
