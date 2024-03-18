<?php

namespace App\Modules\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentOrder extends Model
{
    use SoftDeletes;

    protected $table = 'equipment_orders';
    protected $guarded = [];
    public $timestamps = true;
}
