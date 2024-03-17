<?php

namespace App\Modules\Equipment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentModel extends Model
{
    use SoftDeletes;

    protected $table = 'equipment_models';
    protected $guarded = [];
    public $timestamps = true;
}
