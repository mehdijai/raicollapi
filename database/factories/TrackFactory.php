<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Track>
 */
class TrackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "filePath" => "/data/tracks/" . Str::uuid(),
            "title" => fake()->sentence(2),
            "year" => fake()->year(),
            "trackNb" => fake()->numberBetween(1, 5),
            "genres" => fake()->sentence(1),
            "mimetype" => "audio/mp3",
        ];
    }
}
