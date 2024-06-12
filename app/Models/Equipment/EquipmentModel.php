<?php

namespace App\Models\Equipment;

use App\Models\User;
use App\Traits\HistoryModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Panoscape\History\HasHistories;

class EquipmentModel extends Model
{
    use SoftDeletes;
    use HasHistories;
    use HistoryModelTrait;
    use HasFactory;

    protected $table = 'equipment_models';
    protected $guarded = [];
    public $timestamps = true;

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id')->withTrashed();
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(EquipmentType::class, 'type_id')->withTrashed();
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(EquipmentBrand::class, 'brand_id')->withTrashed();
    }

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
                ->select(
                    'equipment_models.id as value',
                    DB::raw(
                        'CONCAT_WS(" ", equipment_types.name, equipment_brands.name, equipment_models.name) as label'
                    )
                )
                ->leftJoin('equipment_types', 'equipment_types.id', '=', 'equipment_models.type_id')
                ->leftJoin('equipment_brands', 'equipment_brands.id', '=', 'equipment_models.brand_id')
                ->orderBy('equipment_models.name')
                ->get()
        );
    }

    public function getModelLabel(): string
    {
        return $this->brand->name . ' ' . $this->type->name . ' ' . $this->name;
    }

    public function historyMetaFields(): array
    {
        return [
            'name' => [
                'name' => __('equipment.fields.models.name')
            ],
            'type_id' => [
                'name' => __('equipment.headers.types.single'),
                'table' => [
                    'name' => 'equipment_types',
                    'value' => 'id',
                    'label' => 'name',
                ],
            ],
            'brand_id' => [
                'name' => __('equipment.headers.brands.single'),
                'table' => [
                    'name' => 'equipment_brands',
                    'value' => 'id',
                    'label' => 'name',
                ],
            ],
        ];
    }
}
