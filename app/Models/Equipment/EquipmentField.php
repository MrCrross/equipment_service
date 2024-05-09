<?php

namespace App\Models\Equipment;

use App\Traits\HistoryModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Panoscape\History\HasHistories;

class EquipmentField extends Model
{
    use SoftDeletes;
    use HasHistories;
    use HistoryModelTrait;

    protected $table = 'equipment_fields';
    protected $guarded = [];
    public $timestamps = true;

    public function type(): BelongsTo
    {
        return $this->belongsTo(EquipmentFieldsType::class, 'type_code', 'code')
            ->where('locale', '=', app()->getLocale());
    }

    public static function autocomplete(): Collection
    {
        $result = collect([
            (object)[
                'value' => '',
                'label' => __('datatable.no_selected'),
                'code' => ''
            ]
        ]);

        return $result->merge(
            self::query()
                ->select('equipment_fields.id as value', 'equipment_fields.name as label', 'equipment_fields_types.code')
                ->join('equipment_fields_types', 'equipment_fields_types.id', '=', 'equipment_fields.type_id')
                ->orderBy('equipment_fields.name')
                ->get()
        );
    }

    public function getModelLabel(): string
    {
        return $this->name;
    }

    public function historyMetaFields(): array
    {
        return [
            'name' => [
                'name' => __('equipment.fields.fields.name')
            ],
            'type_code' => [
                'name' => __('equipment.fields.fields.type'),
                'table' => [
                    'name' => 'equipment_fields_types',
                    'value' => 'code',
                    'label' => 'name',
                    'locale' => true,
                ],
            ],
        ];
    }
}
