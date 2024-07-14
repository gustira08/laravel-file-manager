<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Koderak\FileManager\Models\FileModel;

class FileManagerTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        FileModel::factory(10);
        // User::factory(10)->withPersonalTeam()->create();

        // User::factory()->withPersonalTeam()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
