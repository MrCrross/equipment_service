<?php

namespace Database\Seeders;

use App\Models\Equipment\Equipment;
use App\Models\Equipment\EquipmentBrand;
use App\Models\Equipment\EquipmentModel;
use App\Models\Equipment\EquipmentType;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'Чайник',
            ],
            [
                'name' => 'Блендер',
            ],
            [
                'name' => 'Утюг',
            ],
            [
                'name' => 'Принтер',
            ],
        ];

        $brands = [
            [
                'name' => 'Xiaomi',
                'creator_id' => 1,
            ],
            [
                'name' => 'Philips',
                'creator_id' => 1,
            ],
            [
                'name' => 'Bosch',
                'creator_id' => 1,
            ],
            [
                'name' => 'DEXP',
                'creator_id' => 1,
            ],
            [
                'name' => 'Redmond',
                'creator_id' => 1,
            ],
            [
                'name' => 'Aceline',
                'creator_id' => 1,
            ],
        ];
        $models = [
            [
                'name' => 'SB-600A',
                'type_id' => 2,
                'brand_id' => 6,
                'creator_id' => 1,
            ],
            [
                'name' => 'PL-0500',
                'type_id' => 2,
                'brand_id' => 4,
                'creator_id' => 1,
            ],
        ];
        $equipment = [
            [
                'model_id' => 1,
                'serial' => '12351',
                'short_name' => 'Blender SB-600A',
                'creator_id' => 1,
            ],
            [
                'model_id' => 1,
                'serial' => '12352',
                'short_name' => 'Blender SB-600A',
                'creator_id' => 1,
            ],
            [
                'model_id' => 2,
                'serial' => '12351',
                'short_name' => 'Blender PL-0500',
                'creator_id' => 1,
            ],
            [
                'model_id' => 2,
                'serial' => '12352',
                'short_name' => 'Blender PL-0500',
                'creator_id' => 1,
            ],
        ];

        foreach ($types as $type) {
            EquipmentType::create($type);
        }
        foreach ($brands as $brand) {
            EquipmentBrand::create($brand);
        }
        foreach ($models as $model) {
            EquipmentModel::create($model);
        }
        foreach ($equipment as $eq) {
            Equipment::create($eq);
        }
    }
}
