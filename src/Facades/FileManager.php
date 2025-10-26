<?php

namespace Koderak\FileManager\Facades;

use Illuminate\Support\Facades\Facade;

class FileManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        self::clearResolvedInstance(\Koderak\FileManager\FileManager::class);

        return \Koderak\FileManager\FileManager::class;
    }
}
