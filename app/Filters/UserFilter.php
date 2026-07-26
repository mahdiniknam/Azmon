<?php

namespace App\Filters;

use App\Filters\Contracts\QueryFilter;

class UserFilter extends QueryFilter
{
    public function user($value = null)
    {
        if ($value) {
            if (is_int($value)) {
                return $this->builder->where('id', $value);
            }else{
                return $this->builder
                    ->Where('email','LIKE',"%$value%")
                    ->orWhere('mobile','LIKE',"%$value%")
                    ->orWhere('first_name','LIKE',"%$value%")
                    ->orWhere('last_name','LIKE',"%$value%");
            }
        }
    }
    public function status($value = null)
    {
        if ($value) {
            return $this->builder->where('status', $value);
        }
    }

    public function id($value = null)
    {
        if ($value) {
            return $this->builder->where('id', $value);
        }
    }
    public function package($value = null){
        if ($value) {
            return $this->builder->where('package_id', $value);
        }
    }
}
