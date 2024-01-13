<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [];
    }

    public function playlist(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                "likeable_type" => "PlaylistLike",
            ];
        });
    }

    public function album(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                "likeable_type" => "AlbumLike",
            ];
        });
    }

    public function track(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                "likeable_type" => "TrackLike",
            ];
        });
    }
}
