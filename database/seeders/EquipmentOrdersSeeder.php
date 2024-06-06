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
                'locale' => 'ru',
            ],
            [
                'name' => 'Диагностика',
                'code' => 'diagnostic',
                'locale' => 'ru',
            ],
            [
                'name' => 'Согласование ремонта',
                'code' => 'approval',
                'locale' => 'ru',
            ],
            [
                'name' => 'Согласован',
                'code' => 'signed',
                'locale' => 'ru',
            ],
            [
                'name' => 'Принято',
                'code' => 'accepted',
                'locale' => 'ru',
            ],
            [
                'name' => 'На ремонте',
                'code' => 'repair',
                'locale' => 'ru',
            ],
            [
                'name' => 'Завершено',
                'code' => 'completed',
                'locale' => 'ru',
            ],
            [
                'name' => 'Закрыто',
                'code' => 'closed',
                'locale' => 'ru',
            ],
            [
                'name' => 'Отменено',
                'code' => 'canceled',
                'locale' => 'ru',
            ],
            [
                'name' => 'Удалено',
                'code' => 'deleted',
                'locale' => 'ru',
            ],
            [
                'name' => 'Draft',
                'code' => 'draft',
                'locale' => 'en',
            ],
            [
                'name' => 'Diagnostics',
                'code' => 'diagnostic',
                'locale' => 'en',
            ],
            [
                'name' => 'Approval of repairs',
                'code' => 'approval',
                'locale' => 'en',
            ],
            [
                'name' => 'Agreed',
                'code' => 'signed',
                'locale' => 'en',
            ],
            [
                'name' => 'Accepted',
                'code' => 'accepted',
                'locale' => 'en',
            ],
            [
                'name' => 'Under repair',
                'code' => 'repair',
                'locale' => 'en',
            ],
            [
                'name' => 'Completed',
                'code' => 'completed',
                'locale' => 'en',
            ],
            [
                'name' => 'Closed',
                'code' => 'closed',
                'locale' => 'en',
            ],
            [
                'name' => 'Canceled',
                'code' => 'canceled',
                'locale' => 'en',
            ],
            [
                'name' => 'Deleted',
                'code' => 'deleted',
                'locale' => 'en',
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
