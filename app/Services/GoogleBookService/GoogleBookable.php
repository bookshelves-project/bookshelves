<?php

namespace App\Services\GoogleBookService;

use App\Class\GoogleBook;

/**
 * Manage GoogleBook API.
 */
interface GoogleBookable
{
    /**
     * Convert GoogleBook data into Model data.
     */
    public function googleBookConvert(GoogleBook $googleBook): self;
}
