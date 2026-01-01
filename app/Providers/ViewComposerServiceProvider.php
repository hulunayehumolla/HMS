<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Share firstName and lastName with all views
        View::composer('*', function ($view) {
            $user = Auth::user();

            if ($user) {
                $view->with([
                    'firstName' => $user->first_name,
                    'middleName' => $user->middle_name,
                    'lastName' => $user->last_name
                ]);
            }
        });
    }
}
