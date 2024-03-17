<?php

namespace Database\Seeders;

use App\Modules\Equipment\Models\EquipmentField;
use App\Modules\Equipment\Models\EquipmentFieldsType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipmentFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'Текстовое поле',
                'code' => 'text'
            ],
            [
                'name' => 'Числовое поле',
                'code' => 'number'
            ],
            [
                'name' => 'Поле даты',
                'code' => 'date'
            ],
            [
                'name' => 'Поле даты и времени',
                'code' => 'datetime-local'
            ],
        ];
        $fields = [
            [
                'name' => 'Серийный номер',
                'type_id' => 1,
            ],
            [
                'name' => 'Заводской номер',
                'type_id' => 1,
            ],
        ];

        foreach ($types as $type) {
            EquipmentFieldsType::create($type);
        }
        foreach ($fields as $field) {
            EquipmentField::create($field);
        }
    }
}
