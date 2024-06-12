<?php

namespace Database\Factories\Equipment;

use App\Models\Equipment\EquipmentModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EquipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'model_id' => EquipmentModel::factory()->create()->id,
            'serial' => $this->faker->unique()->randomNumber(),
            'short_name' => fake()->name(),
            'creator_id' => User::factory()->create()->id,
        ];
    }
}
