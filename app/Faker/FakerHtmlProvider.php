<?php

namespace App\Faker;

use Faker\Provider\Base;

class FakerHtmlProvider extends Base
{
    /**
     * Generate rich body.
     *
     * @param int $min
     * @param int $max
     * @param int $sentences
     */
    public function htmlParagraphs($min = 1, $max = 5, $sentences = 10): string
    {
        $html = '';

        /*
         *  Generate many paragraphs
         */
        for ($k = 0; $k < $this->generator->numberBetween($min, $max); ++$k) {
            $paragraph = $this->generator->paragraph($sentences);
            $html .= "<p>{$paragraph}</p>";
        }

        return $html;
    }
}
