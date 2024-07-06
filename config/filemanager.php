<?php

return [
    'disk' => 'public',

    'path' => '/uploads',

    'visibility' => 'public',

    'allowed_file_types' => [
        'image' => ['image/jpeg', 'image/jpg', 'image/webp', 'image/gif', 'image/png', 'image/avif', 'image/bmp', 'image/heic'],
        'video' => ['application/mp4', 'video/mp4', 'video/mpeg'],
        'book' => ['application/pdf', 'application/msword', 'application/excel', 'application/x-excel', 'application/mspowerpoint', 'application/powerpoint'],
        'application' => [],
        'software' => [],
        'archieve' => [],
    ],
];
