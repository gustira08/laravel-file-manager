<?php

namespace Koderak\FileManager\Interfaces;

use Intervention\Image\Image;

interface FilterInterface
{
    /**
     * @return \Intervention\Image\Image
     */
    function handle(Image $image, array $options);
}
