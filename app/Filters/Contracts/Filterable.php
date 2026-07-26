<?php

namespace App\Filters\Contracts;

trait Filterable
{
    public function scopeFilters($query, QueryFilter $filter)
    {
        return $filter->apply($query);
    }
}
