<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait OrderTrait
{
    private static array $orderDefault = [];

    private static bool $default = true;
    private static array $defaultOrder = ['name' => 'asc'];

    private static function getOrderDefault(): array
    {
        if (empty(self::$orderDefault)) {
            self::$orderDefault = [
                [
                    'label' => __('datatable.no_sorting'),
                    'value' => 0
                ],
                [
                    'label' => __('datatable.by_asc'),
                    'value' => 1
                ],
                [
                    'label' => __('datatable.by_desc'),
                    'value' => 2
                ],
            ];
        }
        $orderDefault = [];
        foreach (self::$orderDefault as $value) {
            $orderDefault[] = (object)$value;
        }

        return $orderDefault;
    }

    public static function orderData(Request $request, Builder $builder): Builder
    {
        if (isset(self::$orderFields)) {
            foreach (self::$orderFields as $field) {
                $builder->when((int)$request->query('order_' . $field) !== 0, function ($query) use ($request, $field) {
                    self::$default = false;
                    $query->orderBy($field, (int)$request->query('order_' . $field) === 1 ? 'ASC' : 'DESC');
                });
            }
            if (self::$default) {
                foreach (self::$defaultOrder as $field => $type) {
                    $builder->orderBy($field, $type);
                }
            }
        }

        return $builder;
    }

    public static function orderGenerate(Request $request): object
    {
        $order = [
            'default' => self::getOrderDefault()
        ];

        if (isset(self::$orderFields)) {
            foreach (self::$orderFields as $field) {
                $order[$field] = $request->has('order_' . $field) ? $request->query('order_' . $field) : 0;
            }
        }

        return (object)$order;
    }

    public static function setDefaultOrder(array $defaultOrder): void
    {
        self::$defaultOrder = $defaultOrder;
    }
}
