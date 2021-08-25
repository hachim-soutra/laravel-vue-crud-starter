<?php

namespace App\QueryFilters;

use Carbon\Carbon;

class DateFin extends Filter
{

    protected function applyFilters($builder)
    {
        if (!is_null(request('date_fin'))) {
            return $builder->whereDate('created_at', '<=', request('date_fin'));
        }
        return $builder;
    }
}
