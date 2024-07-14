<?php

namespace Koderak\FileManager;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Koderak\FileManager\Enums\FileCategory;
use Koderak\FileManager\Traits\FileProcessing;
use Illuminate\Contracts\Filesystem\Filesystem;
use Koderak\FileManager\Interfaces\ImageServiceInterface;
use Koderak\FileManager\Interfaces\FileProcessingInterface;
use Koderak\FileManager\Interfaces\DirectoryProcessingInterface;

class FileManager implements FileProcessingInterface, DirectoryProcessingInterface
{
    use FileProcessing;

    // Attribute for keep the state of uploaded file
    // it refer to path where the file successfully stored
    protected string $filename;

    // Physical disk location for storing file
    // must be one of the filesystem config defined disk
    protected string $disk;

    // Directory path for storing file on the
    // storage disk
    protected string $path;

    // File visibility
    protected string $visibility;

    // Media Type (MIME) that allowed to be
    // uploaded to the storage disk
    protected array $allowedMediaType = [];

    // File category
    protected FileCategory $category;

    // Service for creating image or thumbnail
    protected ImageServiceInterface $imageService;

    protected array $thumbSizes;


    public function __construct(array $config, $imageService)
    {
        $this->setClassProperties($config);
        $this->setImageService($imageService);

    }

    public function setDisk(string $disk) : self
    {
        $this->disk = $disk;

        return $this;
    }

    public function setPath(string $path) : self
    {
        $this->path = $path;

        return $this;
    }

    public function setVisibility(string $visibility) : self
    {
        $this->visibility = $visibility;

        return $this;
    }

    public function setImageService(ImageServiceInterface $imageService): bool
    {
        if ($imageService instanceof ImageServiceInterface) {
            $this->imageService = $imageService;

            return true;
        }

        throw new Exception("Image service must be instaceof ImageServiceInterface");
    }

    protected function storage() : Filesystem
    {
        return Storage::disk($this->disk);
    }

    protected function setClassProperties($config) : void
    {
        if (Arr::has($config, 'disk')) {
            $this->setDisk($config['disk']);
        }

        if (Arr::has($config, 'path')) {
            $this->setPath($config['path']);
        }

        if (Arr::has($config, 'visibility')) {
            $this->setVisibility($config['visibility']);
        }

        if (Arr::has($config, 'thumbnails-preset')) {
            $this->thumbSizes = $config['thumbnails-preset'];
        }

        if (Arr::has($config, 'allowed_file_types')) {
            foreach ($config['allowed_file_types'] as $allowedFile) {
                $this->allowedMediaType = array_merge($this->allowedMediaType, $allowedFile);
            }
        }
    }
}
