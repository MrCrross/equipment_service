<?php

namespace App\Models\Equipment;

use App\Traits\HistoryModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Panoscape\History\HasHistories;

class EquipmentType extends Model
{
    use SoftDeletes;
    use HasHistories;
    use HistoryModelTrait;

    protected $table = 'equipment_types';
    protected $guarded = [];
    public $timestamps = true;

    public static function autocomplete(): Collection
    {
        $result = collect([
            (object)[
                'value' => '',
                'label' => __('datatable.no_selected')
            ]
        ]);

        return $result->merge(
            self::query()
                ->select('id as value', 'name as label')
                ->orderBy('name')
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
                'name' => __('equipment.fields.brands.name'),
            ],
        ];
    }
}
