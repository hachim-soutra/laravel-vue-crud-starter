<?php

namespace App\QueryFilters;

class Search extends Filter
{

    protected function applyFilters($builder)
    {
        if (!is_null(request('search'))) {
            return $builder->where('prenom', 'LIKE', '%' . request('search') . '%')
                ->orWhere('nom', 'LIKE', '%' .  request('search') . '%')
                ->orWhere('status', 'LIKE', '%' .  request('search') . '%')
                ->orWhere('phone', 'LIKE', '%' .  request('search') . '%')
                ->orWhere('ville', 'LIKE', '%' .  request('search') . '%')
                ->orWhere('adresse', 'LIKE', '%' .  request('search') . '%');
        }
        return $builder;
    }
}
