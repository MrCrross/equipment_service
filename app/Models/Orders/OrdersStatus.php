<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;

class OrdersStatus extends Model
{
    protected $table = 'equipment_orders_statuses';
    protected $guarded = [];
    public $timestamps = false;
}
