<?php

namespace App\Models\Equipment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class EquipmentType extends Model
{
    use SoftDeletes;

    protected $table = 'equipment_types';
    protected $guarded = [];
    public $timestamps = true;

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
