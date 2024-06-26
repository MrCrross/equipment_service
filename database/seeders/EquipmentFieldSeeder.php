<?php

namespace Database\Seeders;

use App\Models\Equipment\EquipmentField;
use App\Models\Equipment\EquipmentFieldsType;
use App\Models\Equipment\EquipmentFieldsValues;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fieldsTypes = [
            [
                'name' => 'Текстовое поле',
                'code' => 'text',
                'language' => 'ru',
            ],
            [
                'name' => 'Числовое поле',
                'code' => 'number',
                'language' => 'ru',
            ],
            [
                'name' => 'Поле даты',
                'code' => 'date',
                'language' => 'ru',
            ],
            [
                'name' => 'Поле даты и времени',
                'code' => 'datetime-local',
                'language' => 'ru',
            ],
            [
                'name' => 'Text field',
                'code' => 'text',
                'language' => 'en',
            ],
            [
                'name' => 'Number field',
                'code' => 'number',
                'language' => 'en',
            ],
            [
                'name' => 'Date field',
                'code' => 'date',
                'language' => 'en',
            ],
            [
                'name' => 'Date and time field',
                'code' => 'datetime-local',
                'language' => 'en',
            ],
        ];
        $fields = [
            [
                'name' => 'Серийный номер',
                'type_code' => 'text',
            ],
            [
                'name' => 'Заводской номер',
                'type_code' => 'text',
            ],
        ];
        $equipmentTypesFields = [
            [
                'type_id' => 2,
                'field_id' => 1,
            ],
            [
                'type_id' => 2,
                'field_id' => 2,
            ],
        ];
        $equipmentFieldsEquipment = [
            [
                'equipment_id' => 1,
                'field_id' => 1,
                'value' => '12345',
            ],
            [
                'equipment_id' => 1,
                'field_id' => 2,
                'value' => '54321',
            ],
            [
                'equipment_id' => 2,
                'field_id' => 1,
                'value' => '12345',
            ],
            [
                'equipment_id' => 2,
                'field_id' => 2,
                'value' => '54321',
            ],
            [
                'equipment_id' => 3,
                'field_id' => 1,
                'value' => '12345',
            ],
            [
                'equipment_id' => 3,
                'field_id' => 2,
                'value' => '54321',
            ],
            [
                'equipment_id' => 4,
                'field_id' => 1,
                'value' => '12345',
            ],
            [
                'equipment_id' => 4,
                'field_id' => 2,
                'value' => '54321',
            ],
        ];

        foreach ($fieldsTypes as $type) {
            EquipmentFieldsType::create($type);
        }
        foreach ($fields as $field) {
            EquipmentField::create($field);
        }
        foreach ($equipmentTypesFields as $field) {
            DB::table('equipment_fields_equipment_types')
                ->insert($field);
        }
        foreach ($equipmentFieldsEquipment as $value) {
            EquipmentFieldsValues::create($value);
        }
    }
}
