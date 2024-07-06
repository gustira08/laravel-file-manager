<?php

namespace Koderak\FileManager;

use Illuminate\Support\ServiceProvider;

class FileManagerServiceProvider extends ServiceProvider
{
    public function register() {
        $this->mergeConfigFrom(__DIR__ . '/../config/filemanager.php', 'filemanager');
        // $this->mergeConfigFrom(__DIR__ . '/../config/thumbnail.php', 'thumbnail');

        $this->app->bind(FileManager::class, function () {
            return new FileManager(config('filemanager'));
        });
    }

    public function boot() {
        $this->publishes([
            __DIR__ . '/../config/filemanager.php' => config_path('filemanager.php'),
        ], 'koderak-laravel-file-manager');
    }
}
