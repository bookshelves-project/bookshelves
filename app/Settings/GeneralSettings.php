<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $site_name = '';

    public ?string $site_description = '';

    public string $site_url = '';

    public string $site_lang = '';

    public bool $site_active = false;

    public string $site_utc = '';

    public ?string $site_favicon = '';

    public string $site_color = '';

    public array $social = [];

    public static function group(): string
    {
        return 'general';
    }
}
