<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\privilege>
 */
class PrivilegeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    public function manage_users(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Manage Users',
                'slug' => 'manage-users',
            ];
        });
    }

    public function validate(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Validate Media',
                'slug' => 'validate-media',
            ];
        });
    }

    public function create_entity(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Upload Media',
                'slug' => 'upload-media',
            ];
        });
    }

    public function listen(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Listen',
                'slug' => 'listen',
            ];
        });
    }
}
