<?php

namespace App\Modules\Equipment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentFieldsType extends Model
{
    protected $table = 'equipment_fields_types';
    protected $guarded = [];
    public $timestamps = false;
}
