<?php

namespace App\Engines\ParserEngine\Parsers;

use App\Engines\ParserEngine;
use App\Services\ConsoleService;
use DOMDocument;

/**
 * Parse XML string to array.
 */
class XmlParser
{
    public static function create(ArchiveParser $parser): ArchiveParser|false
    {
        if (! isset($parser->xml_string)) {
            if ($parser->engine->debug) {
                ConsoleService::print("{$parser->module}: can't get {$parser->extension_index}", 'red');
                ConsoleService::newLine();
            }

            return false;
        }

        if ($parser->engine->debug) {
            ParserEngine::printFile($parser->xml_string, "{$parser->engine->file_name}.{$parser->extension_index}", true);
        }

        try {
            $parser->xml_data = XmlParser::xml_to_array($parser->xml_string);
            $parser->engine = $parser->module::parse($parser, $parser->engine);
        } catch (\Throwable $th) {
            ConsoleService::print(__METHOD__, 'red', $th);
            ConsoleService::newLine();
        }

        return $parser;
    }

    /**
     * convert xml string to php array - useful to get a serializable value.
     * From: https://stackoverflow.com/a/30234924.
     *
     * @return array
     *
     * @author Adrien aka Gaarf & contributors
     *
     * @see http://gaarf.info/2009/08/13/xml-string-to-php-array/
     */
    public static function xml_to_array(string $xml_string)
    {
        $doc = new DOMDocument();
        $doc->loadXML($xml_string);
        $root = $doc->documentElement;
        $output = self::domnode_to_array($root);
        $output['@root'] = $root->tagName;

        return $output;
    }

    public static function domnode_to_array(mixed $node)
    {
        $output = [];

        switch ($node->nodeType) {
            case XML_CDATA_SECTION_NODE:
            case XML_TEXT_NODE:
                $output = trim($node->textContent);

                break;

            case XML_ELEMENT_NODE:
                for ($i = 0, $m = $node->childNodes->length; $i < $m; ++$i) {
                    $child = $node->childNodes->item($i);
                    $v = self::domnode_to_array($child);
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
