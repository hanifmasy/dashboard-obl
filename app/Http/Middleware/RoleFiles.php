<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RoleFiles
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
      if (Auth::check()) {
          $is_user = User::leftJoin('user_role as ur','ur.user_id','=','users.id')->leftJoin('roles as r','r.id','=','ur.role_id')
          ->select('users.id','users.nama_lengkap','ur.role_id','r.nama_role')
          ->where('users.id',Auth::user()->id)
          ->first();
          if( $is_user->role_id !== 4 && $is_user->role_id !== 5 && $is_user->role_id !== 6 ){ return $next($request); }
          else{ return redirect()->route('dashboard'); }
      }
    }
}
