<?php

return [
    'disk' => env('FILE_MANAGER_DISK', 'public'),

    'path' => env('FILE_MANAGER_PATH', '/uploads'),

    'visibility' => 'public',

    'allowed_file_types' => [
        'image' => ['image/jpeg', 'image/jpg', 'image/webp', 'image/gif', 'image/png', 'image/avif', 'image/bmp', 'image/heic'],
        'video' => ['application/mp4', 'video/mp4', 'video/mpeg'],
        'book' => ['application/pdf', 'application/msword', 'application/excel', 'application/x-excel', 'application/mspowerpoint', 'application/powerpoint'],
        'application' => [],
        'software' => [],
        'archieve' => [],
    ],

    /**
     * Config sets for thumbnail (ImageService) had been
     * used by the filemanager for creating thumbnail while
     * uploading file to the storage disk.
     */
    'thumbnail' => [

        /**
         * Disk where to find location of the original file
         */
        'disk' => env('FILE_MANAGER_DISK', 'public'),

        /**
         * It's a list of available filters to process the
         * image processing.
         */
        'filters' => [
            \Koderak\FileManager\Services\Image\Filters\Resize::class,
            \Koderak\FileManager\Services\Image\Filters\Blur::class,
            \Koderak\FileManager\Services\Image\Filters\Greyscale::class,
        ],

        /**
         * Default encoder for generating and processing new image.
         * Leave it to null to keep the original format for output
         * file after processing.
         */
        'encoder' => \Intervention\Image\Encoders\JpegEncoder::class,

        /**
         * Destionation disk for storing new image
         */
        'destinationDisk' => env('FILE_MANAGER_THUMBNAIL_DISK', 'public'),

        /**
         * Destination path for storing new imaga on the storage disk
         */
        'destinationPath' => env('FILE_MANAGER_THUMBNAIL_PATH', '/uploads/thumbnails'),
    ],
];
