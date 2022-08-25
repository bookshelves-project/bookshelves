<?php

namespace App\Engines\ParserEngine\Parsers;

use App\Engines\ParserEngine;
use App\Services\ConsoleService;
use DOMDocument;
use ReflectionClass;

/**
 * Parse XML string to array, have to implements `XmlInterface`.
 */
class XmlParser
{
    public static function create(ArchiveParser $parser): ArchiveParser|false
    {
        if (! isset($parser->xml_string)) {
            if ($parser->engine->debug) {
                $class = new ReflectionClass($parser->module);
                $module_name = $class->getShortName();
                ConsoleService::print("{$module_name}: can't get {$parser->extension_index}", 'red');
                ConsoleService::newLine();
            }

            return false;
        }

        if ($parser->engine->debug) {
            ParserEngine::printFile($parser->xml_string, "{$parser->engine->file_name}.{$parser->extension_index}", true);
        }

        try {
            $xml_parser = new XmlParser();
            $parser->metadata = $xml_parser->xml_to_array($parser->xml_string);
            $parser->engine = $parser->module::parse($parser);
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
    public function xml_to_array(string $xml_string)
    {
        $doc = new DOMDocument();
        $doc->loadXML($xml_string);
        $root = $doc->documentElement;
        $output = $this->domnode_to_array($root);
        $output['@root'] = $root->tagName;

        return $output;
    }

    public function domnode_to_array(mixed $node)
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
                    $v = $this->domnode_to_array($child);
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
