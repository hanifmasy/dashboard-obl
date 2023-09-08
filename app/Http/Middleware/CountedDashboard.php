<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Exceptions\Handler;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;

class CountedDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user_role = Role::where('user_id',Auth::id())->first();
        // dd( $user_role );
        if( !$user_role ){
          auth()->logout();
          return redirect('/sign-in')->with('status','Oops! Akun Anda Tidak Memiliki Akses Role. Hubungi Admin.');
        }
        else{
          if( !$user_role->role_id ){ auth()->logout(); return redirect('/sign-in')->with('status','Oops! Akun Anda Tidak Memiliki Akses Role. Hubungi Admin.'); }
        }

        return $next($request);
    }
}
