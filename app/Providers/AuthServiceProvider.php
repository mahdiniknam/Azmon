<?php

namespace App\Providers;

use App\Models\Admin;
use App\Policies\AdminPermissionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Admin::class => AdminPermissionPolicy::class,
        // اگر میخوای برای User و Role هم همین Policy کار کنه:
        // User::class => AdminPermissionPolicy::class,
        // Role::class => AdminPermissionPolicy::class,
    ];
    /**
     * Register services.
     */
    public function register(): void {}

    /**
     * Bootstrap services.
     */
    public function boot(): void {
        $this->registerPolicies();
    }
}
