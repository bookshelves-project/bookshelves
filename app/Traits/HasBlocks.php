<?php

namespace App\Traits;

trait HasBlocks
{
    public function getBlocks(string $field = 'alternate_blocks', string $field_image = 'image'): ?array
    {
        $array = $this->{$field};
        if (! $array) {
            return null;
        }
        foreach ($array as $key => $block) {
            if (array_key_exists($field_image, $block)) {
                $array[$key][$field_image] = $this->getMediable($block[$field_image], true);
            }
        }

        return $array;
    }
}
