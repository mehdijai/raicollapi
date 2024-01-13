<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
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

    public function user(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'User',
                'slug' => 'user',
            ];
        });
    }

    public function admin(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Admin',
                'slug' => 'admin',
            ];
        });
    }

    public function validator(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Validator',
                'slug' => 'validator',
            ];
        });
    }
}
