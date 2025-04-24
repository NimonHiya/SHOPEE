<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class RouteServiceProvider extends ServiceProvider
{
    public static $home = '/home';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        if (Auth::check() && Auth::user()->type == 1) {
            self::$home = '/admin/home';
        }

        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
