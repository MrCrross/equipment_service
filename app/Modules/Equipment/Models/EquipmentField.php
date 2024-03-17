<?php

namespace App\Modules\Equipment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentField extends Model
{
    use SoftDeletes;

    protected $table = 'equipment_fields';
    protected $guarded = [];
    public $timestamps = true;
}
