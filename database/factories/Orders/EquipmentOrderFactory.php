<?php

namespace Database\Factories\Orders;

use App\Models\Equipment\Equipment;
use App\Models\Orders\OrdersStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orders\EquipmentOrder>
 */
class EquipmentOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'equipment_id' => Equipment::factory()->create()->id,
            'master_id' => 2,
            'status_code' => OrdersStatus::all()->random()->code,
            'description' => $this->faker->realText(),
            'price' => $this->faker->randomFloat(2, 2, 7),
            'client_id' => User::factory()->create()->id,
            'creator_id' => 1,
        ];
    }
}
