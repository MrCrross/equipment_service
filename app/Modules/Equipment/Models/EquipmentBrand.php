<?php

namespace App\Modules\Equipment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentBrand extends Model
{
    use SoftDeletes;

    protected $table = 'equipment_brands';
    protected $guarded = [];
    public $timestamps = true;
}
