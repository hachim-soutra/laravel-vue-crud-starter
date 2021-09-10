<?php

namespace App\QueryFilters;

class statusLivraison extends Filter
{

    protected function applyFilters($builder)
    {
        if (!is_null(request('status'))) {
            return $builder->where('status_livraison_id', request('status'))->where('order_status_id', 3);
        } else {
            return $builder;
        }
    }
}
