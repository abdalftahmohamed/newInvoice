<?php

namespace App\Providers;

//use App\Models\Contact;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
//        view()->composer('dashboard.*', function ($view) {
//            if (!Cache::has('client_count')) {
//                Cache::remember('client_count', now()->addMinutes(60), function () {
//                    return Client::count();
//                });
//            }
//            if (!Cache::has('invoices_count')) {
//                Cache::remember('invoices_count', now()->addMinutes(60), function () {
//                    return Invoice::count();
//                });
//            }
//            if (!Cache::has('users_count')) {
//                Cache::remember('users_count', now()->addMinutes(60), function () {
//                    return User::count();
//                });
//            }
//
//            view()->share([
//                'client_count' => Cache::get('client_count'),
//                'invoices_count' => Cache::get('invoices_count'),
//                'users_count' => Cache::get('users_count'),
//            ]);
//        });
    }


}
