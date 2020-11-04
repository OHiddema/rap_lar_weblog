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

        Gate::before(function(\App\Models\User $user){
            if ($user->role == "admin") { //Admin user
                return true;
            }
        });

        // Oeps, deze ging al mee met de vorige commit...
        // Gate::define('full-access-article', function(\App\Models\User $user, \App\Models\Article $article){
        //     return $article->author->is($user);
        // });

        Gate::define('admin', function(\App\Models\User $user){
            return $user->role == 'admin';
        });
    }
}
