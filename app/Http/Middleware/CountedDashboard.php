<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Exceptions\Handler;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
        try{
          // GET & COUNT DATA FOR DASHBOARD
          $counted_dashboard_top_1 = DB::connection('pgsql')->table('form_obl')->whereRaw(" deleted_at is null and f1_proses = 'cancel' ");
          $counted_dashboard_top_2 = DB::connection('pgsql')->table('form_obl')->whereRaw(" deleted_at is null ");

          $counted_dashboard_bottom_1 = DB::connection('pgsql')->table('form_obl')->whereRaw(" deleted_at is null and f1_proses = 'witel' ");
          $timed_dashboard_bottom_1 = DB::connection('pgsql')->table('form_obl')->select(DB::raw("to_char(updated_at,'YYYY-MM-DD HH24:MI:SS') as tgl"))->whereRaw(" deleted_at is null and f1_proses = 'witel' ");
          $counted_dashboard_bottom_2 = DB::connection('pgsql')->table('form_obl')->whereRaw(" deleted_at is null and f1_proses = 'obl' ");
          $timed_dashboard_bottom_2 = DB::connection('pgsql')->table('form_obl')->select(DB::raw("to_char(updated_at,'YYYY-MM-DD HH24:MI:SS') as tgl"))->whereRaw(" deleted_at is null and f1_proses = 'obl' ");
          $counted_dashboard_bottom_3 = DB::connection('pgsql')->table('form_obl')->whereRaw(" deleted_at is null and f1_proses = 'legal' ");
          $timed_dashboard_bottom_3 = DB::connection('pgsql')->table('form_obl')->select(DB::raw("to_char(updated_at,'YYYY-MM-DD HH24:MI:SS') as tgl"))->whereRaw(" deleted_at is null and f1_proses = 'legal' ");
          $counted_dashboard_bottom_4 = DB::connection('pgsql')->table('form_obl')->whereRaw(" deleted_at is null and f1_proses = 'mitra_obl' ");
          $timed_dashboard_bottom_4 = DB::connection('pgsql')->table('form_obl')->select(DB::raw("to_char(updated_at,'YYYY-MM-DD HH24:MI:SS') as tgl"))->whereRaw(" deleted_at is null and f1_proses in ('mitra_obl','mitra_pjm') ");
          $counted_dashboard_bottom_5 = DB::connection('pgsql')->table('form_obl')->whereRaw(" deleted_at is null and f1_proses = 'close_sm' ");
          $timed_dashboard_bottom_5 = DB::connection('pgsql')->table('form_obl')->select(DB::raw("to_char(updated_at,'YYYY-MM-DD HH24:MI:SS') as tgl"))->whereRaw(" deleted_at is null and f1_proses = 'close_sm' ");
          $counted_dashboard_bottom_6 = DB::connection('pgsql')->table('form_obl')->whereRaw(" deleted_at is null and f1_proses = 'done' ");
          $timed_dashboard_bottom_6 = DB::connection('pgsql')->table('form_obl')->select(DB::raw("to_char(updated_at,'YYYY-MM-DD HH24:MI:SS') as tgl"))->whereRaw(" deleted_at is null and f1_proses = 'done' ");

          if(Auth::check()){
            $is_user = User::leftJoin('user_role as ur','ur.user_id','=','users.id')
            ->leftJoin('roles as r','r.id','=','ur.role_id')
            ->leftJoin('witels','witels.id','=','users.witel_id')
            ->leftJoin('user_mitra','user_mitra.user_id','=','users.id')
            ->select('users.id','users.nama_lengkap','ur.role_id','r.nama_role','witels.nama_witel','user_mitra.mitra_id')
            ->where('users.id',Auth::id())
            ->first();
            // USER WITEL
            if($is_user->role_id===4 || $is_user->role_id===5){
              $counted_dashboard_top_1->where('f1_witel',$is_user->nama_witel);
              $counted_dashboard_top_2->where('f1_witel',$is_user->nama_witel);
              $counted_dashboard_bottom_1->where('f1_witel',$is_user->nama_witel);
              $timed_dashboard_bottom_1->where('f1_witel',$is_user->nama_witel);
              $counted_dashboard_bottom_2->where('f1_witel',$is_user->nama_witel);
              $timed_dashboard_bottom_2->where('f1_witel',$is_user->nama_witel);
              $counted_dashboard_bottom_3->where('f1_witel',$is_user->nama_witel);
              $timed_dashboard_bottom_3->where('f1_witel',$is_user->nama_witel);
              $counted_dashboard_bottom_4->where('f1_witel',$is_user->nama_witel);
              $timed_dashboard_bottom_4->where('f1_witel',$is_user->nama_witel);
              $counted_dashboard_bottom_5->where('f1_witel',$is_user->nama_witel);
              $timed_dashboard_bottom_5->where('f1_witel',$is_user->nama_witel);
              $counted_dashboard_bottom_6->where('f1_witel',$is_user->nama_witel);
              $timed_dashboard_bottom_6->where('f1_witel',$is_user->nama_witel);
            }
            // USER MITRA
            if($is_user->role_id===6){
              $counted_dashboard_top_1->where('f1_mitra_id',$is_user->mitra_id);
              $counted_dashboard_top_2->where('f1_mitra_id',$is_user->mitra_id);
              $counted_dashboard_bottom_1->where('f1_mitra_id',$is_user->mitra_id);
              $timed_dashboard_bottom_1->where('f1_mitra_id',$is_user->mitra_id);
              $counted_dashboard_bottom_2->where('f1_mitra_id',$is_user->mitra_id);
              $timed_dashboard_bottom_2->where('f1_mitra_id',$is_user->mitra_id);
              $counted_dashboard_bottom_3->where('f1_mitra_id',$is_user->mitra_id);
              $timed_dashboard_bottom_3->where('f1_mitra_id',$is_user->mitra_id);
              $counted_dashboard_bottom_4->where('f1_mitra_id',$is_user->mitra_id);
              $timed_dashboard_bottom_4->where('f1_mitra_id',$is_user->mitra_id);
              $counted_dashboard_bottom_5->where('f1_mitra_id',$is_user->mitra_id);
              $timed_dashboard_bottom_5->where('f1_mitra_id',$is_user->mitra_id);
              $counted_dashboard_bottom_6->where('f1_mitra_id',$is_user->mitra_id);
              $timed_dashboard_bottom_6->where('f1_mitra_id',$is_user->mitra_id);
            }
          }

          $top_1 = $counted_dashboard_top_1->count();
          $top_2 = $counted_dashboard_top_2->count();
          $bottom_1 = $counted_dashboard_bottom_1->count();
          $timed_bottom_1 = $timed_dashboard_bottom_1->orderByRaw("CASE WHEN updated_at IS NULL THEN 0 ELSE 1 END DESC")->orderBy('updated_at','DESC')->first();
          $bottom_2 = $counted_dashboard_bottom_2->count();
          $timed_bottom_2 = $timed_dashboard_bottom_2->orderByRaw("CASE WHEN updated_at IS NULL THEN 0 ELSE 1 END DESC")->orderBy('updated_at','DESC')->first();
          $bottom_3 = $counted_dashboard_bottom_3->count();
          $timed_bottom_3 = $timed_dashboard_bottom_3->orderByRaw("CASE WHEN updated_at IS NULL THEN 0 ELSE 1 END DESC")->orderBy('updated_at','DESC')->first();
          $bottom_4 = $counted_dashboard_bottom_4->count();
          $timed_bottom_4 = $timed_dashboard_bottom_4->orderByRaw("CASE WHEN updated_at IS NULL THEN 0 ELSE 1 END DESC")->orderBy('updated_at','DESC')->first();
          $bottom_5 = $counted_dashboard_bottom_5->count();
          $timed_bottom_5 = $timed_dashboard_bottom_5->orderByRaw("CASE WHEN updated_at IS NULL THEN 0 ELSE 1 END DESC")->orderBy('updated_at','DESC')->first();
          $bottom_6 = $counted_dashboard_bottom_6->count();
          $timed_bottom_6 = $timed_dashboard_bottom_6->orderByRaw("CASE WHEN updated_at IS NULL THEN 0 ELSE 1 END DESC")->orderBy('updated_at','DESC')->first();

          // STORE IN GLOBAL SESSIONS HELPER
          $arr_counted_dashboard = [
            'top_1' => $top_1,
            'top_2' => $top_2,
            'bottom_1' => $bottom_1,
            'timed_bottom_1' => $timed_bottom_1,
            'bottom_2' => $bottom_2,
            'timed_bottom_2' => $timed_bottom_2,
            'bottom_3' => $bottom_3,
            'timed_bottom_3' => $timed_bottom_3,
            'bottom_4' => $bottom_4,
            'timed_bottom_4' => $timed_bottom_4,
            'bottom_5' => $bottom_5,
            'timed_bottom_5' => $timed_bottom_5,
            'bottom_6' => $bottom_6,
            'timed_bottom_6' => $timed_bottom_6
          ];
          $request->session()->put('arr_counted_dashboard', $arr_counted_dashboard);
        }
        catch(Throwable $e){
            $request->session()->put('arr_counted_dashboard', false);
        }

        return $next($request);
    }
}
