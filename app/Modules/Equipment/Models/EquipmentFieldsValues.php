<?php

namespace App\Modules\Equipment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentFieldsValues extends Model
{
    use SoftDeletes;

    protected $table = 'equipment_fields_equipment';
    protected $guarded = [];
    public $timestamps = true;
}
