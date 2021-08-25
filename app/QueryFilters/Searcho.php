<?php

namespace App\QueryFilters;

class Searcho extends Filter
{

    protected function applyFilters($builder)
    {
        return $builder->whereHas('consumer', function ($q) {
            $q->where('prenom', 'LIKE', '%' .  request('search') . '%')
                ->orWhere('nom', 'LIKE', '%' .  request('search') . '%');
        });
    }
}
