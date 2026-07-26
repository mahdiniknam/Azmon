<?php

namespace App\Traits;

trait HasJalaliTimestamps
{
    public function getCreatedAtJalaliAttribute(): string
    {
        return jdate($this->created_at);
    }

    public function getUpdatedAtJalaliAttribute(): string
    {
        return jdate($this->updated_at);
    }
}
