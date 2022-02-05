<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Application;
use Inertia\Inertia;

class SettingController extends Controller
{
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
        $configuration['php_version'] = PHP_VERSION;
        $configuration['laravel_version'] = Application::VERSION;
        foreach ($configuration_keys as $key) {
            $value = config($key);
            if (is_bool($value)) {
                $configuration[$key] = $value ? 'true' : 'false';
            } elseif (! is_array($value)) {
                $configuration[$key] = strval($value);
            } else {
                $configuration[$key] = implode(', ', $value);
            }
        }

        $data = [
            'configuration' => $configuration,
        ];

        return Inertia::render('Settings', $data);
    }
}
