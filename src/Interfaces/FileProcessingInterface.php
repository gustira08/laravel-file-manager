<?php

namespace Koderak\FileManager\Interfaces;

use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

interface FileProcessingInterface
{
    /**
     * Upload file to storage disk
     *
     * @return array
     */
    public function upload(File|UploadedFile|string $file);

    /**
     * Delete file from storage
     *
     * @return bool
     */
    public function deleteFile(string|array $paths);

    /**
     * Move file to new location
     *
     * @return bool
     */
    public function moveFile(string $from, string $to);

    /**
     * Copy file to the new location
     *
     * @return bool
     */
    public function copyFile(string $from, string $to);

    /**
     * Find file category by mime type
     *
     * @return \Koderak\LaravelFileManager\Enums\FileCategory
     */
    public function category(string $mimeType);

    /**
     * Check the file is allowed to upload or not
     *
     * @return bool
     */
    public function isAllowedMediaType(string $mimeType);

    /**
     * Generate thumbnail for given file path
     *
     * @return array
     */
    public function generateThumbnail(string $path);

    /**
     * Check file is exists on the storage disk
     *
     * @return bool
     */
    public function isFileExists(string $path);
}
