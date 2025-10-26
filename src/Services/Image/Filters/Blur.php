<?php

namespace Koderak\FileManager\Services\Image\Filters;

use Intervention\Image\Image;
use Koderak\FileManager\Interfaces\FilterInterface;

class Blur implements FilterInterface
{
    public function handle(Image $image, array $option): Image
    {
        if (isset($option['blur']) && $option['blur'] > 0) {
            $image->blur($option['blur']);
        }
        return $image;
    }
}
