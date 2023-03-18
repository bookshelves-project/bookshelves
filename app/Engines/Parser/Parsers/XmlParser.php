<?php

namespace App\Engines\Parser\Parsers;

use DOMDocument;
use Kiwilan\Steward\Utils\Console;

/**
 * Parse XML string to array, have to implements `XmlInterface`.
 */
class XmlParser
{
    /** @var array<string, mixed> */
    protected array $xmlArray = [];

    protected function __construct(
        protected string $xmlString,
        protected ?Console $console = null,
    ) {
        $this->console = Console::make();
    }

    /**
     * Make a new instance of `XmlParser`.
     *
     * @return array<string, mixed>
     */
    public static function make(string $xmlString): ?array
    {
        $self = new self($xmlString);

        try {
            return $self->xmlToArray();
        } catch (\Throwable $th) {
            $self->console->print(__METHOD__, 'red', $th);
            $self->console->newLine();
        }

        return null;
    }

    /**
     * Convert xml string to php array - useful to get a serializable value.
     * From: https://stackoverflow.com/a/30234924.
     *
     * @return array
     *
     * @author Adrien aka Gaarf & contributors
     *
     * @see http://gaarf.info/2009/08/13/xml-string-to-php-array/
     */
    protected function xmlToArray()
    {
        $doc = new DOMDocument();
        $doc->loadXML($this->xmlString);
        $root = $doc->documentElement;
        $output = $this->domnodeToArray($root);
        $output['@root'] = $root->tagName;

        return $output;
    }

    protected function domnodeToArray(mixed $node)
    {
        $output = [];

        switch ($node->nodeType) {
            case XML_CDATA_SECTION_NODE:
            case XML_TEXT_NODE:
                $output = trim($node->textContent);

                break;

            case XML_ELEMENT_NODE:
                for ($i = 0, $m = $node->childNodes->length; $i < $m; $i++) {
                    $child = $node->childNodes->item($i);
                    $v = $this->domnodeToArray($child);

                    if (isset($child->tagName)) {
                        $t = $child->tagName;

                        if (! isset($output[$t])) {
                            $output[$t] = [];
                        }
                        $output[$t][] = $v;
                    } elseif ($v || '0' === $v) {
                        $output = (string) $v;
                    }
                }

                if ($node->attributes->length && ! is_array($output)) { // Has attributes but isn't an array
                    $output = ['@content' => $output]; // Change output into an array.
                }

                if (is_array($output)) {
                    if ($node->attributes->length) {
                        $a = [];

                        foreach ($node->attributes as $attrName => $attrNode) {
                            $a[$attrName] = (string) $attrNode->value;
                        }
                        $output['@attributes'] = $a;
                    }

                    foreach ($output as $t => $v) {
                        if (is_array($v) && 1 == count($v) && '@attributes' != $t) {
                            $output[$t] = $v[0];
                        }
                    }
                }

                break;
        }

        return $output;
    }
}
