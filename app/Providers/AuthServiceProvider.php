<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // zorgt er voor dat admin 'alles mag'
        Gate::before(function(\App\Models\User $user){
            if ($user->role == "admin") { //Admin user
                return true;
            }
        });

        Gate::define('admin', function(\App\Models\User $user){
            return $user->role == 'admin';
        });
    }
}
