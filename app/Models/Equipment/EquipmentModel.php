<?php

namespace App\Models\Equipment;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class EquipmentModel extends Model
{
    use SoftDeletes;

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
                'label' => 'Не выбрано'
            ]
        ]);

        return $result->merge(
            self::query()
                ->select(
                    'equipment_models.id as value',
                    DB::raw('CONCAT_WS(" ", equipment_types.name, equipment_brands.name, equipment_models.name) as label')
                )
                ->leftJoin('equipment_types', 'equipment_types.id', '=', 'equipment_models.type_id')
                ->leftJoin('equipment_brands', 'equipment_brands.id', '=', 'equipment_models.brand_id')
                ->orderBy('equipment_models.name')
                ->get()
        );
    }
}
