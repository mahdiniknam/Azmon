<?php

namespace App\Filters;

use App\Filters\Contracts\QueryFilter;
use Illuminate\Support\Facades\App;

class AdminActivityLogFilter extends QueryFilter
{
    public function fromDate($value = null)
    {
        if ($value !== null && $value !== '') {
            if (App::getLocale() === 'fa') {
                return $this->builder->where('created_at', '>=', jalali_to_carbon($value));
            } else {
                return $this->builder->whereDate('created_at', '>=', $value);
            }
        }
    }

    public function toDate($value = null)
    {
        if ($value !== null && $value !== '') {
            if (App::getLocale() === 'fa') {
                return $this->builder->where('created_at', '<=', jalali_to_carbon($value));
            } else {
                return $this->builder->whereDate('created_at', '<=', $value);
            }
        }
    }

    public function admin($value = null)
    {
        if ($value) {
            return $this->builder->where(function ($q) use ($value) {
                if (is_numeric($value)) {
                    $q->where('admin_id', $value);
                }

                $q->orWhereHas('admin', function ($query) use ($value) {
                    $query->where('mobile', $value)
                        ->orWhere('email', $value)
                        ->orWhere('first_name', 'like', "%{$value}%")
                        ->orWhere('last_name', 'like', "%{$value}%");
                });
            });

        }
    }

    public function currency($value = null)
    {
        if ($value) {
            return $this->builder->whereHas('currency', function ($query) use ($value) {
                $query->where('symbol', $value);
            });
        }
    }


    public function section($value = null)
    {
        if ($value) {
            return $this->builder->where('section', $value);
        }
    }

    public function created_at($value = null)
    {
        if ($value) {
            return $this->builder->where('created_at', $value);
        }
    }
    public function txt_id($value = null)
    {
        if ($value) {
            return $this->builder->where('txt_id', $value);
        }
    }
}
