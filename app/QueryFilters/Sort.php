<?php
namespace App\QueryFilters;

class Sort extends Filter
{

    protected function applyFilters($builder)
    {
       return $builder->where('nom','LIKE','%'.request($this->filterName()).'%');
    }

}