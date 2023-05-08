<?php

namespace App\Engines\Opds;

class OpdsXmlResponse
{
    public static function make(string $content)
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: text/xml; charset=UTF-8');

        echo $content;

        exit;
    }
}
