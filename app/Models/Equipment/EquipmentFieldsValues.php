<?php

namespace App\Models\Equipment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Panoscape\History\HasHistories;

class EquipmentFieldsValues extends Model
{
    use HasHistories;

    protected $table = 'equipment_fields_equipment';
    protected $guarded = [];
    public $timestamps = false;

    public function field(): BelongsTo
    {
        return $this->belongsTo(EquipmentField::class, 'field_id');
    }

    public function getModelLabel(): string
    {
        return '';
    }
}
