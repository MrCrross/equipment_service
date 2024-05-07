<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class OrdersStatus extends Model
{
    protected $table = 'equipment_orders_statuses';
    protected $guarded = [];
    public $timestamps = false;

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
                    'code as value',
                    'name as label'
                )
                ->where('locale', '=', app()->getLocale())
                ->get()
        );
    }
}
