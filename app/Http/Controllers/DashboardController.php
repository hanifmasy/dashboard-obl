<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Draf;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $arr_counted_dashboard = $request->session()->get('arr_counted_dashboard', false);
        // dd($arr_counted_dashboard,
        // Carbon::createFromTimeStamp(strtotime($arr_counted_dashboard['timed_bottom_2']->tgl))->diffForHumans()
        // );
        return view('dashboard.index',compact('arr_counted_dashboard'));
    }
}
