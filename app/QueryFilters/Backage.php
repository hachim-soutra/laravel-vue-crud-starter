<?php

namespace App\QueryFilters;

class Backage extends Filter
{

    protected function applyFilters($builder)
    {
        if (!is_null(request('package'))) {
            return $builder->where('package', 'LIKE', request('package'));
        } else {
            return $builder;
        }
    }
}
