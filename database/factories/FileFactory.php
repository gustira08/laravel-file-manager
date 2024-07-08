<?php

namespace Database\Factory;

use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Koderak\FileManager\Models\FileModel::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
