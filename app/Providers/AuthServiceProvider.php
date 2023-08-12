<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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
                $is_user = User::leftJoin('user_role as ur','ur.user_id','=','users.id')->leftJoin('roles as r','r.id','=','ur.role_id')
                ->select('users.id','users.nama_lengkap','ur.role_id','r.nama_role')
                ->where('users.id',Auth::user()->id)
                ->first();
                $view->with('is_user', $is_user);
            }else {
                auth()->logout();
                return redirect('/sign-in');
            }
        });

    }
}
