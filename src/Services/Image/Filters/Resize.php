<?php

namespace Koderak\FileManager\Services\Image\Filters;

use Intervention\Image\Image;
use Koderak\FileManager\Services\Image\Smartcrop;
use Koderak\FileManager\Interfaces\FilterInterface;

class Resize implements FilterInterface
{
    public function handle(Image $image, array $options): Image
    {
        if (isset($options['smartcrop'])) {
            list($width, $height) = array_map('intval', explode('x', $options['smartcrop']));
            $smartcrop = new Smartcrop($image, [
                'width' => $width,
                'height' => $height,
            ]);
            $res = $smartcrop->analyse();
            $topCrop = $res['topCrop'];
            if ($topCrop) {
                $image->crop(min($topCrop['width'], $width), min($topCrop['height'], $height), $topCrop['x'], $topCrop['y']);
            } else {
                $image->crop($width, $height);
            }
        }

        if (isset($options['crop'])) {
            list($width, $height) = array_map('intval', explode('x', $options['crop']));
            $image->cover($width, $height);
        }

        if (isset($options['widen'])) {
            $image->contain((int) $options['widen'], $image->height());
        }

        if (isset($options['heighten'])) {
            $image->contain($image->width(), $options['heighten']);
        }

        return $image;
    }
}
