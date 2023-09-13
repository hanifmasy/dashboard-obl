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
      if( $request->ajax() ){

          $counted_dashboard_top_1 = DB::connection('pgsql')->table('form_obl')->whereRaw(" is_draf not in (7,8) and deleted_at is null and f1_proses = 'cancel' ");
          $counted_dashboard_top_2 = DB::connection('pgsql')->table('form_obl')->whereRaw(" is_draf not in (7,8) and deleted_at is null ");

          $counted_dashboard_bottom_1 = DB::connection('pgsql')->table('form_obl')->whereRaw(" is_draf not in (7,8) and deleted_at is null and f1_proses = 'witel' ");
          $timed_dashboard_bottom_1 = DB::connection('pgsql')->table('form_obl')->select(DB::raw("to_char(updated_at,'YYYY-MM-DD HH24:MI:SS') as tgl"))->whereRaw(" is_draf not in (7,8) and deleted_at is null and f1_proses = 'witel' ");
          $counted_dashboard_bottom_2 = DB::connection('pgsql')->table('form_obl')->whereRaw(" is_draf not in (7,8) and deleted_at is null and f1_proses in ('obl','pjm') ");
          $timed_dashboard_bottom_2 = DB::connection('pgsql')->table('form_obl')->select(DB::raw("to_char(updated_at,'YYYY-MM-DD HH24:MI:SS') as tgl"))->whereRaw(" is_draf not in (7,8) and deleted_at is null and f1_proses in ('obl','pjm') ");
          $counted_dashboard_bottom_3 = DB::connection('pgsql')->table('form_obl')->whereRaw(" is_draf not in (7,8) and deleted_at is null and f1_proses = 'legal' ");
          $timed_dashboard_bottom_3 = DB::connection('pgsql')->table('form_obl')->select(DB::raw("to_char(updated_at,'YYYY-MM-DD HH24:MI:SS') as tgl"))->whereRaw(" is_draf not in (7,8) and deleted_at is null and f1_proses = 'legal' ");
          $counted_dashboard_bottom_4 = DB::connection('pgsql')->table('form_obl')->whereRaw(" is_draf not in (7,8) and deleted_at is null and f1_proses in ('mitra_obl','mitra_pjm') ");
          $timed_dashboard_bottom_4 = DB::connection('pgsql')->table('form_obl')->select(DB::raw("to_char(updated_at,'YYYY-MM-DD HH24:MI:SS') as tgl"))->whereRaw(" is_draf not in (7,8) and deleted_at is null and f1_proses in ('mitra_obl','mitra_pjm') ");
          $counted_dashboard_bottom_5 = DB::connection('pgsql')->table('form_obl')->whereRaw(" is_draf not in (7,8) and deleted_at is null and f1_proses = 'close_sm' ");
          $timed_dashboard_bottom_5 = DB::connection('pgsql')->table('form_obl')->select(DB::raw("to_char(updated_at,'YYYY-MM-DD HH24:MI:SS') as tgl"))->whereRaw(" is_draf not in (7,8) and deleted_at is null and f1_proses = 'close_sm' ");
          $counted_dashboard_bottom_6 = DB::connection('pgsql')->table('form_obl')->whereRaw(" is_draf not in (7,8) and deleted_at is null and f1_proses = 'done' ");
          $timed_dashboard_bottom_6 = DB::connection('pgsql')->table('form_obl')->select(DB::raw("to_char(updated_at,'YYYY-MM-DD HH24:MI:SS') as tgl"))->whereRaw(" is_draf not in (7,8) and deleted_at is null and f1_proses = 'done' ");

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
            if($is_user !== 4 && $is_user !== 5 && $is_user !== 6){
              if( $request->fl_witel ){
                $counted_dashboard_top_1->where('f1_witel',$request->fl_witel);
                $counted_dashboard_top_2->where('f1_witel',$request->fl_witel);
                $counted_dashboard_bottom_1->where('f1_witel',$request->fl_witel);
                $timed_dashboard_bottom_1->where('f1_witel',$request->fl_witel);
                $counted_dashboard_bottom_2->where('f1_witel',$request->fl_witel);
                $timed_dashboard_bottom_2->where('f1_witel',$request->fl_witel);
                $counted_dashboard_bottom_3->where('f1_witel',$request->fl_witel);
                $timed_dashboard_bottom_3->where('f1_witel',$request->fl_witel);
                $counted_dashboard_bottom_4->where('f1_witel',$request->fl_witel);
                $timed_dashboard_bottom_4->where('f1_witel',$request->fl_witel);
                $counted_dashboard_bottom_5->where('f1_witel',$request->fl_witel);
                $timed_dashboard_bottom_5->where('f1_witel',$request->fl_witel);
                $counted_dashboard_bottom_6->where('f1_witel',$request->fl_witel);
                $timed_dashboard_bottom_6->where('f1_witel',$request->fl_witel);
              }
              if( $request->fl_mitra ){
                $counted_dashboard_top_1->where('f1_mitra_id',$request->fl_mitra);
                $counted_dashboard_top_2->where('f1_mitra_id',$request->fl_mitra);
                $counted_dashboard_bottom_1->where('f1_mitra_id',$request->fl_mitra);
                $timed_dashboard_bottom_1->where('f1_mitra_id',$request->fl_mitra);
                $counted_dashboard_bottom_2->where('f1_mitra_id',$request->fl_mitra);
                $timed_dashboard_bottom_2->where('f1_mitra_id',$request->fl_mitra);
                $counted_dashboard_bottom_3->where('f1_mitra_id',$request->fl_mitra);
                $timed_dashboard_bottom_3->where('f1_mitra_id',$request->fl_mitra);
                $counted_dashboard_bottom_4->where('f1_mitra_id',$request->fl_mitra);
                $timed_dashboard_bottom_4->where('f1_mitra_id',$request->fl_mitra);
                $counted_dashboard_bottom_5->where('f1_mitra_id',$request->fl_mitra);
                $timed_dashboard_bottom_5->where('f1_mitra_id',$request->fl_mitra);
                $counted_dashboard_bottom_6->where('f1_mitra_id',$request->fl_mitra);
                $timed_dashboard_bottom_6->where('f1_mitra_id',$request->fl_mitra);
              }
            }
          }
          if( $request->fl_tahun ){
            $counted_dashboard_top_1->where(DB::raw("to_char(created_at,'yyyy')"),'=',$request->fl_tahun);
            $counted_dashboard_top_2->where(DB::raw("to_char(created_at,'yyyy')"),'=',$request->fl_tahun);
            $counted_dashboard_bottom_1->where(DB::raw("to_char(created_at,'yyyy')"),'=',$request->fl_tahun);
            $timed_dashboard_bottom_1->where(DB::raw("to_char(created_at,'yyyy')"),'=',$request->fl_tahun);
            $counted_dashboard_bottom_2->where(DB::raw("to_char(created_at,'yyyy')"),'=',$request->fl_tahun);
            $timed_dashboard_bottom_2->where(DB::raw("to_char(created_at,'yyyy')"),'=',$request->fl_tahun);
            $counted_dashboard_bottom_3->where(DB::raw("to_char(created_at,'yyyy')"),'=',$request->fl_tahun);
            $timed_dashboard_bottom_3->where(DB::raw("to_char(created_at,'yyyy')"),'=',$request->fl_tahun);
            $counted_dashboard_bottom_4->where(DB::raw("to_char(created_at,'yyyy')"),'=',$request->fl_tahun);
            $timed_dashboard_bottom_4->where(DB::raw("to_char(created_at,'yyyy')"),'=',$request->fl_tahun);
            $counted_dashboard_bottom_5->where(DB::raw("to_char(created_at,'yyyy')"),'=',$request->fl_tahun);
            $timed_dashboard_bottom_5->where(DB::raw("to_char(created_at,'yyyy')"),'=',$request->fl_tahun);
            $counted_dashboard_bottom_6->where(DB::raw("to_char(created_at,'yyyy')"),'=',$request->fl_tahun);
            $timed_dashboard_bottom_6->where(DB::raw("to_char(created_at,'yyyy')"),'=',$request->fl_tahun);
          }
          if( $request->fl_plggn ){
            $counted_dashboard_top_1->where('f1_nama_plggn',$request->fl_plggn);
            $counted_dashboard_top_2->where('f1_nama_plggn',$request->fl_plggn);
            $counted_dashboard_bottom_1->where('f1_nama_plggn',$request->fl_plggn);
            $timed_dashboard_bottom_1->where('f1_nama_plggn',$request->fl_plggn);
            $counted_dashboard_bottom_2->where('f1_nama_plggn',$request->fl_plggn);
            $timed_dashboard_bottom_2->where('f1_nama_plggn',$request->fl_plggn);
            $counted_dashboard_bottom_3->where('f1_nama_plggn',$request->fl_plggn);
            $timed_dashboard_bottom_3->where('f1_nama_plggn',$request->fl_plggn);
            $counted_dashboard_bottom_4->where('f1_nama_plggn',$request->fl_plggn);
            $timed_dashboard_bottom_4->where('f1_nama_plggn',$request->fl_plggn);
            $counted_dashboard_bottom_5->where('f1_nama_plggn',$request->fl_plggn);
            $timed_dashboard_bottom_5->where('f1_nama_plggn',$request->fl_plggn);
            $counted_dashboard_bottom_6->where('f1_nama_plggn',$request->fl_plggn);
            $timed_dashboard_bottom_6->where('f1_nama_plggn',$request->fl_plggn);
          }
          if( $request->fl_segmen ){
            $counted_dashboard_top_1->where('f1_segmen',$request->fl_segmen);
            $counted_dashboard_top_2->where('f1_segmen',$request->fl_segmen);
            $counted_dashboard_bottom_1->where('f1_segmen',$request->fl_segmen);
            $timed_dashboard_bottom_1->where('f1_segmen',$request->fl_segmen);
            $counted_dashboard_bottom_2->where('f1_segmen',$request->fl_segmen);
            $timed_dashboard_bottom_2->where('f1_segmen',$request->fl_segmen);
            $counted_dashboard_bottom_3->where('f1_segmen',$request->fl_segmen);
            $timed_dashboard_bottom_3->where('f1_segmen',$request->fl_segmen);
            $counted_dashboard_bottom_4->where('f1_segmen',$request->fl_segmen);
            $timed_dashboard_bottom_4->where('f1_segmen',$request->fl_segmen);
            $counted_dashboard_bottom_5->where('f1_segmen',$request->fl_segmen);
            $timed_dashboard_bottom_5->where('f1_segmen',$request->fl_segmen);
            $counted_dashboard_bottom_6->where('f1_segmen',$request->fl_segmen);
            $timed_dashboard_bottom_6->where('f1_segmen',$request->fl_segmen);
          }
          if( $request->fl_status ){
            $counted_dashboard_top_1->where('f1_jenis_kontrak',$request->fl_status);
            $counted_dashboard_top_2->where('f1_jenis_kontrak',$request->fl_status);
            $counted_dashboard_bottom_1->where('f1_jenis_kontrak',$request->fl_status);
            $timed_dashboard_bottom_1->where('f1_jenis_kontrak',$request->fl_status);
            $counted_dashboard_bottom_2->where('f1_jenis_kontrak',$request->fl_status);
            $timed_dashboard_bottom_2->where('f1_jenis_kontrak',$request->fl_status);
            $counted_dashboard_bottom_3->where('f1_jenis_kontrak',$request->fl_status);
            $timed_dashboard_bottom_3->where('f1_jenis_kontrak',$request->fl_status);
            $counted_dashboard_bottom_4->where('f1_jenis_kontrak',$request->fl_status);
            $timed_dashboard_bottom_4->where('f1_jenis_kontrak',$request->fl_status);
            $counted_dashboard_bottom_5->where('f1_jenis_kontrak',$request->fl_status);
            $timed_dashboard_bottom_5->where('f1_jenis_kontrak',$request->fl_status);
            $counted_dashboard_bottom_6->where('f1_jenis_kontrak',$request->fl_status);
            $timed_dashboard_bottom_6->where('f1_jenis_kontrak',$request->fl_status);
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

          if( $timed_bottom_1 ){ $timed_bottom_1->tgl = Carbon::createFromTimeStamp(strtotime( $timed_bottom_1->tgl  ))->diffForHumans(); }else{ $timed_bottom_1 = null; }
          if( $timed_bottom_2 ){ $timed_bottom_2->tgl = Carbon::createFromTimeStamp(strtotime( $timed_bottom_2->tgl  ))->diffForHumans(); }else{ $timed_bottom_2 = null; }
          if( $timed_bottom_3 ){ $timed_bottom_3->tgl = Carbon::createFromTimeStamp(strtotime( $timed_bottom_3->tgl  ))->diffForHumans(); }else{ $timed_bottom_3 = null; }
          if( $timed_bottom_4 ){ $timed_bottom_4->tgl = Carbon::createFromTimeStamp(strtotime( $timed_bottom_4->tgl  ))->diffForHumans(); }else{ $timed_bottom_4 = null; }
          if( $timed_bottom_5 ){ $timed_bottom_5->tgl = Carbon::createFromTimeStamp(strtotime( $timed_bottom_5->tgl  ))->diffForHumans(); }else{ $timed_bottom_5 = null; }
          if( $timed_bottom_6 ){ $timed_bottom_6->tgl = Carbon::createFromTimeStamp(strtotime( $timed_bottom_6->tgl  ))->diffForHumans(); }else{ $timed_bottom_6 = null; }

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

          return response()->json($arr_counted_dashboard);
      }
      $user_masuk = User::leftJoin('user_role as ur','ur.user_id','=','users.id')->leftJoin('roles as r','r.id','=','ur.role_id')
      ->select('users.id','users.nama_lengkap','ur.role_id','r.nama_role')
      ->where('users.id',Auth::user()->id)
      ->first();

      $witels = DB::connection('pgsql')->table('witels')->select('nama_witel')->get()->toArray();
      $tahuns = DB::connection('pgsql')->table('form_obl')->select(DB::raw("to_char(created_at,'yyyy') as tahun"))->groupBy('tahun')->orderByRaw("CASE WHEN to_char(created_at,'yyyy') IS NULL THEN 0 ELSE 1 END DESC")->orderBy('tahun','DESC')->get()->toArray();
      $mitras = DB::connection('pgsql')->table('mitras')->select('id','nama_mitra')->get()->toArray();
      $plggns = DB::connection('pgsql')->table('form_obl')->select('f1_nama_plggn')->groupBy('f1_nama_plggn')->orderByRaw("CASE WHEN f1_nama_plggn IS NULL THEN 0 ELSE 1 END DESC")->orderBy('f1_nama_plggn','DESC')->get()->toArray();
      $segmens = DB::connection('pgsql')->table('form_obl')->select('f1_segmen')->groupBy('f1_segmen')->orderByRaw("CASE WHEN f1_segmen IS NULL THEN 0 ELSE 1 END DESC")->orderBy('f1_segmen','DESC')->get()->toArray();
      $statuses = DB::connection('pgsql')->table('form_obl')->select('f1_jenis_kontrak',DB::raw("case when f1_jenis_kontrak = 'perpanjangan' then 'Amandemen' when f1_jenis_kontrak = 'baru' then 'Baru' end as jenis_kontrak"))->whereRaw(" f1_jenis_kontrak in ('perpanjangan','baru') ")->groupBy('f1_jenis_kontrak','jenis_kontrak')->orderByRaw("CASE WHEN f1_jenis_kontrak IS NULL THEN 0 ELSE 1 END DESC")->orderBy('f1_jenis_kontrak','DESC')->get()->toArray();

      return view('dashboard.index',compact('user_masuk','witels','tahuns','mitras','plggns','segmens','statuses'));
    }

    public function excel(Request $request){
      dd( $request->all() );
    }
}
