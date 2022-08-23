<?php

namespace App\Traits;

trait HasShowLive
{
    protected $default_show_live_endpoint = 'articles';

    protected $default_show_live_column = 'slug';

    public function getShowLiveEndpoint(): string
    {
        return $this->show_live_endpoint ?? $this->default_show_live_endpoint;
    }

    public function getShowLiveField(): string
    {
        return $this->show_live_column ?? $this->default_show_live_column;
    }

    public function getShowLiveAttribute(): string
    {
        $front_url = config('app.front_url');
        $endpoint = $this->getShowLiveEndpoint();

        return "{$front_url}/{$endpoint}/{$this->slug}";
    }
}
