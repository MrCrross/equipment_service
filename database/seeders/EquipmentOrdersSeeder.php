<?php

namespace Database\Seeders;

use App\Models\Orders\EquipmentOrder;
use App\Models\Orders\OrdersStatus;
use Illuminate\Database\Seeder;

class EquipmentOrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'name' => 'Черновик',
            ],
            [
                'name' => 'Принято',
            ],
            [
                'name' => 'На ремонте',
            ],
            [
                'name' => 'Завершено',
            ],
        ];
        $orders = [
            [
                'equipment_id' => 1,
                'master_id' => 2,
                'status_id' => 1,
                'description' => 'Всему капут. Движка нет. Крышки нет. Курбурятор сгарэл.',
                'client_id' => 1,
                'creator_id' => 1,
            ],
            [
                'equipment_id' => 2,
                'master_id' => 2,
                'status_id' => 3,
                'description' => 'Почти капут. Движок нот ворк. Крышки нет. Курбурятор ворк.',
                'client_id' => 1,
                'creator_id' => 1,
            ],
        ];

        foreach ($statuses as $status) {
            OrdersStatus::create($status);
        }
        foreach ($orders as $order) {
            EquipmentOrder::create($order);
        }
    }
}
