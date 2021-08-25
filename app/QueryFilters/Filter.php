<?php

namespace App\QueryFilters;

use Closure;
use Illuminate\Support\Str;

abstract class Filter
{
    public function handle($request, Closure $next)
    {

        //dd(request()->has($this->filterName()), $this->filterName());
        // if (!request()->has($this->filterName())) {
        //     return $next($request);
        // }

        $builder = $next($request);

        return $this->applyFilters($builder);
    }

    protected abstract function applyFilters($builder);

    protected function filterName()
    {
        return Str::snake(class_basename($this));
    }
}
