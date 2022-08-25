<?php

namespace App\Services;

class ImageService
{
    /**
     * PHP Simple Color Thief
     * ======================
     * Detect the Dominant Color used in an Image
     * Copyright 2019 Igor Gaffling.
     *
     * @param mixed  $img
     * @param string $default
     *
     * @return string
     */
    public static function simple_color_thief($img, $default = 'eee')
    {
        $default = 'fff';

        try {
            if (@exif_imagetype($img)) { // CHECK IF IT IS AN IMAGE
                $type = getimagesize($img)[2]; // GET TYPE
                if (1 === $type) { // GIF
                    $image = imagecreatefromgif($img);
                    // IF IMAGE IS TRANSPARENT (alpha=127) RETURN fff FOR WHITE
                    if (127 == imagecolorsforindex($image, imagecolorstotal($image) - 1)['alpha']) {
                        return $default;
                    }
                } elseif (2 === $type) { // JPG
                    $image = imagecreatefromjpeg($img);
                } elseif (3 === $type) { // PNG
                    $image = imagecreatefrompng($img);
                    // IF IMAGE IS TRANSPARENT (alpha=127) RETURN fff FOR WHITE
                    if ((imagecolorat($image, 0, 0) >> 24) & 0x7F === 127) {
                        return $default;
                    }
                } elseif (18 === $type) { // WEBP
                    $image = imagecreatefromwebp($img);
                    // IF IMAGE IS TRANSPARENT (alpha=127) RETURN fff FOR WHITE
                    if ((imagecolorat($image, 0, 0) >> 24) & 0x7F === 127) {
                        return $default;
                    }
                } else { // NO CORRECT IMAGE TYPE (GIF, JPG or PNG)
                    return $default;
                }
            } else { // NOT AN IMAGE
                return $default;
            }

            $newImg = imagecreatetruecolor(1, 1); // FIND DOMINANT COLOR
            imagecopyresampled($newImg, $image, 0, 0, 0, 0, 1, 1, imagesx($image), imagesy($image));
            $hexa_color = dechex(imagecolorat($newImg, 0, 0));
            if (! self::is_hex($hexa_color)) {
                $hexa_color = $default;
            }

            return $hexa_color; // RETURN HEX COLOR
        } catch (\Throwable $th) {
        }

        return $default;
    }

    public static function is_hex($hex_code): bool
    {
        $isHex = false;

        try {
            $isHex = @preg_match('/^[a-f0-9]{2,}$/i', $hex_code) && ! (strlen($hex_code) & 1);
        } catch (\Throwable $th) {
            // throw $th;
        }

        return $isHex;
    }
}
