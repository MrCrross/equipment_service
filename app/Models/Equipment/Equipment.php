<?php

namespace App\Models\Equipment;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Equipment extends Model
{
    use SoftDeletes;

    protected $table = 'equipment';
    protected $guarded = [];
    public $timestamps = true;

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id')->withTrashed();
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor_id')->withTrashed();
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(EquipmentModel::class, 'model_id')->withTrashed();
    }

    public function fields(): HasMany
    {
        return $this->hasMany(EquipmentFieldsValues::class, 'equipment_id','id');
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
                    'equipment.id as value',
                    DB::raw('CONCAT_WS(" ", equipment_types.name, equipment_brands.name, equipment_models.name, equipment.serial) as label')
                )
                ->leftJoin('equipment_models', 'equipment_models.id', '=', 'equipment.model_id')
                ->leftJoin('equipment_types', 'equipment_types.id', '=', 'equipment_models.type_id')
                ->leftJoin('equipment_brands', 'equipment_brands.id', '=', 'equipment_models.brand_id')
                ->orderBy('equipment_models.name')
                ->get()
        );
    }
}
