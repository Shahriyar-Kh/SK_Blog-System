<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\Middleware\Authenticate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Redirect authenticated users to dashboard
        RedirectIfAuthenticated::redirectUsing(function()
        {
            return route('admin.dashboard');
        });

        // Redirect unauthenticated users to admin login page
        Authenticate::redirectUsing(function()
        {
          Session::flash('fail', 'You must be logged in to access this page.');
            return route('admin.login');
        });
    }
}
