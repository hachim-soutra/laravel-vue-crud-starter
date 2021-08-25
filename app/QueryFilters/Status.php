<?php

namespace App\QueryFilters;

class Status extends Filter
{

    protected function applyFilters($builder)
    {
        if (!is_null(request('status'))) {
            return $builder->where('status', 'LIKE', request('status'));
        } else {
            return $builder;
        }
    }
}
