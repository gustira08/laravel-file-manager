<?php

return [
    'disk' => 'public',

    'path' => '/uploads/thumbnails/',

    'visibility' => 'public',

    'preset' => [
        'thumb-sm' => [
            // smartcrop
            'smartcrop' => '64x64',
        ],
        'thumb-md' => [
            // smartcrop
            'smartcrop' => '150x150',
        ],
        'thumb-lg' => [
            // smartcrop
            'smartcrop' => '300x300',
        ],
        'thumb-xl' => [
            // smartcrop
            'smartcrop' => '600x600',
        ]
    ],

    'filters' => [
        \Koderak\LaravelFileManager\Services\Image\Filters\Resize::class,
        \Koderak\LaravelFileManager\Services\Image\Filters\Blur::class,
        \Koderak\LaravelFileManager\Services\Image\Filters\Greyscale::class,
    ],
];
