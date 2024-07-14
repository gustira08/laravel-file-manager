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
    /**
     * Upload file to storage disk
     */
    public function upload(File|UploadedFile|string $file): array|false
    {
        $mimeType = $file->getMimeType();

        if ($this->isAllowedMediaType($mimeType)) {
            $clientName = $file->getClientOriginalName();
            $extension = $file->extension();

            $uploadedFilename = Utility::generateFilename($clientName, $extension);
            $this->category = $this->category($mimeType);
            $this->filename = $this->uploadToDisk($file, $uploadedFilename);

            $thumb = [];
            if ($this->category === FileCategory::IMAGE) {
                foreach ($this->thumbSizes as $thumbSize) {
                    $thumb[] = $this->generateThumbnail($thumbSize);
                }
            }

            return [
                'name' => $uploadedFilename,
                'path' => $this->filename,
                'disk' => $this->disk,
                'category' => $this->category->value,
                'extension' => $extension,
                'size' => $this->storage()->size($this->filename),
                'mime_type' => $mimeType,
                'sha1sum' => $this->hash(),
                'meta' => ['thumbnails' => $thumb],
            ];
        } else {
            throw new Exception(__('File type is not allowed.'), 422);
        }

        return false;
    }

    /**
     * Delete file from storage disk
     */
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

    /**
     * Get file category by mime type
     */
    public function category(string $mimeType) : FileCategory
    {
        return FileCategory::findCategory($mimeType);
    }

    /**
     * Check whether file is exists or not on the given path of the storage
     * directory.
     *
     * NOTE: It's usefull when we need to move the file to new location
     * to prevent the old file has replaced by new file if the file
     * has the same filename.
     *
     * @return bool
     */
    public function isFileExists(string $path): bool
    {
        if ($this->storage()->exists($path)) {
            return true;
        }

        return false;
    }

    protected function generateThumbnail(array $option = []): string
    {
        $thumbOption = [
            'path' => $this->filename,
            'filter' => 'crop',
            'size' => '300x300',
            'prefix' => 'thumbs',
            'suffix' => '300x300',
        ];

        foreach ($thumbOption as $key => $value) {
            if (Arr::exists($option, $key)) {
                $thumbOption[$key] = $option[$key];
            }
        }

        return $this->imageService->save(
            $thumbOption['path'],
            [$thumbOption['filter'] => $thumbOption['size']],
            prefix: $thumbOption['prefix'],
            suffix: $thumbOption['suffix']
        );
    }


    /**
     * Check if mime type of uploaded file is allowed to
     * be upload to storage disk.
     */
    protected function isAllowedMediaType(string $mimeType) : bool
    {
        if (in_array($mimeType, $this->allowedMediaType)) {
            return true;
        }

        return false;
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
