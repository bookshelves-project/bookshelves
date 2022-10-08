<?php

namespace App\Services\WikipediaService;

use App\Class\WikipediaItem;

/**
 * Manage Wikipedia API.
 */
interface Wikipediable
{
    /**
     * Convert WikipediaItem data into Model data.
     */
    public function wikipediaConvert(WikipediaItem $wikipediaItem, bool $with_media = true): self;
}
