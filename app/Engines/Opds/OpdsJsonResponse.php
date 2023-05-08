<?php

namespace App\Engines\Opds;

class OpdsJsonResponse
{
    public static function make(mixed $content, int $status = 200)
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=UTF-8');

        http_response_code($status);

        echo json_encode($content);

        exit;
    }
}
