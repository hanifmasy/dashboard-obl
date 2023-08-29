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
      $arr_counted_dashboard = $request->session()->get('arr_counted_dashboard', false);
      return view('dashboard.index',compact('arr_counted_dashboard'));
    }
}
