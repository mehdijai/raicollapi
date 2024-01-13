<?php

namespace Database\Factories;

use App\Enums\ValidationStatus;
use App\Enums\ValidationTypes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Validation>
 */
class ValidationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "description" => fake()->paragraph(),
            "status" => ValidationStatus::VALIDATED,
            "validated_at" => now()
        ];
    }

    public function artist(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => ValidationTypes::ADD_ARTIST,
                "validateable_type" => "ArtistValidation",
            ];
        });
    }

    public function album(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => ValidationTypes::ADD_ALBUM,
                "validateable_type" => "AlbumValidation",
            ];
        });
    }

    public function track(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => ValidationTypes::ADD_TRACK,
                "validateable_type" => "TrackValidation",
            ];
        });
    }
}
