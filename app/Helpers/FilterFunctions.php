<?php

// Helper function in app/Helpers/FilterSort.php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;

class FilterFunctions
{
    public static function apply(Builder $query, $filters = [], $sort = [] ,$start, $length)
    {
        // Apply filters
        foreach ($filters as $column => $value) {
            if (!empty($value)) {
                if (strpos($column, '.') === false) {
                    // Filter by column
                    $query->where($column, 'like', '%'.$value.'%');
                } else {
                    // Filter by relationship
                    $parts = explode('.', $column);
                    $relation = $parts[0];
                    $relatedColumn = $parts[1];
                    $query->whereHas($relation, function ($q) use ($relatedColumn, $value) {
                        $q->where($relatedColumn, 'like', '%'.$value.'%');
                    });
                }
            }
        }

        // Apply sorting
        if (!empty($sort)) {
            foreach ($sort as $column => $direction) {
                $query->orderBy($column, $direction);
            }
        }
        $query->offset($start)->limit($length);
        return $query;
    }
}
