<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\Handler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use PhpOffice\PhpWord\PhpWord;
use \PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Writer\Word2007;
use App\Models\User;
use App\Models\DocObl;
use Carbon\Carbon;
use DataTables;

class RewardsController extends Controller
{
    public function witelObl(Request $request){
      // dd($request->all());
      if($request->ajax()){
        $query = DB::connection('pgsql')->table('form_obl')
        ->select(
          'f1_witel',
          DB::raw("sum(1) as total"), // jumlah dokumen
          DB::raw("sum(case when f1_proses = 'cancel' then 1 else 0 end) as total_cancel"), // total dokumen cancel
          DB::raw("sum(case when f1_proses = 'done' then 1 else 0 end) as total_done"), // total dokumen done
          DB::raw("sum(case when f1_proses = 'obl' then 1 else 0 end) as total_obl"), // total dokumen done
          DB::raw("sum(case when f1_proses = 'witel' then 1 else 0 end) as total_witel"), // total dokumen done
          DB::raw("sum(case when revisi_witel = true then 1 else 0 end) as total_rev_now"), // jumlah dokumen revisi saat ini
          DB::raw("sum(case when revisi_witel_count > 0 then 1 else 0 end) as total_doc_rev"), // total dokumen revisi
          DB::raw("sum(revisi_witel_count) as total_prs_rev") // total proses revisi
          )
        ->whereRaw("
        f1_witel is not null and
        (deleted_at is null or to_char(deleted_at,'yyyy-mm-dd') = '') and deleted_by is null
        and is_draf <> 8
        ");

        $query2 = DB::connection('pgsql')->table('form_pralop')
        ->select(
          'lop_witel',
          DB::raw("sum(1) as total"),
          DB::raw("sum(case when on_handling = 'witel' then 1 else 0 end) as total_witel"),
          DB::raw("sum(case when on_handling = 'solution' then 1 else 0 end) as total_solution"),
          DB::raw("sum(case when on_handling = 'legal' then 1 else 0 end) as total_legal"),
          DB::raw("sum(case when on_handling = 'final_pralop' then 1 else 0 end) as total_final_pralop"),
          DB::raw("sum(case when lop_count_revisi > 0 then 1 else 0 end) as total_doc_rev"),
          DB::raw("sum(lop_count_revisi) as total_prs_rev")
        );

        $obl = $query->groupBy('f1_witel')->orderBy('f1_witel','asc')->get()->toArray();
        $pralop = $query2->groupBy('lop_witel')->orderBy('lop_witel','asc')->get()->toArray();
        $data = [
          'obl' => $obl,
          'pralop' => $pralop
        ];

        return response()->json($data);
      }
      $user_in_is = User::leftJoin('user_role','user_role.user_id','=','users.id')
      ->leftJoin('witels','witels.id','=','users.witel_id')
      ->leftJoin('user_mitra','user_mitra.user_id','=','users.id')
      ->leftJoin('mitras','mitras.id','=','user_mitra.mitra_id')
      ->select('users.id','user_role.role_id','users.witel_id','witels.nama_witel','mitras.nama_mitra','mitras.id as mitra_id')
      ->where('users.id',Auth::id())->first();
      return view('pages.reward.witel.index',compact('user_in_is'));
    }
}
