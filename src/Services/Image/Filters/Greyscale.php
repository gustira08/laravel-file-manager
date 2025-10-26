<?php

namespace Koderak\FileManager\Services\Image\Filters;

use Intervention\Image\Image;
use Koderak\FileManager\Interfaces\FilterInterface;

class Greyscale implements FilterInterface
{
    public function handle(Image $image, array $options): Image
    {
        if (isset($options['greyscale']) && $options['greyscale'] === '1') {
            $image->greyscale();
        }
        return $image;
    }
}
