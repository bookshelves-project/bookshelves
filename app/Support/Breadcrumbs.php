<?php

namespace App\Support;

use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;

class Breadcrumbs
{
    use SEOToolsTrait;

    private bool $hide = false;

    private array $links = [];

    public function add(array $link)
    {
        $this->links[] = $link;

        return $this;
    }

    public function hide()
    {
        $this->hide = true;

        return $this;
    }

    public function generate()
    {
        if (empty($this->links) || $this->hide) {
            return '';
        }

        $this->seo()
            ->jsonLdMulti()
            ->newJsonLd()
            ->setType('BreadcrumbList')
            ->addValue('itemListElement', collect($this->links)->map(
                fn ($link, $index) => [
                    '@type' => 'ListItem',
                    'position' => ($index + 1),
                    '@id' => $link['href'],
                    'name' => $link['text'],
                    'item' => $link['href'],
                ]
            )->toArray());
    }
}
