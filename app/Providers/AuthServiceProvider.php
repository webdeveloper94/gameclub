<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function ($user) {
            return $user->type === 'admin';
        });

        Gate::define('isUser', function ($user) {
            return $user->type === 'user';
        });
    }

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
