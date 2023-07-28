<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
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
        URL::forceRootUrl(config('app.url'));
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        // if(app()->environment('remote')){
        //     URL::forceScheme('https');
        // }
    }
}
