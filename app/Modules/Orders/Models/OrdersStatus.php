<?php

namespace App\Modules\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdersStatus extends Model
{
    protected $table = 'equipment_orders_statuses';
    protected $guarded = [];
    public $timestamps = false;
}
