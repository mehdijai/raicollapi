<?php

namespace Database\Factories;

use App\Enums\AlbumType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Album>
 */
class AlbumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();
        return [
            "name" => $name,
            "type" => AlbumType::Album,
            "year" => fake()->year(),
        ];
    }
}
