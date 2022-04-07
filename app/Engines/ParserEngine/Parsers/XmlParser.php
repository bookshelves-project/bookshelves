<?php

namespace App\Engines\ParserEngine\Parsers;

use App\Engines\ParserEngine;
use App\Services\ConsoleService;
use DOMDocument;
use ZipArchive;

/**
 * Parse XML string to array.
 */
class XmlParser
{
    public function __construct(
        public ParserEngine $engine,
        public string $module,
        public string $extension_index = 'xml',
        public ?array $xml_data = [],
        public ?array $zip_files_list = [],
        public ?string $xml_string = null,
    ) {
    }

    /**
     * Open Zip to find file with `$extension_index`, convert it to `array` and parse it. To use this method, the module have to implements `XmlInterface`.
     *
     * @param bool $find_cover to get first JPG file as cover
     */
    public function openZip(bool $find_cover = false): static|false
    {
        $zip = new ZipArchive();
        $zip->open($this->engine->file_path);

        $zip_files_list = [];
        for ($i = 0; $i < $zip->numFiles; ++$i) {
            $file = $zip->statIndex($i);
            if ($find_cover) {
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                if ('jpg' === $ext) {
                    array_push($zip_files_list, $file['name']);
                }
            }
            if (strpos($file['name'], '.'.$this->extension_index)) {
                $this->xml_string = $zip->getFromName($file['name']);
            }
        }
        if ($find_cover) {
            natsort($zip_files_list);
            $this->zip_files_list = array_values($zip_files_list);
            if (sizeof($this->zip_files_list) > 0) {
                $this->engine->cover_name = $this->zip_files_list[0];
            }
        }

        if (! isset($this->xml_string)) {
            ConsoleService::print("{$this->module}: can't get {$this->extension_index}", 'red');
            ConsoleService::newLine();

            return false;
        }

        if ($this->engine->debug) {
            ParserEngine::printFile($this->xml_string, "{$this->engine->file_name}.{$this->extension_index}", true);
        }

        try {
            $this->xml_data = $this->xml_to_array($this->xml_string);
            $this->engine = $this->module::parse($this, $this->engine);
        } catch (\Throwable $th) {
            ConsoleService::print(__METHOD__, 'red', $th);
            ConsoleService::newLine();
        }

        if ($this->engine->cover_name) {
            for ($i = 0; $i < $zip->numFiles; ++$i) {
                $cover = $zip->getFromName($this->engine->cover_name);
                $this->engine->cover_file = base64_encode($cover);
            }
        }

        $zip->close();

        return $this;
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
