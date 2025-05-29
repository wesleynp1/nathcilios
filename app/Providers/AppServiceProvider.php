<?php

namespace App\Providers;

use App\Models\scheduling;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        Gate::define("isAdmin",function(User $user){
            return $user->email == env("ADMIN_EMAIL");
        });
        
        Gate::define("isTheOwner",function(User $user,scheduling $scheduling){
            return $user->id == $scheduling->client;
        });
    }
}
