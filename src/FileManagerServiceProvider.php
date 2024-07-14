<?php

namespace Koderak\FileManager;

use Illuminate\Support\ServiceProvider;
use Koderak\FileManager\Console\Commands\Install;
use Koderak\FileManager\Services\Image\ImageService;

class FileManagerServiceProvider extends ServiceProvider
{
    public function register() {
        $this->mergeConfigFrom(__DIR__ . '/../config/filemanager.php', 'filemanager');

        $this->app->bind(FileManager::class, function () {
            return new FileManager(
                config('filemanager'),
                new ImageService(config('filemanager.thumbnail'))
            );
        });
    }

    public function boot() {
        $this->publishes([
            __DIR__ . '/../config/filemanager.php' => config_path('filemanager.php'),
        ], 'filemanager-config');

        if ($this->app->runningInConsole()) {
            $this->commands([Install::class]);
        }
    }
}
