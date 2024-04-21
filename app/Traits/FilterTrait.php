<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait FilterTrait
{
    public static function filterGenerate(Request $request): object
    {
        $filter = [];

        if (isset(self::$filterFields)) {
            foreach (self::$filterFields as $field => $data) {
                $filter[$field] = $request->has($field) ? $request->query($field) : $data['type'];
            }
        }

        return (object)$filter;
    }

    public static function filterData(Request $request, Builder $builder): Builder
    {
        if (isset(self::$filterFields)) {
            foreach (self::$filterFields as $field => $data) {
                $builder->when($request->filled($field), function ($query) use ($request, $field, $data) {
                    $search = $request->query($field);
                    switch ($data['action']) {
                        case 'like':
                            $search = '%' . $search . '%';
                            break;
                        case '<':
                        case '<=':
                            $field = Str::replace('max_', '', $field);
                            break;
                        case '>':
                        case '>=':
                            $field = Str::replace('min_', '', $field);
                            break;
                    }
                    if (isset($data['table'])) {
                        $field = $data['table'] . '.' . $field;
                    }
                    if ($data['action'] === 'null') {
                        $query->whereNull($field);
                    } elseif ($data['action'] === 'not_null') {
                        $query->whereNotNull($field);
                    } else {
                        $query->where($field, $data['action'], $search);
                    }
                });
            }
        }

        return $builder;
    }
}
