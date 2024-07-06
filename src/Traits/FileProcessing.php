<?php

namespace Koderak\FileManager\Traits;

use Exception;
use Illuminate\Http\File;
use Illuminate\Support\Arr;
use Koderak\FileManager\Utility;
use Illuminate\Http\UploadedFile;
use Koderak\FileManager\Enums\FileCategory;

trait FileProcessing
{
    public function upload(File|UploadedFile|string $file): array|false
    {
        $mimeType = $file->getMimeType();

        if ($this->isAllowedMediaType($mimeType)) {
            $clientName = $file->getClientOriginalName();
            $extension = $file->extension();

            $uploadedFilename = Utility::generateFilename($clientName, $extension);
            $this->category = $this->category($mimeType);
            $this->filename = $this->uploadToDisk($file, $uploadedFilename);

            return [
                'name' => $uploadedFilename,
                'path' => $this->filename,
                'disk' => $this->disk,
                'category' => $this->category->value,
                'extension' => $extension,
                'size' => $this->storage()->size($this->filename),
                'mime_type' => $mimeType,
                'sha1sum' => $this->hash(),
                'meta' => [],
            ];
        } else {
            throw new Exception(__('File type is not allowed.'), 422);
        }

        return false;
    }

    public function deleteFile(string|array $paths): bool
    {
        return $this->storage()->delete($paths);
    }

    /**
     * Move file to the new location on the storage disk
     *  NOTE: it will be replacing the existing file in destination path if file has
     *        same filename. Use isFileExists() to check the file is
     *        exist before call this method.
     *
     * @param string $from Location of file to be copied including filename
     * @param string $to It's destinatiion directory, don't put filename in it
     *
     * @return string|false
     */
    public function moveFile(string $from, string $to): string|false
    {
        $filename = basename($from);
        $destination = Utility::buildPath($to, $filename);

        if ($this->storage()->move($from, $destination)) {
            return $destination;
        }

        return false;
    }

    /**
     * Copy file to the new location on the storage disk
     *
     * @param string $from Location of file to be copied including filename
     * @param string $to It's destinatiion directory, don't put filename in it
     *
     * @return string|false
     */
    public function copyFile(string $from, string $to): string|false
    {
        $filename = basename($from);
        $filename = $this->handleDuplicateFilename($to, $filename);
        $destination = Utility::buildPath($to, $filename);

        if ($this->storage()->copy($from, $destination)) {
            return $destination;
        }

        return false;
    }

    public function category(string $mimeType) : FileCategory
    {
        return FileCategory::findCategory($mimeType);
    }

    public function isAllowedMediaType(string $mimeType) : bool
    {
        if (in_array($mimeType, $this->allowedMediaType)) {
            return true;
        }

        return false;
    }

    public function isFileExists(string $path): bool
    {
        if ($this->storage()->exists($path)) {
            return true;
        }

        return false;
    }

    public function generateThumbnail(string $path = null): array
    {
        // $this->imageService->generateImage($this->filename);
        return [];
    }



    protected function hash(string $path = null, string $algo = 'sha1') : string|false
    {
        if (!$path) {
            $path = $this->filename;
        }

        $filename = $this->storage()->url($path);

        if (config('filesystems.disks.'.$this->disk.'.driver') === 'local') {
            $filename = config('filesystems.disks.'.$this->disk.'.root').'/'.$path;
        }

        return @hash_file($algo, $filename);
    }

    protected function uploadToDisk(File|UploadedFile $file, string $filename): string|false
    {
        return $this->storage()->putFileAs(
            $this->path,
            $file,
            $filename,
            ['visibility' => $this->visibility]
        );
    }

    protected function handleDuplicateFilename(string $to, string $filename): string
    {
        $destination = Utility::buildPath($to, $filename);

        if ($this->storage()->exists($destination)) {
            $files = Arr::map($this->storage()->files($to), function ($file) {
                return basename($file);
            });

            return Utility::incrementName($filename, $files);
        }

        return $filename;
    }
}
