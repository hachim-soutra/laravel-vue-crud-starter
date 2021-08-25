<?php

namespace App\QueryFilters;

use Carbon\Carbon;

class DateDebut extends Filter
{

    protected function applyFilters($builder)
    {
        if (!is_null(request('date_debut'))) {
            return $builder->whereDate('created_at', '>=', request('date_debut'));
        }
        return $builder;
    }
}
