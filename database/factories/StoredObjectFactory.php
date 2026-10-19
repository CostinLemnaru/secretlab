<?php

namespace Database\Factories;

use App\Models\StoredObject;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<StoredObject> */
class StoredObjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'key' => fake()->unique()->slug(),
            'value' => fake()->sentence(),
            'timestamp' => now()->getTimestamp(),
        ];
    }
}
