<?php

namespace Koderak\FileManager\Interfaces;

interface ImageServiceInterface
{
    public function setDisk(string $disk);
    public function setDestinationDisk(string $destinationDisk);
    public function setDestinationPath(string $destinationPath);
    public function generateImage(string $path, array $option = []);
    public function save(string $path, array $option = [], string $prefix = null, string $suffix = null);
    public function delete(string $path);

    // editing
    public function greyscale();
    public function blur(int $amount = 1);
    public function smartcrop(int $width, int $height);
    public function crop(int $width, int $height);
    public function widen(int $width);
    public function heighten(int $height);
    public function builderAddOption(string $key, string|array|int $value);
}
