<?php

use Kiwilan\Steward\Enums\LanguageEnum;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateGeneralSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', config('app.name'));
        $this->migrator->add('general.site_description');
        $this->migrator->add('general.site_url', config('app.url'));
        $this->migrator->add('general.site_lang', LanguageEnum::en->value);
        $this->migrator->add('general.site_active', true);
        $this->migrator->add('general.site_utc', 'utc');
        $this->migrator->add('general.site_favicon');
        $this->migrator->add('general.site_color', '#ffffff');
        $this->migrator->add('general.social', []);
    }
}
