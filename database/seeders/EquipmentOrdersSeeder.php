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
                'code' => 'draft',
                'language' => 'ru',
            ],
            [
                'name' => 'Диагностика',
                'code' => 'diagnostic',
                'language' => 'ru',
            ],
            [
                'name' => 'Согласование ремонта',
                'code' => 'approval',
                'language' => 'ru',
            ],
            [
                'name' => 'Согласован',
                'code' => 'signed',
                'language' => 'ru',
            ],
            [
                'name' => 'Принято',
                'code' => 'accepted',
                'language' => 'ru',
            ],
            [
                'name' => 'На ремонте',
                'code' => 'repair',
                'language' => 'ru',
            ],
            [
                'name' => 'Завершено',
                'code' => 'completed',
                'language' => 'ru',
            ],
            [
                'name' => 'Закрыто',
                'code' => 'closed',
                'language' => 'ru',
            ],
            [
                'name' => 'Отменено',
                'code' => 'canceled',
                'language' => 'ru',
            ],
            [
                'name' => 'Удалено',
                'code' => 'deleted',
                'language' => 'ru',
            ],
            [
                'name' => 'Draft',
                'code' => 'draft',
                'language' => 'en',
            ],
            [
                'name' => 'Diagnostics',
                'code' => 'diagnostic',
                'language' => 'en',
            ],
            [
                'name' => 'Approval of repairs',
                'code' => 'approval',
                'language' => 'en',
            ],
            [
                'name' => 'Agreed',
                'code' => 'signed',
                'language' => 'en',
            ],
            [
                'name' => 'Accepted',
                'code' => 'accepted',
                'language' => 'en',
            ],
            [
                'name' => 'Under repair',
                'code' => 'repair',
                'language' => 'en',
            ],
            [
                'name' => 'Completed',
                'code' => 'completed',
                'language' => 'en',
            ],
            [
                'name' => 'Closed',
                'code' => 'closed',
                'language' => 'en',
            ],
            [
                'name' => 'Canceled',
                'code' => 'canceled',
                'language' => 'en',
            ],
            [
                'name' => 'Deleted',
                'code' => 'deleted',
                'language' => 'en',
            ],
        ];
        $orders = [
            [
                'equipment_id' => 1,
                'master_id' => 2,
                'status_code' => 'draft',
                'price' => 0,
                'description' => 'Всему капут. Движка нет. Крышки нет. Курбурятор сгарэл.',
                'client_id' => 1,
                'creator_id' => 1,
            ],
            [
                'equipment_id' => 2,
                'master_id' => 2,
                'status_code' => 'repair',
                'price' => 1000.65,
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
