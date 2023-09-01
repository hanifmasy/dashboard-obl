<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DocObl;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
      $user_masuk = User::leftJoin('user_role as ur','ur.user_id','=','users.id')->leftJoin('roles as r','r.id','=','ur.role_id')
      ->select('users.id','users.nama_lengkap','ur.role_id','r.nama_role')
      ->where('users.id',Auth::user()->id)
      ->first();
      $arr_counted_dashboard = $request->session()->get('arr_counted_dashboard', false);
      return view('dashboard.index',compact('arr_counted_dashboard','user_masuk'));
    }
}
