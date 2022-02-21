<?php

namespace App\Engines\ParserEngine;

use DOMDocument;

/**
 * Parse XML string to array.
 */
class XmlParser
{
    public function __construct(
        public string $xml_string,
    ) {
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
    public function xml_to_array()
    {
        $doc = new DOMDocument();
        $doc->loadXML($this->xml_string);
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
                if ($node->attributes->length && ! is_array($output)) { //Has attributes but isn't an array
                $output = ['@content' => $output]; //Change output into an array.
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
