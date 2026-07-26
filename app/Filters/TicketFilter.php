<?php

namespace App\Filters;

use App\Filters\Contracts\QueryFilter;

class TicketFilter extends QueryFilter
{
    public function status($value = null)
    {
        if ($value) {
            $this->builder->where('status', $value);
        }
    }

    // user: اگر عدد بود user_id، اگر متن بود روی مشخصات کاربر
    public function user($value = null)
    {
        if (! $value) return;

        if (is_numeric($value)) {
            $this->builder->where('user_id', (int) $value);
            return;
        }

        $this->builder->whereHas('user', function ($q) use ($value) {
            $q->where('email', 'LIKE', "%{$value}%")
                ->orWhere('mobile', 'LIKE', "%{$value}%")
                ->orWhere('first_name', 'LIKE', "%{$value}%")
                ->orWhere('last_name', 'LIKE', "%{$value}%");
        });
    }
    public function id($value = null)
    {
        if ($value) {
            return $this->builder->where('id', $value);
        }
    }
    public function department_id($value = null)
    {
        if ($value) {
            $this->builder->where('department_id', $value);
        }
    }

    public function date_from($value = null)
    {
        if ($value) {
            $this->builder->whereDate('updated_at', '>=', $value);
        }
    }

    public function date_to($value = null)
    {
        if ($value) {
            $this->builder->whereDate('updated_at', '<=', $value);
        }
    }
}
