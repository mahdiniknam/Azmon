<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AdminPermissionPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isSuperAdmin()) return true; // سوپر ادمین همیشه دسترسی دارد
    }

    public function __call($method, $arguments)
    {
        $admin = $arguments[0]; // Admin فعلی
        return $admin->can($method); // این متد Spatie رو بررسی میکنه
    }
}
