<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Draf;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
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

        // View::share('count_draf', $count_draf);
        view()->composer('*', function($view)
        {
            if (Auth::check()) {
                $count_draf = Draf::where('user_id',Auth::user()->id)->where('is_draf',1)->count();
                $view->with('count_draf', $count_draf);
            }else {
                $view->with('count_draf', 0);
            }
        });
        //
    }
}
