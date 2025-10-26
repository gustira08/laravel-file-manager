<?php

namespace Koderak\FileManager\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class Install extends Command implements PromptsForMissingInput
{
    //
    protected $signature = 'filemanager:install {--module}';

    public function handle(): void
    {
        $moduleName = null;

        if ($this->option('module')) {
            $moduleName = $this->ask('What is the module name to install this package?');
        }

        $this->copyDatabaseDirectory($moduleName);
        //
        $this->callSilently('vendor:publish', ['--tag' => 'filemanager-config']);
    }

    protected function copyDatabaseDirectory(string $moduleName=null): void
    {
        $dbFactoryPath = __DIR__.'/../../../database/factories/FileFactory.php';
        $dbMigrationPath = __DIR__.'/../../../database/migrations/2024_06_23_100000_create_files_table.php';
        $dbSeederPath = __DIR__.'/../../../database/seeders/FileManagerTableSeeder.php';

        $dbFactoryDestinationPath = database_path('/factories/FileFactory.php');
        $dbMigrationDestinationPath = database_path('/migrations/2024_06_23_100000_create_files_table.php');
        $dbSeederDestinationPath = database_path('/seeders/FileManagerTableSeeder.php');

        if ($moduleName) {
            $dbFactoryDestinationPath = module_path($moduleName, '/database/factories/FileFactory.php');
            $dbMigrationDestinationPath = module_path($moduleName, '/database/migrations/2024_06_23_100000_create_files_table.php');
            $dbSeederDestinationPath = module_path($moduleName, '/database/seeders/FileManagerTableSeeder.php');
        }

        copy($dbFactoryPath, $dbFactoryDestinationPath);
        copy($dbMigrationPath, $dbMigrationDestinationPath);
        copy($dbSeederPath, $dbSeederDestinationPath);
    }
    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array<string, string>
     */
    // protected function promptForMissingArgumentsUsing(): array
    // {
    //     return [
    //         'module-name' => 'If you are using nwidart module',
    //     ];
    // }
}
