<?php

namespace App\Models\Equipment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class EquipmentFieldsType extends Model
{
    protected $table = 'equipment_fields_types';
    protected $guarded = [];
    public $timestamps = false;

    public static function autocomplete(): Collection
    {
        $result = collect([
            (object)[
                'value' => '',
                'label' => 'Не выбрано'
            ]
        ]);

        return $result->merge(
            self::query()
                ->select('id as value', 'name as label')
                ->orderBy('name')
                ->get()
        );
    }
}
