<?php

namespace Koderak\FileManager\Test;

use Intervention\Image\Laravel\ServiceProvider;
use Koderak\FileManager\FileManagerServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{

    protected function getEnvironmentSetUp($app)
    {
        $app->useStoragePath(realpath(__DIR__ . '/../storage'));
        $app['config']->set('filesystems.disks.public.root', storage_path('app/public'));
    }


    protected function getPackageProviders($app)
    {
        return [
            FileManagerServiceProvider::class,
            ServiceProvider::class
        ];
    }
}
