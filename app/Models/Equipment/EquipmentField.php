<?php

namespace App\Models\Equipment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class EquipmentField extends Model
{
    use SoftDeletes;

    protected $table = 'equipment_fields';
    protected $guarded = [];
    public $timestamps = true;

    public function type(): BelongsTo
    {
        return $this->belongsTo(EquipmentFieldsType::class, 'type_id');
    }

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
                ->select('equipment_fields.id as value', 'equipment_fields.name as label', 'equipment_fields_types.code')
                ->join('equipment_fields_types', 'equipment_fields_types.id', '=', 'type_id')
                ->orderBy('equipment_fields.name')
                ->get()
        );
    }
}
