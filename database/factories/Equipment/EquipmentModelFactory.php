<?php

namespace Database\Factories\Equipment;

use App\Models\Equipment\EquipmentBrand;
use App\Models\Equipment\EquipmentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment\EquipmentModel>
 */
class EquipmentModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'type_id' => EquipmentType::factory()->create()->id,
            'brand_id' => EquipmentBrand::factory()->create()->id,
            'creator_id' => 1
        ];
    }
}
