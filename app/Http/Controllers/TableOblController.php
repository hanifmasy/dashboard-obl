<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\Handler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\MitraVendor;
use App\Models\DocObl;
use Carbon\Carbon;
use DataTables;
use Rap2hpoutre\FastExcel\FastExcel;

class TableOblController extends Controller
{
    public function tables(Request $request){
      if($request->ajax()){
        $user_in_is = User::leftJoin('user_role','user_role.user_id','=','users.id')
        ->leftJoin('witels','witels.id','=','users.witel_id')
        ->leftJoin('user_mitra','user_mitra.user_id','=','users.id')
        ->leftJoin('mitras','mitras.id','=','user_mitra.mitra_id')
        ->select('users.id','user_role.role_id','users.witel_id','witels.nama_witel','mitras.nama_mitra','mitras.id as mitra_id')->where('users.id',Auth::id())->first();

        $query=null;
        if($user_in_is->role_id !== 4 && $user_in_is->role_id !== 5 && $user_in_is->role_id !== 6){
          $query = DocObl::leftJoin('users as u','u.id','=','obl.created_by')
          ->leftJoin('users as uu','uu.id','=','obl.updated_by')
          ->leftJoin('mitras','mitras.id','=','obl.f1_mitra_id')
          ->select(
                    'obl.id as obl_id',
                    'obl.revisi_witel as is_revisi',
                    DB::raw("
                    case
                    when f1_proses is null or f1_proses = '' then ''
                    else f1_proses
                    end as proses"),
                    DB::raw("
                    case
                    when submit like 'draf_filter_%' then 'filter'
                    when submit like 'draf_p%' then 'form'
                    when submit in ('draf_wo','draf_sp','draf_kl') then 'kontrak1'
                    when submit in ('submit_wo','submit_sp','submit_kl') then 'kontrak2'
                    when submit in (
                      'am_submit','am_edit','am_form_p0-p1','am_file_p0','am_file_p1','am_revisi',
                      'solution_submit','solution_edit','solution_form_p0-p1','solution_file_p0','solution_file_p1'
                    ) then 'kontrak3'
                    when submit in ('obl_submit','obl_lampiran','obl_edit') then 'kontrak4'
                    else ''
                    end as filter_submit"),
                    DB::raw("replace(submit,'_',' ') as string_submit"),
                    DB::raw("case when f1_segmen is null or f1_segmen = '' then '' else f1_segmen end as segmen"),
                    DB::raw("case when f1_folder is null or f1_folder = '' then '' else f1_folder end as folder"),
                    DB::raw("to_char(obl.created_at,'YYYY-MM-DD HH24:MI') as string_tgl_submit"),
                    DB::raw("to_char(obl.updated_at,'YYYY-MM-DD HH24:MI') as string_tgl_update"),
                    DB::raw("case when f1_jenis_spk is null or f1_jenis_spk = '' then '' else f1_jenis_spk end as jenis_spk"),
                    DB::raw("case when f1_witel is null or f1_witel = '' then '' else f1_witel end as witel"),
                    DB::raw("case when f1_nama_plggn is null or f1_nama_plggn = '' then '' else f1_nama_plggn end as nama_plggn"),
                    DB::raw("
                    case
                    when f1_judul_projek is null or f1_judul_projek = '' then ''
                    else f1_judul_projek
                    end as layanan
                    "),
                    DB::raw("case when mitras.nama_mitra is null or mitras.nama_mitra = '' then '' else mitras.nama_mitra end as nama_vendor"),
                    'f1_masa_layanan_tahun as masa_layanan_tahun',
                    'f1_masa_layanan_bulan as masa_layanan_bulan',
                    'f1_masa_layanan_hari as masa_layanan_hari',
                    DB::raw("case when f1_nilai_kb is null or f1_nilai_kb = '' then '' else f1_nilai_kb end as nilai_kb"),
                    DB::raw("case when f1_no_kfs_spk is null or f1_no_kfs_spk = '' then '' else f1_no_kfs_spk end as no_kfs_spk"),
                    DB::raw("
                    case
                    when (wo_takah_wo is null or wo_takah_wo = '') and (sp_takah_sp is null or sp_takah_sp = '') then kl_takah_kl
                    when (wo_takah_wo is null or wo_takah_wo = '') and (kl_takah_kl is null or kl_takah_kl = '') then sp_takah_sp
                    when (kl_takah_kl is null or kl_takah_kl = '') and (sp_takah_sp is null or sp_takah_sp = '') then wo_takah_wo
                    else '-'
                    end as no_kontrak
                    "),
                    DB::raw("case when f1_jenis_kontrak is null or f1_jenis_kontrak = '' then '' else f1_jenis_kontrak end as jenis_kontrak"),
                    DB::raw("case when f1_quote_kontrak is null or f1_quote_kontrak = '' then '' else f1_quote_kontrak end as quote_kontrak"),
                    DB::raw("case when f1_nomor_akun is null or f1_nomor_akun = '' then '' else f1_nomor_akun end as nomor_akun"),
                    DB::raw("case when f1_skema_bayar is null or f1_skema_bayar = '' then '' else f1_skema_bayar end as skema_bayar"),
                    DB::raw("case when f1_status_order is null or f1_status_order = '' then '' else f1_status_order end as status_order"),
                    DB::raw("case when f1_tgl_keterangan is null then null else to_char(f1_tgl_keterangan,'YYYY-MM-DD HH24:MI') end as tgl_keterangan"),
                    DB::raw("case when f1_keterangan is null or f1_keterangan = '' then '' else f1_keterangan end as keterangan"),
                    DB::raw("case when obl.revisi_witel_count is null then 0 else obl.revisi_witel_count end as revisi_count"),
                    DB::raw("u.nama_lengkap as user_create"),
                    DB::raw("uu.nama_lengkap as user_update")
                  );
        }

        // WITEL
        if($user_in_is->role_id == 4 || $user_in_is->role_id == 5 ){
          $query = DocObl::leftJoin('users as u','u.id','=','obl.created_by')
          ->leftJoin('users as uu','uu.id','=','obl.updated_by')
          ->leftJoin('mitras','mitras.id','=','obl.f1_mitra_id')
          ->select(
                    'obl.id as obl_id',
                    'obl.revisi_witel as is_revisi',
                    DB::raw("
                    case
                    when f1_proses is null or f1_proses = '' then ''
                    else f1_proses
                    end as proses"),
                    DB::raw("
                    case
                    when submit like 'draf_filter_%' then 'filter'
                    when submit like 'draf_p%' then 'form'
                    when submit in ('draf_wo','draf_sp','draf_kl') then 'kontrak1'
                    when submit in ('submit_wo','submit_sp','submit_kl') then 'kontrak2'
                    when submit in (
                      'am_submit','am_edit','am_form_p0-p1','am_file_p0','am_file_p1','am_revisi',
                      'solution_submit','solution_edit','solution_form_p0-p1','solution_file_p0','solution_file_p1'
                    ) then 'kontrak3'
                    when submit in ('obl_submit','obl_lampiran','obl_edit') then 'kontrak4'
                    else ''
                    end as filter_submit"),
                    DB::raw("replace(submit,'_',' ') as string_submit"),
                    DB::raw("case when f1_segmen is null or f1_segmen = '' then '' else f1_segmen end as segmen"),
                    DB::raw("case when f1_folder is null or f1_folder = '' then '' else f1_folder end as folder"),
                    DB::raw("to_char(obl.created_at,'YYYY-MM-DD HH24:MI') as string_tgl_submit"),
                    DB::raw("to_char(obl.updated_at,'YYYY-MM-DD HH24:MI') as string_tgl_update"),
                    DB::raw("case when f1_jenis_spk is null or f1_jenis_spk = '' then '' else f1_jenis_spk end as jenis_spk"),
                    DB::raw("case when f1_witel is null or f1_witel = '' then '' else f1_witel end as witel"),
                    DB::raw("case when f1_nama_plggn is null or f1_nama_plggn = '' then '' else f1_nama_plggn end as nama_plggn"),
                    DB::raw("
                    case
                    when f1_judul_projek is null or f1_judul_projek = '' then ''
                    else f1_judul_projek
                    end as layanan
                    "),
                    DB::raw("case when mitras.nama_mitra is null or mitras.nama_mitra = '' then '' else mitras.nama_mitra end as nama_vendor"),
                    'f1_masa_layanan_tahun as masa_layanan_tahun',
                    'f1_masa_layanan_bulan as masa_layanan_bulan',
                    'f1_masa_layanan_hari as masa_layanan_hari',
                    DB::raw("case when f1_nilai_kb is null or f1_nilai_kb = '' then '' else f1_nilai_kb end as nilai_kb"),
                    DB::raw("case when f1_no_kfs_spk is null or f1_no_kfs_spk = '' then '' else f1_no_kfs_spk end as no_kfs_spk"),
                    DB::raw("
                    case
                    when (wo_takah_wo is null or wo_takah_wo = '') and (sp_takah_sp is null or sp_takah_sp = '') then kl_takah_kl
                    when (wo_takah_wo is null or wo_takah_wo = '') and (kl_takah_kl is null or kl_takah_kl = '') then sp_takah_sp
                    when (kl_takah_kl is null or kl_takah_kl = '') and (sp_takah_sp is null or sp_takah_sp = '') then wo_takah_wo
                    else '-'
                    end as no_kontrak
                    "),
                    DB::raw("case when f1_jenis_kontrak is null or f1_jenis_kontrak = '' then '' else f1_jenis_kontrak end as jenis_kontrak"),
                    DB::raw("case when f1_quote_kontrak is null or f1_quote_kontrak = '' then '' else f1_quote_kontrak end as quote_kontrak"),
                    DB::raw("case when f1_nomor_akun is null or f1_nomor_akun = '' then '' else f1_nomor_akun end as nomor_akun"),
                    DB::raw("case when f1_skema_bayar is null or f1_skema_bayar = '' then '' else f1_skema_bayar end as skema_bayar"),
                    DB::raw("case when f1_status_order is null or f1_status_order = '' then '' else f1_status_order end as status_order"),
                    DB::raw("case when f1_tgl_keterangan is null then null else to_char(f1_tgl_keterangan,'YYYY-MM-DD HH24:MI') end as tgl_keterangan"),
                    DB::raw("case when f1_keterangan is null or f1_keterangan = '' then '' else f1_keterangan end as keterangan"),
                    DB::raw("case when obl.revisi_witel_count is null then 0 else obl.revisi_witel_count end as revisi_count"),
                    DB::raw("u.nama_lengkap as user_create"),
                    DB::raw("uu.nama_lengkap as user_update")
                  )->where('obl.f1_witel',$user_in_is->nama_witel);
        }
        // MITRA
        if($user_in_is->role_id == 6){
          $query = DocObl::leftJoin('users as u','u.id','=','obl.created_by')
          ->leftJoin('users as uu','uu.id','=','obl.updated_by')
          ->leftJoin('mitras','mitras.id','=','obl.f1_mitra_id')
          ->select(
                    'obl.id as obl_id',
                    'obl.revisi_witel as is_revisi',
                    DB::raw("
                    case
                    when f1_proses is null or f1_proses = '' then ''
                    else f1_proses
                    end as proses"),
                    DB::raw("
                    case
                    when submit like 'draf_filter_%' then 'filter'
                    when submit like 'draf_p%' then 'form'
                    when submit in ('draf_wo','draf_sp','draf_kl') then 'kontrak1'
                    when submit in ('submit_wo','submit_sp','submit_kl') then 'kontrak2'
                    when submit in (
                      'am_submit','am_edit','am_form_p0-p1','am_file_p0','am_file_p1','am_revisi',
                      'solution_submit','solution_edit','solution_form_p0-p1','solution_file_p0','solution_file_p1'
                    ) then 'kontrak3'
                    when submit in ('obl_submit','obl_lampiran','obl_edit') then 'kontrak4'
                    else ''
                    end as filter_submit"),
                    DB::raw("replace(submit,'_',' ') as string_submit"),
                    DB::raw("case when f1_segmen is null or f1_segmen = '' then '' else f1_segmen end as segmen"),
                    DB::raw("case when f1_folder is null or f1_folder = '' then '' else f1_folder end as folder"),
                    DB::raw("to_char(obl.created_at,'YYYY-MM-DD HH24:MI') as string_tgl_submit"),
                    DB::raw("to_char(obl.updated_at,'YYYY-MM-DD HH24:MI') as string_tgl_update"),
                    DB::raw("case when f1_jenis_spk is null or f1_jenis_spk = '' then '' else f1_jenis_spk end as jenis_spk"),
                    DB::raw("case when f1_witel is null or f1_witel = '' then '' else f1_witel end as witel"),
                    DB::raw("case when f1_nama_plggn is null or f1_nama_plggn = '' then '' else f1_nama_plggn end as nama_plggn"),
                    DB::raw("
                    case
                    when f1_judul_projek is null or f1_judul_projek = '' then ''
                    else f1_judul_projek
                    end as layanan
                    "),
                    DB::raw("case when mitras.nama_mitra is null or mitras.nama_mitra = '' then '' else mitras.nama_mitra end as nama_vendor"),
                    'f1_masa_layanan_tahun as masa_layanan_tahun',
                    'f1_masa_layanan_bulan as masa_layanan_bulan',
                    'f1_masa_layanan_hari as masa_layanan_hari',
                    DB::raw("case when f1_nilai_kb is null or f1_nilai_kb = '' then '' else f1_nilai_kb end as nilai_kb"),
                    DB::raw("case when f1_no_kfs_spk is null or f1_no_kfs_spk = '' then '' else f1_no_kfs_spk end as no_kfs_spk"),
                    DB::raw("
                    case
                    when (wo_takah_wo is null or wo_takah_wo = '') and (sp_takah_sp is null or sp_takah_sp = '') then kl_takah_kl
                    when (wo_takah_wo is null or wo_takah_wo = '') and (kl_takah_kl is null or kl_takah_kl = '') then sp_takah_sp
                    when (kl_takah_kl is null or kl_takah_kl = '') and (sp_takah_sp is null or sp_takah_sp = '') then wo_takah_wo
                    else '-'
                    end as no_kontrak
                    "),
                    DB::raw("case when f1_jenis_kontrak is null or f1_jenis_kontrak = '' then '' else f1_jenis_kontrak end as jenis_kontrak"),
                    DB::raw("case when f1_quote_kontrak is null or f1_quote_kontrak = '' then '' else f1_quote_kontrak end as quote_kontrak"),
                    DB::raw("case when f1_nomor_akun is null or f1_nomor_akun = '' then '' else f1_nomor_akun end as nomor_akun"),
                    DB::raw("case when f1_skema_bayar is null or f1_skema_bayar = '' then '' else f1_skema_bayar end as skema_bayar"),
                    DB::raw("case when f1_status_order is null or f1_status_order = '' then '' else f1_status_order end as status_order"),
                    DB::raw("case when f1_tgl_keterangan is null then null else to_char(f1_tgl_keterangan,'YYYY-MM-DD HH24:MI') end as tgl_keterangan"),
                    DB::raw("case when f1_keterangan is null or f1_keterangan = '' then '' else f1_keterangan end as keterangan"),
                    DB::raw("case when obl.revisi_witel_count is null then 0 else obl.revisi_witel_count end as revisi_count"),
                    DB::raw("u.nama_lengkap as user_create"),
                    DB::raw("uu.nama_lengkap as user_update")
                  )->where('obl.f1_mitra_id',$user_in_is->mitra_id);
        }

        $ajx_gdt = null;
        if($request->ajx_gdt){ $ajx_gdt = $request->ajx_gdt; }
        if($ajx_gdt){
          if($ajx_gdt==='top_1'){ $query->whereRaw(" obl.f1_proses = 'cancel' "); }
          if($ajx_gdt==='bottom_1'){ $query->whereRaw(" obl.f1_proses = 'witel' "); }
          if($ajx_gdt==='bottom_2'){ $query->whereRaw(" obl.f1_proses = 'obl' "); }
          if($ajx_gdt==='bottom_3'){ $query->whereRaw(" obl.f1_proses = 'legal' "); }
          if($ajx_gdt==='bottom_4'){ $query->whereRaw(" obl.f1_proses = 'mitra_obl' "); }
          if($ajx_gdt==='bottom_5'){ $query->whereRaw(" obl.f1_proses = 'close_sm' "); }
          if($ajx_gdt==='bottom_6'){ $query->whereRaw(" obl.f1_proses = 'done' "); }
        }
        $cl = null;
        if($request->ajx_cl){ $cl = $request->ajx_cl; }
        if($cl){
          if($cl==='b'){ $query->whereRaw(" obl.f1_proses = 'cancel' "); }
          if($cl==='c'){ $query->whereRaw(" obl.f1_proses = 'done' "); }
          if($cl==='d'){ $query->whereRaw(" obl.f1_proses = 'obl' "); }
          if($cl==='e'){ $query->whereRaw(" obl.f1_proses = 'witel' "); }
          if($cl==='f'){ $query->whereRaw(" obl.revisi_witel = true "); }
          if($cl==='g'){ $query->whereRaw(" obl.revisi_witel_count > 0 "); }
          if($cl==='h'){ $query->whereRaw(" obl.revisi_witel_count > 0 "); }
        }
        $wl = null;
        if($request->ajx_wl){ $wl = $request->ajx_wl; }
        if($wl){
          if( ($user_in_is->role_id == 4 || $user_in_is->role_id == 5) && $user_in_is->nama_witel === $wl){
            $query->whereRaw(" obl.f1_witel = '$wl' ");
          }
          else if( !$user_in_is->nama_witel && $user_in_is->role_id !== 6 && $user_in_is->role_id !== 4 && $user_in_is->role_id !== 5 ){
            if($wl==='BALIKPAPAN'){ $query->whereRaw(" obl.f1_witel = 'BALIKPAPAN' "); }
            if($wl==='SAMARINDA'){ $query->whereRaw(" obl.f1_witel = 'SAMARINDA' "); }
            if($wl==='KALBAR'){ $query->whereRaw(" obl.f1_witel = 'KALBAR' "); }
            if($wl==='KALSEL'){ $query->whereRaw(" obl.f1_witel = 'KALSEL' "); }
            if($wl==='KALTENG'){ $query->whereRaw(" obl.f1_witel = KALTENG "); }
            if($wl==='KALTARA'){ $query->whereRaw(" obl.f1_witel = KALTARA "); }
          }
        }

        $data = $query->whereRaw(" obl.deleted_at is null or to_char(obl.deleted_at,'yyyy-mm-dd') = '' ")
          ->orderBy('obl.created_at','DESC')
          ->orderBy('obl.updated_at','DESC')
          ->get();
        return DataTables::of($data)->addIndexColumn()->make(true);
      }
      $gdt = null;
      if($request->gdt){ $gdt = Crypt::decrypt($request->gdt); }
      $cl = null;
      if($request->cl){ $cl = Crypt::decryptString($request->cl); }
      $wl = null;
      if($request->wl){ $wl = $request->wl; }
      return view('pages.obls.tables',compact('gdt','cl','wl'));
    }

    public function delete(Request $request)
    {
      if($request->obl_doc_action){
        if(strpos($request->obl_doc_action,'delete_') !== false){
          $delete_id = substr($request->obl_doc_action,7,strlen($request->obl_doc_action)-7);
          $delete_id = intval($delete_id);
          $delete_status = DocObl::where('id',$delete_id)->update([
            'deleted_at'=> Carbon::now()->translatedFormat('Y-m-d H:i:s'),
            'deleted_by'=> Auth::id()
          ]);

          if($delete_status){ return redirect()->route('obl.tables'); }
          else{ return redirect()->route('obl.tables')->with('status', 'Oops! Gagal Hapus Dokumen OBL.'); }
        }
        else {
          return redirect('obl-tables')->with('status', 'Oops! Something Went Wrong.');
        }
      }
      else{
        return redirect('obl-tables')->with('status', 'Oops! Wrong Routing.');
      }
    }

    public function multidelete(Request $request)
    {
      // dd($request->all());
      if($request->multi_obl_ids && $request->status_perintah){
        if($request->status_perintah == 'multi_delete_ids'){
          $multi_delete_ids = $request->multi_obl_ids;
          try{
            $multi_delete_status = DocObl::whereIn('id',$multi_delete_ids)->update([
              'deleted_at'=> Carbon::now()->translatedFormat('Y-m-d H:i:s'),
              'deleted_by'=> Auth::id()
            ]);

            if($multi_delete_status){ return redirect()->route('obl.tables'); }
            else{ return redirect()->route('obl.tables')->with('status', 'Oops! Gagal Hapus Data Tabel Dokumen OBL.'); }
          }
          catch(Throwable $e){
            return back()->with('status','Oops! Gagal Hapus Data Tabel Dokumen OBL.');
          }
        }
        else {
          return redirect('obl-tables')->with('status', 'Oops! Wrong Routing.');
        }
      }
      else{
        return redirect('obl-tables')->with('status', 'Oops! Wrong Routing.');
      }
    }

    public function excel(Request $request)
    {
      // dd($request->all());
      // return redirect('obl-tables')->with('status', 'Oops! Fitur Excel Sedang Dikembangkan.');
      $user_enter = 'OBL';
      $tgl_download = Carbon::now()->translatedFormat('Y-m-d');
      $user_in_is = User::leftJoin('user_role','user_role.user_id','=','users.id')
      ->leftJoin('witels','witels.id','=','users.witel_id')
      ->leftJoin('user_mitra','user_mitra.user_id','=','users.id')
      ->leftJoin('mitras','mitras.id','=','user_mitra.mitra_id')
      ->select('users.id','user_role.role_id','users.witel_id','witels.nama_witel','mitras.nama_mitra','mitras.id as mitra_id')->where('users.id',Auth::id())->first();

      $query=null;
      if($user_in_is->role_id !== 4 && $user_in_is->role_id !== 5 && $user_in_is->role_id !== 6){
        $query = DocObl::leftJoin('users as u','u.id','=','obl.created_by')
        ->leftJoin('users as uu','uu.id','=','obl.updated_by')
        ->leftJoin('mitras','mitras.id','=','obl.f1_mitra_id')
        ->select(
                  'obl.id as obl_id',
                  DB::raw("
                  case
                  when f1_proses is null or f1_proses = '' then ''
                  else f1_proses
                  end as proses"),
                  DB::raw("
                  case
                  when submit like 'draf_filter_%' then 'filter'
                  when submit like 'draf_p%' then 'form'
                  when submit in ('draf_wo','draf_sp','draf_kl') then 'kontrak1'
                  when submit in ('submit_wo','submit_sp','submit_kl') then 'kontrak2'
                  else ''
                  end as filter_submit"),
                  DB::raw("replace(submit,'_',' ') as string_submit"),
                  DB::raw("case when f1_segmen is null or f1_segmen = '' then '' else f1_segmen end as segmen"),
                  DB::raw("case when f1_folder is null or f1_folder = '' then '' else f1_folder end as folder"),
                  DB::raw("to_char(obl.created_at,'YYYY-MM-DD HH24:MI') as string_tgl_submit"),
                  DB::raw("to_char(obl.updated_at,'YYYY-MM-DD HH24:MI') as string_tgl_update"),
                  DB::raw("case when f1_jenis_spk is null or f1_jenis_spk = '' then '' else f1_jenis_spk end as jenis_spk"),
                  DB::raw("case when f1_witel is null or f1_witel = '' then '' else f1_witel end as witel"),
                  DB::raw("case when f1_nama_plggn is null or f1_nama_plggn = '' then '' else f1_nama_plggn end as nama_plggn"),
                  DB::raw("
                  case
                  when f1_judul_projek is null or f1_judul_projek = '' then ''
                  else f1_judul_projek
                  end as layanan
                  "),
                  DB::raw("case when mitras.nama_mitra is null or mitras.nama_mitra = '' then '' else mitras.nama_mitra end as nama_vendor"),
                  'f1_masa_layanan_tahun as masa_layanan_tahun',
                  'f1_masa_layanan_bulan as masa_layanan_bulan',
                  'f1_masa_layanan_hari as masa_layanan_hari',
                  DB::raw("case when f1_nilai_kb is null or f1_nilai_kb = '' then '' else f1_nilai_kb end as nilai_kb"),
                  DB::raw("case when f1_no_kfs_spk is null or f1_no_kfs_spk = '' then '' else f1_no_kfs_spk end as no_kfs_spk"),
                  DB::raw("
                  case
                  when (wo_takah_wo is null or wo_takah_wo = '') and (sp_takah_sp is null or sp_takah_sp = '') then kl_takah_kl
                  when (wo_takah_wo is null or wo_takah_wo = '') and (kl_takah_kl is null or kl_takah_kl = '') then sp_takah_sp
                  when (kl_takah_kl is null or kl_takah_kl = '') and (sp_takah_sp is null or sp_takah_sp = '') then wo_takah_wo
                  else '-'
                  end as no_kontrak
                  "),
                  DB::raw("case when f1_pic_mitra is null or f1_pic_mitra = '' then '' else f1_pic_mitra end as pic_mitra"),
                  DB::raw("case when f1_jenis_kontrak is null or f1_jenis_kontrak = '' then '' else f1_jenis_kontrak end as jenis_kontrak"),
                  DB::raw("case when f1_quote_kontrak is null or f1_quote_kontrak = '' then '' else f1_quote_kontrak end as quote_kontrak"),
                  DB::raw("case when f1_nomor_akun is null or f1_nomor_akun = '' then '' else f1_nomor_akun end as nomor_akun"),
                  DB::raw("case when f1_skema_bayar is null or f1_skema_bayar = '' then '' else f1_skema_bayar end as skema_bayar"),
                  DB::raw("case when f1_status_order is null or f1_status_order = '' then '' else f1_status_order end as status_order"),
                  DB::raw("case when f1_alamat_plggn is null or f1_alamat_plggn = '' then '' else f1_alamat_plggn end as alamat_plggn"),
                  DB::raw("case when f1_tgl_keterangan is null then null else to_char(f1_tgl_keterangan,'YYYY-MM-DD HH24:MI') end as tgl_keterangan"),
                  DB::raw("case when f1_keterangan is null or f1_keterangan = '' then '' else f1_keterangan end as keterangan"),
                  DB::raw("u.nama_lengkap as user_create"),
                  DB::raw("uu.nama_lengkap as user_update")
                );
      }

      // WITEL
      if($user_in_is->role_id == 4 || $user_in_is->role_id == 5 ){
        $query = DocObl::leftJoin('users as u','u.id','=','obl.created_by')
        ->leftJoin('users as uu','uu.id','=','obl.updated_by')
        ->leftJoin('mitras','mitras.id','=','obl.f1_mitra_id')
        ->select(
                  'obl.id as obl_id',
                  DB::raw("
                  case
                  when f1_proses is null or f1_proses = '' then ''
                  else f1_proses
                  end as proses"),
                  DB::raw("
                  case
                  when submit like 'draf_filter_%' then 'filter'
                  when submit like 'draf_p%' then 'form'
                  when submit in ('draf_wo','draf_sp','draf_kl') then 'kontrak1'
                  when submit in ('submit_wo','submit_sp','submit_kl') then 'kontrak2'
                  else ''
                  end as filter_submit"),
                  DB::raw("replace(submit,'_',' ') as string_submit"),
                  DB::raw("case when f1_segmen is null or f1_segmen = '' then '' else f1_segmen end as segmen"),
                  DB::raw("case when f1_folder is null or f1_folder = '' then '' else f1_folder end as folder"),
                  DB::raw("to_char(obl.created_at,'YYYY-MM-DD HH24:MI') as string_tgl_submit"),
                  DB::raw("to_char(obl.updated_at,'YYYY-MM-DD HH24:MI') as string_tgl_update"),
                  DB::raw("case when f1_jenis_spk is null or f1_jenis_spk = '' then '' else f1_jenis_spk end as jenis_spk"),
                  DB::raw("case when f1_witel is null or f1_witel = '' then '' else f1_witel end as witel"),
                  DB::raw("case when f1_nama_plggn is null or f1_nama_plggn = '' then '' else f1_nama_plggn end as nama_plggn"),
                  DB::raw("
                  case
                  when f1_judul_projek is null or f1_judul_projek = '' then ''
                  else f1_judul_projek
                  end as layanan
                  "),
                  DB::raw("case when mitras.nama_mitra is null or mitras.nama_mitra = '' then '' else mitras.nama_mitra end as nama_vendor"),
                  'f1_masa_layanan_tahun as masa_layanan_tahun',
                  'f1_masa_layanan_bulan as masa_layanan_bulan',
                  'f1_masa_layanan_hari as masa_layanan_hari',
                  DB::raw("case when f1_nilai_kb is null or f1_nilai_kb = '' then '' else f1_nilai_kb end as nilai_kb"),
                  DB::raw("case when f1_no_kfs_spk is null or f1_no_kfs_spk = '' then '' else f1_no_kfs_spk end as no_kfs_spk"),
                  DB::raw("
                  case
                  when (wo_takah_wo is null or wo_takah_wo = '') and (sp_takah_sp is null or sp_takah_sp = '') then kl_takah_kl
                  when (wo_takah_wo is null or wo_takah_wo = '') and (kl_takah_kl is null or kl_takah_kl = '') then sp_takah_sp
                  when (kl_takah_kl is null or kl_takah_kl = '') and (sp_takah_sp is null or sp_takah_sp = '') then wo_takah_wo
                  else '-'
                  end as no_kontrak
                  "),
                  DB::raw("case when f1_pic_mitra is null or f1_pic_mitra = '' then '' else f1_pic_mitra end as pic_mitra"),
                  DB::raw("case when f1_jenis_kontrak is null or f1_jenis_kontrak = '' then '' else f1_jenis_kontrak end as jenis_kontrak"),
                  DB::raw("case when f1_quote_kontrak is null or f1_quote_kontrak = '' then '' else f1_quote_kontrak end as quote_kontrak"),
                  DB::raw("case when f1_nomor_akun is null or f1_nomor_akun = '' then '' else f1_nomor_akun end as nomor_akun"),
                  DB::raw("case when f1_skema_bayar is null or f1_skema_bayar = '' then '' else f1_skema_bayar end as skema_bayar"),
                  DB::raw("case when f1_status_order is null or f1_status_order = '' then '' else f1_status_order end as status_order"),
                  DB::raw("case when f1_alamat_plggn is null or f1_alamat_plggn = '' then '' else f1_alamat_plggn end as alamat_plggn"),
                  DB::raw("case when f1_tgl_keterangan is null then null else to_char(f1_tgl_keterangan,'YYYY-MM-DD HH24:MI') end as tgl_keterangan"),
                  DB::raw("case when f1_keterangan is null or f1_keterangan = '' then '' else f1_keterangan end as keterangan"),
                  DB::raw("u.nama_lengkap as user_create"),
                  DB::raw("uu.nama_lengkap as user_update")
                )->where('obl.f1_witel',$user_in_is->nama_witel);
                $user_enter = 'WITEL_' . $user_in_is->nama_witel;
      }
      // MITRA
      if($user_in_is->role_id == 6){
        $query = DocObl::leftJoin('users as u','u.id','=','obl.created_by')
        ->leftJoin('users as uu','uu.id','=','obl.updated_by')
        ->leftJoin('mitras','mitras.id','=','obl.f1_mitra_id')
        ->select(
                  'obl.id as obl_id',
                  DB::raw("
                  case
                  when f1_proses is null or f1_proses = '' then ''
                  else f1_proses
                  end as proses"),
                  DB::raw("
                  case
                  when submit like 'draf_filter_%' then 'filter'
                  when submit like 'draf_p%' then 'form'
                  when submit in ('draf_wo','draf_sp','draf_kl') then 'kontrak1'
                  when submit in ('submit_wo','submit_sp','submit_kl') then 'kontrak2'
                  else ''
                  end as filter_submit"),
                  DB::raw("replace(submit,'_',' ') as string_submit"),
                  DB::raw("case when f1_segmen is null or f1_segmen = '' then '' else f1_segmen end as segmen"),
                  DB::raw("case when f1_folder is null or f1_folder = '' then '' else f1_folder end as folder"),
                  DB::raw("to_char(obl.created_at,'YYYY-MM-DD HH24:MI') as string_tgl_submit"),
                  DB::raw("to_char(obl.updated_at,'YYYY-MM-DD HH24:MI') as string_tgl_update"),
                  DB::raw("case when f1_jenis_spk is null or f1_jenis_spk = '' then '' else f1_jenis_spk end as jenis_spk"),
                  DB::raw("case when f1_witel is null or f1_witel = '' then '' else f1_witel end as witel"),
                  DB::raw("case when f1_nama_plggn is null or f1_nama_plggn = '' then '' else f1_nama_plggn end as nama_plggn"),
                  DB::raw("
                  case
                  when f1_judul_projek is null or f1_judul_projek = '' then ''
                  else f1_judul_projek
                  end as layanan
                  "),
                  DB::raw("case when mitras.nama_mitra is null or mitras.nama_mitra = '' then '' else mitras.nama_mitra end as nama_vendor"),
                  'f1_masa_layanan_tahun as masa_layanan_tahun',
                  'f1_masa_layanan_bulan as masa_layanan_bulan',
                  'f1_masa_layanan_hari as masa_layanan_hari',
                  DB::raw("case when f1_nilai_kb is null or f1_nilai_kb = '' then '' else f1_nilai_kb end as nilai_kb"),
                  DB::raw("case when f1_no_kfs_spk is null or f1_no_kfs_spk = '' then '' else f1_no_kfs_spk end as no_kfs_spk"),
                  DB::raw("
                  case
                  when (wo_takah_wo is null or wo_takah_wo = '') and (sp_takah_sp is null or sp_takah_sp = '') then kl_takah_kl
                  when (wo_takah_wo is null or wo_takah_wo = '') and (kl_takah_kl is null or kl_takah_kl = '') then sp_takah_sp
                  when (kl_takah_kl is null or kl_takah_kl = '') and (sp_takah_sp is null or sp_takah_sp = '') then wo_takah_wo
                  else '-'
                  end as no_kontrak
                  "),
                  DB::raw("case when f1_pic_mitra is null or f1_pic_mitra = '' then '' else f1_pic_mitra end as pic_mitra"),
                  DB::raw("case when f1_jenis_kontrak is null or f1_jenis_kontrak = '' then '' else f1_jenis_kontrak end as jenis_kontrak"),
                  DB::raw("case when f1_quote_kontrak is null or f1_quote_kontrak = '' then '' else f1_quote_kontrak end as quote_kontrak"),
                  DB::raw("case when f1_nomor_akun is null or f1_nomor_akun = '' then '' else f1_nomor_akun end as nomor_akun"),
                  DB::raw("case when f1_skema_bayar is null or f1_skema_bayar = '' then '' else f1_skema_bayar end as skema_bayar"),
                  DB::raw("case when f1_status_order is null or f1_status_order = '' then '' else f1_status_order end as status_order"),
                  DB::raw("case when f1_alamat_plggn is null or f1_alamat_plggn = '' then '' else f1_alamat_plggn end as alamat_plggn"),
                  DB::raw("case when f1_tgl_keterangan is null then null else to_char(f1_tgl_keterangan,'YYYY-MM-DD HH24:MI') end as tgl_keterangan"),
                  DB::raw("case when f1_keterangan is null or f1_keterangan = '' then '' else f1_keterangan end as keterangan"),
                  DB::raw("u.nama_lengkap as user_create"),
                  DB::raw("uu.nama_lengkap as user_update")
                )->where('obl.f1_mitra_id',$user_in_is->mitra_id);
                $user_enter = 'MITRA_' . $user_in_is->nama_mitra;
      }

      if( $request->multi_obl_ids && count($request->multi_obl_ids) > 0 ){
          $query->whereIn('obl.id',$request->multi_obl_ids);
      }

      $data = $query->whereRaw(" (obl.deleted_at is null or to_char(obl.deleted_at,'yyyy-mm-dd') = '') ")
        ->orderBy('obl.created_at','DESC')
        ->orderBy('obl.updated_at','DESC')
        ->get();

      if( $data && count($data) === 0 ){ return redirect('obl-tables')->with('status','Oops Data Download Excel Kosong'); }

      if($user_in_is->role_id !== 4 && $user_in_is->role_id !== 5 && $user_in_is->role_id !== 6){
        return (new FastExcel($data))->download('Dokumen_'.$user_enter.'_'.$tgl_download.'.xlsx',function($row){
           return [
                     'PROSES' => $row->proses,
                     'STATUS_OBL' => $row->status_obl,
                     'SEGMEN' => $row->segmen,
                     'FOLDER' => $row->folder,
                     'TGL_SUBMIT' => $row->tgl_submit,
                     'TGL_UPDATE' => $row->tgl_update,
                     'JENIS_SPK' => $row->jenis_spk,
                     'WITEL' => $row->witel,
                     'NAMA_PELANGGAN' => $row->nama_pelanggan,
                     'LAYANAN' => $row->layanan,
                     'NAMA_VENDOR' => $row->nama_vendor,
                     'MASA_LAYANAN_TAHUN' => $row->masa_layanan_tahun,
                     'MASA_LAYANAN_BULAN' => $row->masa_layanan_bulan,
                     'MASA_LAYANAN_HARI' => $row->masa_layanan_hari,
                     'NILAI_KB' => $row->nilai_kb,
                     'NO_KFS_SPK' => $row->no_kfs_spk,
                     'NOMOR_KONTRAK' => $row->nomor_kontrak,
                     'PIC_MITRA' => $row->pic_mitra,
                     'JENIS_KONTRAK' => $row->jenis_kontrak,
                     'QUOTE_KONTRAK' => $row->quote_kontrak,
                     'NOMOR_AKUN' => $row->nomor_akun,
                     'SKEMA_BAYAR' => $row->skema_bayar,
                     'STATUS_ORDER' => $row->status_order,
                     'ALAMAT_PELANGGAN' => $row->alamat_pelanggan,
                     'TGL_KETERANGAN' => $row->tgl_keterangan,
                     'KETERANGAN' => $row->keterangan,
                     'DIBUAT_OLEH' => $row->dibuat_oleh,
                     'DIUPDATE_OLEH' => $row->diupdate_oleh,
                  ];
        });
      }
      if($user_in_is->role_id == 4 || $user_in_is->role_id == 5){
        return (new FastExcel($data))->download('Dokumen_'.$user_enter.'_'.$tgl_download.'.xlsx',function($row){
           return [
                   'PROSES' => $row->proses,
                   'STATUS_OBL' => $row->status_obl,
                   'SEGMEN' => $row->segmen,
                   'TGL_SUBMIT' => $row->tgl_submit,
                   'TGL_UPDATE' => $row->tgl_update,
                   'JENIS_SPK' => $row->jenis_spk,
                   'WITEL' => $row->witel,
                   'NAMA_PELANGGAN' => $row->nama_pelanggan,
                   'LAYANAN' => $row->layanan,
                   'NAMA_VENDOR' => $row->nama_vendor,
                   'MASA_LAYANAN_TAHUN' => $row->masa_layanan_tahun,
                   'MASA_LAYANAN_BULAN' => $row->masa_layanan_bulan,
                   'MASA_LAYANAN_HARI' => $row->masa_layanan_hari,
                   'NILAI_KB' => $row->nilai_kb,
                   'NO_KFS_SPK' => $row->no_kfs_spk,
                   'NOMOR_KONTRAK' => $row->nomor_kontrak,
                   'PIC_MITRA' => $row->pic_mitra,
                   'JENIS_KONTRAK' => $row->jenis_kontrak,
                   'QUOTE_KONTRAK' => $row->quote_kontrak,
                   'NOMOR_AKUN' => $row->nomor_akun,
                   'SKEMA_BAYAR' => $row->skema_bayar,
                   'STATUS_ORDER' => $row->status_order,
                   'ALAMAT_PELANGGAN' => $row->alamat_pelanggan,
                   'TGL_KETERANGAN' => $row->tgl_keterangan,
                   'KETERANGAN' => $row->keterangan,
                   'DIBUAT_OLEH' => $row->dibuat_oleh,
                   'DIUPDATE_OLEH' => $row->diupdate_oleh,
                  ];
        });
      }
      if($user_in_is->role_id == 6){
        return (new FastExcel($data))->download('Dokumen_'.$user_enter.'_'.$tgl_download.'.xlsx',function($row){
           return [
                      'PROSES' => $row->proses,
                      'STATUS_OBL' => $row->status_obl,
                      'SEGMEN' => $row->segmen,
                      'TGL_SUBMIT' => $row->tgl_submit,
                      'TGL_UPDATE' => $row->tgl_update,
                      'JENIS_SPK' => $row->jenis_spk,
                      'WITEL' => $row->witel,
                      'NAMA_PELANGGAN' => $row->nama_pelanggan,
                      'LAYANAN' => $row->layanan,
                      'NAMA_VENDOR' => $row->nama_vendor,
                      'MASA_LAYANAN_TAHUN' => $row->masa_layanan_tahun,
                      'MASA_LAYANAN_BULAN' => $row->masa_layanan_bulan,
                      'MASA_LAYANAN_HARI' => $row->masa_layanan_hari,
                      'NILAI_KB' => $row->nilai_kb,
                      'NO_KFS_SPK' => $row->no_kfs_spk,
                      'NOMOR_KONTRAK' => $row->nomor_kontrak,
                      'PIC_MITRA' => $row->pic_mitra,
                      'JENIS_KONTRAK' => $row->jenis_kontrak,
                      'QUOTE_KONTRAK' => $row->quote_kontrak,
                      'NOMOR_AKUN' => $row->nomor_akun,
                      'SKEMA_BAYAR' => $row->skema_bayar,
                      'STATUS_ORDER' => $row->status_order,
                      'ALAMAT_PELANGGAN' => $row->alamat_pelanggan,
                      'TGL_KETERANGAN' => $row->tgl_keterangan,
                      'KETERANGAN' => $row->keterangan,
                      'DIBUAT_OLEH' => $row->dibuat_oleh,
                      'DIUPDATE_OLEH' => $row->diupdate_oleh,
                  ];
        });
      }
    }

    public function edit(Request $request)
    {
      // dd($request->all());
      $user_edit = User::leftJoin('user_role as ur','ur.user_id','=','users.id')->leftJoin('roles as r','r.id','=','ur.role_id')
     ->select('users.id','users.nama_lengkap','ur.role_id','r.nama_role')
     ->where('users.id',Auth::user()->id)
     ->first();

      if($request->edit_obl_id){
          $edit_obl_id = $request->edit_obl_id;
          $edit_obl_id = intval($edit_obl_id);
          $table_edit = null;
          $table_edit_p4_attendees = null;
          $mitra_vendor = null;
          $table_edit_keterangan = null;
          $list_nomor_kb = null;
          // user witel & solution
          if( $user_edit->role_id === 4 ){
            $table_edit = DocObl::select(
              'id',
              'f1_quote_kontrak',
              'f1_nomor_akun',
              'f1_nilai_kb',
              'f1_judul_projek',
              'f1_nama_plggn',
              'f1_alamat_plggn',
              'f1_mitra_id',
              'f1_segmen',
              'f1_skema_bayar',
              'f1_pic_plggn',
              'f1_status_order',
              'p0_nomor_p0',
              'p0_nik_am',
              'p0_nik_manager',
              'p0_tgl_submit',
              'p0_pemeriksa',
              'p0_nik_gm',
              'p1_nomor_p1',
              'p1_tgl_p1',
              'p1_pemeriksa',
              'p1_tgl_delivery',
              'p1_lokasi_instal',
              'p1_skema_bisnis',
              'p1_skema_bayar',
              'p1_mekanisme_bayar',
              'p1_tgl_kontrak_mulai',
              'p1_tgl_kontrak_akhir',
              'p1_tgl_doc_plggn',
              'p1_estimasi_harga',
              'p1_disetujui_gm',
              'p1_dibuat_am',
              'p1_diperiksa_manager',
              )->where('id',$edit_obl_id)
              ->get()->toArray();
              $mitra_vendor = DB::connection('pgsql')->table('mitras')->select('*')->get()->toArray();
          }
          // user obl
          if( $user_edit->role_id === 2 || $user_edit->role_id === 8  || $user_edit->role_id === 9 ){
              $table_edit = DocObl::select(
                '*',
                DB::raw("TO_CHAR(p1_tgl_p1,'yyyy-mm-dd') AS tgl_p1_all "),
                DB::raw("TO_CHAR(f2_tgl_p1,'yyyy-mm-dd') AS tgl_p1 "),
                DB::raw("TO_CHAR(p2_tgl_justifikasi,'yyyy-mm-dd') AS tgl_justifikasi "),
                DB::raw("TO_CHAR(p3_tgl_rapat_pengadaan,'yyyy-mm-dd hh24:mi:ss') AS tgl_rapat_pengadaan "),
                DB::raw("TO_CHAR(p3_tgl_terima_sp,'yyyy-mm-dd hh24:mi:ss') AS tgl_terima_sp "),
                DB::raw("TO_CHAR(p4_waktu_layanan,'yyyy-mm-dd') AS waktu_layanan "),
                DB::raw("TO_CHAR(wo_tgl_fo,'yyyy-mm-dd') AS tgl_fo "),
                DB::raw("TO_CHAR(kl_tgl_akta_notaris,'yyyy-mm-dd') AS tgl_akta_notaris "),
                DB::raw("TO_CHAR(kl_tgl_anggaran_mitra,'yyyy-mm-dd') AS tgl_anggaran_mitra "),
                DB::raw("TO_CHAR(kl_tgl_skm,'yyyy-mm-dd') AS tgl_skm "),
                DB::raw("TO_CHAR(kl_tgl_akhir_kl,'yyyy-mm-dd') AS tgl_akhir_kl ")
                )
                ->where('id',$edit_obl_id)
                ->get()->toArray();
              $table_edit_p4_attendees = DB::connection('pgsql')->table('form_p4_attendees')->select('*')->where('obl_id',$edit_obl_id)->get()->toArray();
              $mitra_vendor = DB::connection('pgsql')->table('mitras')->select('*')->get()->toArray();
              $table_edit_keterangan = DB::connection('pgsql')->table('form_obl_histori')->select('f1_tgl_keterangan','f1_keterangan')->where('obl_id',$edit_obl_id)->orderBy('f1_tgl_keterangan','DESC')->get()->toArray();
              $list_nomor_kb = DB::connection('pgsql')->table('form_obl')
              ->select(
                DB::raw(
                  "
                    case
                    when (sp_nomor_kb is not null and sp_nomor_kb <> '') and f1_jenis_spk = 'SP' then sp_nomor_kb
                    when (wo_nomor_kb is not null and wo_nomor_kb <> '') and f1_jenis_spk = 'WO' then wo_nomor_kb
                    when (kl_nomor_kb is not null and kl_nomor_kb <> '') and f1_jenis_spk = 'KL' then kl_nomor_kb
                    end as nomor_kb
                  "
                ),
                'f1_jenis_spk','f1_nama_plggn')
              ->orderBy('created_at','DESC')->get()->toArray();
          }

          return view('pages.obls.tables_edit',compact('user_edit','table_edit','table_edit_p4_attendees','mitra_vendor','table_edit_keterangan','list_nomor_kb'));
      }
      else{
        return redirect('obl-tables')->with('status', 'Oops! Gagal Routing.');
      }

    }

    public function ketdoc(Request $request){
      // dd($request->all());
      if($request->ket_obl_id){
        try{
          $ketdoc = DB::connection('pgsql')->table('form_obl as obl')->select('f1_tgl_keterangan','f1_keterangan')->where('id',$request->ket_obl_id)->get()->toArray();
          $ketdoc_histori = DB::connection('pgsql')->table('form_obl_histori as obl')->select('f1_tgl_keterangan','f1_keterangan')->where('obl_id',$request->ket_obl_id)->orderBy('f1_tgl_keterangan','DESC')->get()->toArray();
          if( $ketdoc[0]->f1_keterangan && $ketdoc[0]->f1_keterangan !== '' && $ketdoc[0]->f1_keterangan !== 'null' && $ketdoc[0]->f1_keterangan !== null ){
            if( !empty($ketdoc) && empty($ketdoc_histori) ){ return response()->json(['status_id'=>'1','status'=>'Success','ketdoc'=>$ketdoc,'ketdoc_histori'=>$ketdoc_histori]); }
            else if( !empty($ketdoc) && !empty($ketdoc_histori) ){ return response()->json(['status_id'=>'1','status'=>'Success','ketdoc'=>$ketdoc,'ketdoc_histori'=>$ketdoc_histori]); }
          }
          else{
              return response()->json(['status_id'=>'2','status'=>'Tidak Ada Data Keterangan OBL.']);
          }
        }
        catch(Throwable $e){ return response()->json(['status_id'=>'3','status'=>'Oops! Gagal Mengambil Data Keterangan OBL.']); }
      }
      else{ return response()->json(['status_id'=>'4','status'=>'Oops! Wrong Routing.']); }
    }

    public function update(Request $request){
      // dd($request->all());
      $user_update = User::leftJoin('user_role as ur','ur.user_id','=','users.id')->leftJoin('roles as r','r.id','=','ur.role_id')
      ->select('users.id','users.nama_lengkap','ur.role_id','r.nama_role')
      ->where('users.id',Auth::user()->id)
      ->first();

      $edit_obl_id = $request->edit_obl_id;
      $submit_sekarang = Carbon::now()->translatedFormat('Y-m-d H:i:s');

      $cek_doc_obl_update = DB::connection('pgsql')->table('form_obl')
      ->select('*')
      ->where('id',$edit_obl_id)
      ->first();

      // user witel & solution
      if( $user_update->role_id === 4 ){
        $collection = collect($request->all());
        $filtered = $collection->except([
            '_token',
            'edit_obl_id'
        ]);
        $filtered->put('updated_by',$user_update->id);
        $filtered->put('updated_at',$submit_sekarang);
        try{
          DB::connection('pgsql')->table('form_obl_histori')
          ->insert([
            'obl_id' => $cek_doc_obl_update->id,
            'submit' => $cek_doc_obl_update->submit,
            'revisi_witel' => $cek_doc_obl_update->revisi_witel,
            'revisi_witel_count' => $cek_doc_obl_update->revisi_witel_count,
            'is_draf' => $cek_doc_obl_update->is_draf,
            'updated_at' => $cek_doc_obl_update->updated_at,
            'updated_by' => $cek_doc_obl_update->updated_by,
            'p0_nomor_p0' => $cek_doc_obl_update->p0_nomor_p0,
            'p0_nik_am' => $cek_doc_obl_update->p0_nik_am,
            'p0_nik_manager' => $cek_doc_obl_update->p0_nik_manager,
            'p0_tgl_submit' => $cek_doc_obl_update->p0_tgl_submit,
            'p0_pemeriksa' => $cek_doc_obl_update->p0_pemeriksa,
            'p0_nik_gm' => $cek_doc_obl_update->p0_nik_gm,
            'p1_nomor_p1' => $cek_doc_obl_update->p1_nomor_p1,
            'p1_tgl_p1' => $cek_doc_obl_update->p1_tgl_p1,
            'p1_pemeriksa' => $cek_doc_obl_update->p1_pemeriksa,
            'p1_tgl_delivery' => $cek_doc_obl_update->p1_tgl_delivery,
            'p1_lokasi_instal' => $cek_doc_obl_update->p1_lokasi_instal,
            'p1_skema_bisnis' => $cek_doc_obl_update->p1_skema_bisnis,
            'p1_skema_bayar' => $cek_doc_obl_update->p1_skema_bayar,
            'p1_mekanisme_bayar' => $cek_doc_obl_update->p1_mekanisme_bayar,
            'p1_tgl_kontrak_mulai' => $cek_doc_obl_update->p1_tgl_kontrak_mulai,
            'p1_tgl_kontrak_akhir' => $cek_doc_obl_update->p1_tgl_kontrak_akhir,
            'p1_tgl_doc_plggn' => $cek_doc_obl_update->p1_tgl_doc_plggn,
            'p1_estimasi_harga' => $cek_doc_obl_update->p1_estimasi_harga,
            'p1_disetujui_gm' => $cek_doc_obl_update->p1_disetujui_gm,
            'p1_dibuat_am' => $cek_doc_obl_update->p1_dibuat_am,
            'p1_diperiksa_manager' => $cek_doc_obl_update->p1_diperiksa_manager,
            'f1_nama_plggn' => $cek_doc_obl_update->f1_nama_plggn,
            'f1_alamat_plggn' => $cek_doc_obl_update->f1_alamat_plggn,
            'f1_witel' => $cek_doc_obl_update->f1_witel,
            'f1_judul_projek' => $cek_doc_obl_update->f1_judul_projek,
            'f1_segmen' => $cek_doc_obl_update->f1_segmen,
            'f1_proses' => $cek_doc_obl_update->f1_proses,
            'f1_folder' => $cek_doc_obl_update->f1_folder,
            'f1_nilai_kb' => $cek_doc_obl_update->f1_nilai_kb,
            'f1_no_kfs_spk' => $cek_doc_obl_update->f1_no_kfs_spk,
            'f1_quote_kontrak' => $cek_doc_obl_update->f1_quote_kontrak,
            'f1_nomor_akun' => $cek_doc_obl_update->f1_nomor_akun,
            'f1_jenis_kontrak' => $cek_doc_obl_update->f1_jenis_kontrak,
            'f1_skema_bayar' => $cek_doc_obl_update->f1_skema_bayar,
            'f1_status_order' => $cek_doc_obl_update->f1_status_order,
            'f1_status_sm' => $cek_doc_obl_update->f1_status_sm,
            'f1_tgl_keterangan' => $cek_doc_obl_update->f1_tgl_keterangan,
            'f1_keterangan' => $cek_doc_obl_update->f1_keterangan,
            'f1_mitra_id' => $cek_doc_obl_update->f1_mitra_id,
            'f1_pic_mitra' => $cek_doc_obl_update->f1_pic_mitra,
            'f1_jenis_spk' => $cek_doc_obl_update->f1_jenis_spk,
            'f1_masa_layanan_tahun' => $cek_doc_obl_update->f1_masa_layanan_tahun,
            'f1_masa_layanan_bulan' => $cek_doc_obl_update->f1_masa_layanan_bulan,
            'f1_masa_layanan_hari' => $cek_doc_obl_update->f1_masa_layanan_hari,
            'f1_pic_plggn' => $cek_doc_obl_update->f1_pic_plggn,
            'f2_nilai_kontrak' => $cek_doc_obl_update->f2_nilai_kontrak,
            'f2_tgl_p1' => $cek_doc_obl_update->f2_tgl_p1,
            'p2_tgl_p2' => $cek_doc_obl_update->p2_tgl_p2,
            'p2_tgl_justifikasi' => $cek_doc_obl_update->p2_tgl_justifikasi,
            'p2_dievaluasi_oleh' => $cek_doc_obl_update->p2_dievaluasi_oleh,
            'p2_disetujui_oleh' => $cek_doc_obl_update->p2_disetujui_oleh,
            'p2_pilihan_catatan' => $cek_doc_obl_update->p2_pilihan_catatan,
            'p2_catatan' => $cek_doc_obl_update->p2_catatan,
            'p3_tgl_p3' => $cek_doc_obl_update->p3_tgl_p3,
            'p3_takah_p3' => $cek_doc_obl_update->p3_takah_p3,
            'p3_pejabat_mitra_nama' => $cek_doc_obl_update->p3_pejabat_mitra_nama,
            'p3_pejabat_mitra_alamat' => $cek_doc_obl_update->p3_pejabat_mitra_alamat,
            'p3_pejabat_mitra_telepon' => $cek_doc_obl_update->p3_pejabat_mitra_telepon,
            'p3_status_rapat_pengadaan' => $cek_doc_obl_update->p3_status_rapat_pengadaan,
            'p3_tgl_rapat_pengadaan' => $cek_doc_obl_update->p3_tgl_rapat_pengadaan,
            'p3_tmpt_rapat_pengadaan' => $cek_doc_obl_update->p3_tmpt_rapat_pengadaan,
            'p3_tgl_terima_sp' => $cek_doc_obl_update->p3_tgl_terima_sp,
            'p3_alamat_terima_sp' => $cek_doc_obl_update->p3_alamat_terima_sp,
            'p3_manager_obl' => $cek_doc_obl_update->p3_manager_obl,
            'p4_tgl_p4' => $cek_doc_obl_update->p4_tgl_p4,
            'p4_waktu_layanan' => $cek_doc_obl_update->p4_waktu_layanan,
            'p4_skema_bisnis' => $cek_doc_obl_update->p4_skema_bisnis,
            'p4_mekanisme_pembayaran' => $cek_doc_obl_update->p4_mekanisme_pembayaran,
            'p4_slg' => $cek_doc_obl_update->p4_slg,
            'p4_fasilitator' => $cek_doc_obl_update->p4_fasilitator,
            'p4_pengesahan' => $cek_doc_obl_update->p4_pengesahan,
            'p5_tgl_p5' => $cek_doc_obl_update->p5_tgl_p5,
            'p5_harga_penawaran' => $cek_doc_obl_update->p5_harga_penawaran,
            'p5_ttd_evaluator' => $cek_doc_obl_update->p5_ttd_evaluator,
            'p6_tgl_p6' => $cek_doc_obl_update->p6_tgl_p6,
            'p6_ttd_bast_telkom' => $cek_doc_obl_update->p6_ttd_bast_telkom,
            'p6_ttd_bast_mitra' => $cek_doc_obl_update->p6_ttd_bast_mitra,
            'p6_harga_negosiasi' => $cek_doc_obl_update->p6_harga_negosiasi,
            'p6_nama_peserta_mitra' => $cek_doc_obl_update->p6_nama_peserta_mitra,
            'p6_jabatan_peserta_mitra' => $cek_doc_obl_update->p6_jabatan_peserta_mitra,
            'p6_peserta_rapat_telkom' => $cek_doc_obl_update->p6_peserta_rapat_telkom,
            'p6_pengesahan' => $cek_doc_obl_update->p6_pengesahan,
            'p7_tgl_p7' => $cek_doc_obl_update->p7_tgl_p7,
            'p7_takah_p7' => $cek_doc_obl_update->p7_takah_p7,
            'p7_lampiran_berkas' => $cek_doc_obl_update->p7_lampiran_berkas,
            'p7_harga_pekerjaan' => $cek_doc_obl_update->p7_harga_pekerjaan,
            'p7_skema_bayar' => $cek_doc_obl_update->p7_skema_bayar,
            'p7_pemeriksa' => $cek_doc_obl_update->p7_pemeriksa,
            'p7_tembusan' => $cek_doc_obl_update->p7_tembusan,
            'sp_tgl_sp' => $cek_doc_obl_update->sp_tgl_sp,
            'sp_takah_sp' => $cek_doc_obl_update->sp_takah_sp,
            'sp_nomor_kb' => $cek_doc_obl_update->sp_nomor_kb,
            'p8_tgl_p8' => $cek_doc_obl_update->p8_tgl_p8,
            'p8_takah_p8' => $cek_doc_obl_update->p8_takah_p8,
            'wo_tgl_wo' => $cek_doc_obl_update->wo_tgl_wo,
            'wo_takah_wo' => $cek_doc_obl_update->wo_takah_wo,
            'wo_tgl_fo' => $cek_doc_obl_update->wo_tgl_fo,
            'wo_nomor_kb' => $cek_doc_obl_update->wo_nomor_kb,
            'wo_jenis_layanan' => $cek_doc_obl_update->wo_jenis_layanan,
            'wo_jumlah_layanan' => $cek_doc_obl_update->wo_jumlah_layanan,
            'wo_harga_ke_plggn' => $cek_doc_obl_update->wo_harga_ke_plggn,
            'wo_onetime_charge_plggn' => $cek_doc_obl_update->wo_onetime_charge_plggn,
            'wo_monthly_plggn' => $cek_doc_obl_update->wo_monthly_plggn,
            'wo_onetime_charge_telkom' => $cek_doc_obl_update->wo_onetime_charge_telkom,
            'wo_persen_telkom' => $cek_doc_obl_update->wo_persen_telkom,
            'wo_monthly_telkom' => $cek_doc_obl_update->wo_monthly_telkom,
            'wo_onetime_charge_mitra' => $cek_doc_obl_update->wo_onetime_charge_mitra,
            'wo_persen_mitra' => $cek_doc_obl_update->wo_persen_mitra,
            'wo_monthly_mitra' => $cek_doc_obl_update->wo_monthly_mitra,
            'kl_tgl_kl' => $cek_doc_obl_update->kl_tgl_kl,
            'kl_takah_kl' => $cek_doc_obl_update->kl_takah_kl,
            'kl_nomor_kb' => $cek_doc_obl_update->kl_nomor_kb,
            'kl_no_kl_mitra' => $cek_doc_obl_update->kl_no_kl_mitra,
            'kl_tempat_ttd_kl' => $cek_doc_obl_update->kl_tempat_ttd_kl,
            'kl_notaris' => $cek_doc_obl_update->kl_notaris,
            'kl_akta_notaris' => $cek_doc_obl_update->kl_akta_notaris,
            'kl_tgl_akta_notaris' => $cek_doc_obl_update->kl_tgl_akta_notaris,
            'kl_nama_pejabat_telkom' => $cek_doc_obl_update->kl_nama_pejabat_telkom,
            'kl_jabatan_pejabat_telkom' => $cek_doc_obl_update->kl_jabatan_pejabat_telkom,
            'kl_npwp_mitra' => $cek_doc_obl_update->kl_npwp_mitra,
            'kl_no_anggaran_mitra' => $cek_doc_obl_update->kl_no_anggaran_mitra,
            'kl_tgl_anggaran_mitra' => $cek_doc_obl_update->kl_tgl_anggaran_mitra,
            'kl_nama_pejabat_mitra' => $cek_doc_obl_update->kl_nama_pejabat_mitra,
            'kl_jabatan_pejabat_mitra' => $cek_doc_obl_update->kl_jabatan_pejabat_mitra,
            'kl_no_skm' => $cek_doc_obl_update->kl_no_skm,
            'kl_tgl_skm' => $cek_doc_obl_update->kl_tgl_skm,
            'kl_perihal_skm' => $cek_doc_obl_update->kl_perihal_skm,
            'kl_tgl_akhir_kl' => $cek_doc_obl_update->kl_tgl_akhir_kl,
            'kl_bayar_dp' => $cek_doc_obl_update->kl_bayar_dp,
            'kl_nama_bank_mitra' => $cek_doc_obl_update->kl_nama_bank_mitra,
            'kl_cabang_bank_mitra' => $cek_doc_obl_update->kl_cabang_bank_mitra,
            'kl_rek_bank_mitra' => $cek_doc_obl_update->kl_rek_bank_mitra,
            'kl_an_bank_mitra' => $cek_doc_obl_update->kl_an_bank_mitra,
            'file_p0' => $cek_doc_obl_update->file_p0,
            'file_p1' => $cek_doc_obl_update->file_p1,
            'file_p2' => $cek_doc_obl_update->file_p2,
            'file_p3' => $cek_doc_obl_update->file_p3,
            'file_p4' => $cek_doc_obl_update->file_p4,
            'file_p5' => $cek_doc_obl_update->file_p5,
            'file_p6' => $cek_doc_obl_update->file_p6,
            'file_p7' => $cek_doc_obl_update->file_p7,
            'file_p8' => $cek_doc_obl_update->file_p8,
            'file_sp' => $cek_doc_obl_update->file_sp,
            'file_wo' => $cek_doc_obl_update->file_wo,
            'file_kl' => $cek_doc_obl_update->file_kl
          ]);
          DB::connection('pgsql')->table('form_obl')
          ->where('id',$edit_obl_id)
          ->update( $filtered->all() );

          $cek_dulu = DB::connection('pgsql')->table('form_obl')
          ->select('id','p0_tgl_submit','p0_nomor_p0','p1_nomor_p1','p1_tgl_p1','file_p0','file_p1')
          ->where('id',$edit_obl_id)
          ->first();
          // revisi_witel is false when DOC & FORMS & FILES exist
          if(
            $cek_dulu->id &&
            $cek_dulu->p0_tgl_submit && $cek_dulu->p0_nomor_p0 &&
            $cek_dulu->p1_tgl_p1 && $cek_dulu->p1_nomor_p1 &&
            $cek_dulu->file_p0 && $cek_dulu->file_p1
          ){
            if($user_in_is->role_id === 8){
              DB::connection('pgsql')->table('form_obl')
              ->where('id',$request->obl_id)
              ->update( [ 'submit' => 'solution_edit' ] );
            }
            if($user_in_is->role_id === 4){
              DB::connection('pgsql')->table('form_obl')
              ->where('id',$request->obl_id)
              ->update( [ 'revisi_witel' => false, 'submit' => 'am_edit' ] );
            }
          }else{
            if($user_in_is->role_id === 8){
              DB::connection('pgsql')->table('form_obl')
              ->where('id',$request->obl_id)
              ->update( [ 'submit' => 'solution_edit' ] );
            }
            if($user_in_is->role_id === 4){
              DB::connection('pgsql')->table('form_obl')
              ->where('id',$request->obl_id)
              ->update( [ 'revisi_witel' => true, 'submit' => 'am_edit' ] );
            }
          }


        }
        catch(Throwable $e){
          return redirect()->route('obl.tables')->with('status','Oops! Gagal Simpan Edit Dokumen OBL.');
        }

        return redirect()->route('obl.tables')->with('status', 'Sukses Simpan Edit Dokumen OBL.');

      }
      // end user witel & solution

      // user obl
      else if( $user_update->role_id === 2 || $user_update->role_id === 8  || $user_update->role_id === 9 ){
        // P6 HARGA NEGO = P7 HARGA PEKERJAAN
        $p7_harga_pekerjaan = '';
        if($request->p6_harga_negosiasi){
          try{
            if($request->p6_harga_negosiasi !== ''){ $p7_harga_pekerjaan = $request->p6_harga_negosiasi; }
            else{ $p7_harga_pekerjaan = null; }
          }
          catch(Throwable $e){ return back()->withInput()->with('status','Oops! Gagal Check P6 HARGA NEGO.'); }
        }

        if($request->submit && str_contains($request->submit,'draf')){
          try{
            // SUBMIT DRAF (VALIDASI: JUDUL PROJEK)
            $inputan_masuk_draf = [];
            $inputan_masuk_draf['f1_judul_projek'] = 'required';
            $inputan_masuk_draf['f1_nama_plggn'] = 'required';
            $validasi_draf = $request->all();
            $validator_draf = Validator::make($validasi_draf,$inputan_masuk_draf);
            if($validator_draf->fails()){ return back()->withErrors($validator_draf)->withInput(); }

            $collection_draf = collect($request->all());
            $filtered_draf = $collection_draf->except([
                '_token',
                'p4_attendees',
                'edit_draf_id',
                'f1_mitra_id',
                'f1_nama_mitra_lain'
            ]);
            $filtered_draf->put('updated_at',$submit_sekarang);
            $filtered_draf->put('updated_by',$user_update->id);
            // if($user_update->role_id===8){$filtered_draf->put('submit','solution_edit');}
            // if($user_update->role_id===2 || $user_update->role_id===9){$filtered_draf->put('submit','obl_edit');}
            if($request->p6_harga_negosiasi){ $filtered_draf->put('p7_harga_pekerjaan',$p7_harga_pekerjaan); }
            if($request->f1_keterangan){ $filtered_draf->put('f1_tgl_keterangan',$submit_sekarang); }
            $filtered_draf->put('is_draf',1);
            $filtered_draf->put('f1_mitra_id',$f1_mitra_id);

            DB::connection('pgsql')->table('form_obl_histori')
            ->insert([
              'obl_id' => $cek_doc_obl_update->id,
              'submit' => $cek_doc_obl_update->submit,
              'revisi_witel' => $cek_doc_obl_update->revisi_witel,
              'revisi_witel_count' => $cek_doc_obl_update->revisi_witel_count,
              'is_draf' => $cek_doc_obl_update->is_draf,
              'updated_at' => $cek_doc_obl_update->updated_at,
              'updated_by' => $cek_doc_obl_update->updated_by,
              'p0_nomor_p0' => $cek_doc_obl_update->p0_nomor_p0,
              'p0_nik_am' => $cek_doc_obl_update->p0_nik_am,
              'p0_nik_manager' => $cek_doc_obl_update->p0_nik_manager,
              'p0_tgl_submit' => $cek_doc_obl_update->p0_tgl_submit,
              'p0_pemeriksa' => $cek_doc_obl_update->p0_pemeriksa,
              'p0_nik_gm' => $cek_doc_obl_update->p0_nik_gm,
              'p1_nomor_p1' => $cek_doc_obl_update->p1_nomor_p1,
              'p1_tgl_p1' => $cek_doc_obl_update->p1_tgl_p1,
              'p1_pemeriksa' => $cek_doc_obl_update->p1_pemeriksa,
              'p1_tgl_delivery' => $cek_doc_obl_update->p1_tgl_delivery,
              'p1_lokasi_instal' => $cek_doc_obl_update->p1_lokasi_instal,
              'p1_skema_bisnis' => $cek_doc_obl_update->p1_skema_bisnis,
              'p1_skema_bayar' => $cek_doc_obl_update->p1_skema_bayar,
              'p1_mekanisme_bayar' => $cek_doc_obl_update->p1_mekanisme_bayar,
              'p1_tgl_kontrak_mulai' => $cek_doc_obl_update->p1_tgl_kontrak_mulai,
              'p1_tgl_kontrak_akhir' => $cek_doc_obl_update->p1_tgl_kontrak_akhir,
              'p1_tgl_doc_plggn' => $cek_doc_obl_update->p1_tgl_doc_plggn,
              'p1_estimasi_harga' => $cek_doc_obl_update->p1_estimasi_harga,
              'p1_disetujui_gm' => $cek_doc_obl_update->p1_disetujui_gm,
              'p1_dibuat_am' => $cek_doc_obl_update->p1_dibuat_am,
              'p1_diperiksa_manager' => $cek_doc_obl_update->p1_diperiksa_manager,
              'f1_nama_plggn' => $cek_doc_obl_update->f1_nama_plggn,
              'f1_alamat_plggn' => $cek_doc_obl_update->f1_alamat_plggn,
              'f1_witel' => $cek_doc_obl_update->f1_witel,
              'f1_judul_projek' => $cek_doc_obl_update->f1_judul_projek,
              'f1_segmen' => $cek_doc_obl_update->f1_segmen,
              'f1_proses' => $cek_doc_obl_update->f1_proses,
              'f1_folder' => $cek_doc_obl_update->f1_folder,
              'f1_nilai_kb' => $cek_doc_obl_update->f1_nilai_kb,
              'f1_no_kfs_spk' => $cek_doc_obl_update->f1_no_kfs_spk,
              'f1_quote_kontrak' => $cek_doc_obl_update->f1_quote_kontrak,
              'f1_nomor_akun' => $cek_doc_obl_update->f1_nomor_akun,
              'f1_jenis_kontrak' => $cek_doc_obl_update->f1_jenis_kontrak,
              'f1_skema_bayar' => $cek_doc_obl_update->f1_skema_bayar,
              'f1_status_order' => $cek_doc_obl_update->f1_status_order,
              'f1_status_sm' => $cek_doc_obl_update->f1_status_sm,
              'f1_tgl_keterangan' => $cek_doc_obl_update->f1_tgl_keterangan,
              'f1_keterangan' => $cek_doc_obl_update->f1_keterangan,
              'f1_mitra_id' => $cek_doc_obl_update->f1_mitra_id,
              'f1_pic_mitra' => $cek_doc_obl_update->f1_pic_mitra,
              'f1_jenis_spk' => $cek_doc_obl_update->f1_jenis_spk,
              'f1_masa_layanan_tahun' => $cek_doc_obl_update->f1_masa_layanan_tahun,
              'f1_masa_layanan_bulan' => $cek_doc_obl_update->f1_masa_layanan_bulan,
              'f1_masa_layanan_hari' => $cek_doc_obl_update->f1_masa_layanan_hari,
              'f1_pic_plggn' => $cek_doc_obl_update->f1_pic_plggn,
              'f2_nilai_kontrak' => $cek_doc_obl_update->f2_nilai_kontrak,
              'f2_tgl_p1' => $cek_doc_obl_update->f2_tgl_p1,
              'p2_tgl_p2' => $cek_doc_obl_update->p2_tgl_p2,
              'p2_tgl_justifikasi' => $cek_doc_obl_update->p2_tgl_justifikasi,
              'p2_dievaluasi_oleh' => $cek_doc_obl_update->p2_dievaluasi_oleh,
              'p2_disetujui_oleh' => $cek_doc_obl_update->p2_disetujui_oleh,
              'p2_pilihan_catatan' => $cek_doc_obl_update->p2_pilihan_catatan,
              'p2_catatan' => $cek_doc_obl_update->p2_catatan,
              'p3_tgl_p3' => $cek_doc_obl_update->p3_tgl_p3,
              'p3_takah_p3' => $cek_doc_obl_update->p3_takah_p3,
              'p3_pejabat_mitra_nama' => $cek_doc_obl_update->p3_pejabat_mitra_nama,
              'p3_pejabat_mitra_alamat' => $cek_doc_obl_update->p3_pejabat_mitra_alamat,
              'p3_pejabat_mitra_telepon' => $cek_doc_obl_update->p3_pejabat_mitra_telepon,
              'p3_status_rapat_pengadaan' => $cek_doc_obl_update->p3_status_rapat_pengadaan,
              'p3_tgl_rapat_pengadaan' => $cek_doc_obl_update->p3_tgl_rapat_pengadaan,
              'p3_tmpt_rapat_pengadaan' => $cek_doc_obl_update->p3_tmpt_rapat_pengadaan,
              'p3_tgl_terima_sp' => $cek_doc_obl_update->p3_tgl_terima_sp,
              'p3_alamat_terima_sp' => $cek_doc_obl_update->p3_alamat_terima_sp,
              'p3_manager_obl' => $cek_doc_obl_update->p3_manager_obl,
              'p4_tgl_p4' => $cek_doc_obl_update->p4_tgl_p4,
              'p4_waktu_layanan' => $cek_doc_obl_update->p4_waktu_layanan,
              'p4_skema_bisnis' => $cek_doc_obl_update->p4_skema_bisnis,
              'p4_mekanisme_pembayaran' => $cek_doc_obl_update->p4_mekanisme_pembayaran,
              'p4_slg' => $cek_doc_obl_update->p4_slg,
              'p4_fasilitator' => $cek_doc_obl_update->p4_fasilitator,
              'p4_pengesahan' => $cek_doc_obl_update->p4_pengesahan,
              'p5_tgl_p5' => $cek_doc_obl_update->p5_tgl_p5,
              'p5_harga_penawaran' => $cek_doc_obl_update->p5_harga_penawaran,
              'p5_ttd_evaluator' => $cek_doc_obl_update->p5_ttd_evaluator,
              'p6_tgl_p6' => $cek_doc_obl_update->p6_tgl_p6,
              'p6_ttd_bast_telkom' => $cek_doc_obl_update->p6_ttd_bast_telkom,
              'p6_ttd_bast_mitra' => $cek_doc_obl_update->p6_ttd_bast_mitra,
              'p6_harga_negosiasi' => $cek_doc_obl_update->p6_harga_negosiasi,
              'p6_nama_peserta_mitra' => $cek_doc_obl_update->p6_nama_peserta_mitra,
              'p6_jabatan_peserta_mitra' => $cek_doc_obl_update->p6_jabatan_peserta_mitra,
              'p6_peserta_rapat_telkom' => $cek_doc_obl_update->p6_peserta_rapat_telkom,
              'p6_pengesahan' => $cek_doc_obl_update->p6_pengesahan,
              'p7_tgl_p7' => $cek_doc_obl_update->p7_tgl_p7,
              'p7_takah_p7' => $cek_doc_obl_update->p7_takah_p7,
              'p7_lampiran_berkas' => $cek_doc_obl_update->p7_lampiran_berkas,
              'p7_harga_pekerjaan' => $cek_doc_obl_update->p7_harga_pekerjaan,
              'p7_skema_bayar' => $cek_doc_obl_update->p7_skema_bayar,
              'p7_pemeriksa' => $cek_doc_obl_update->p7_pemeriksa,
              'p7_tembusan' => $cek_doc_obl_update->p7_tembusan,
              'sp_tgl_sp' => $cek_doc_obl_update->sp_tgl_sp,
              'sp_takah_sp' => $cek_doc_obl_update->sp_takah_sp,
              'sp_nomor_kb' => $cek_doc_obl_update->sp_nomor_kb,
              'p8_tgl_p8' => $cek_doc_obl_update->p8_tgl_p8,
              'p8_takah_p8' => $cek_doc_obl_update->p8_takah_p8,
              'wo_tgl_wo' => $cek_doc_obl_update->wo_tgl_wo,
              'wo_takah_wo' => $cek_doc_obl_update->wo_takah_wo,
              'wo_tgl_fo' => $cek_doc_obl_update->wo_tgl_fo,
              'wo_nomor_kb' => $cek_doc_obl_update->wo_nomor_kb,
              'wo_jenis_layanan' => $cek_doc_obl_update->wo_jenis_layanan,
              'wo_jumlah_layanan' => $cek_doc_obl_update->wo_jumlah_layanan,
              'wo_harga_ke_plggn' => $cek_doc_obl_update->wo_harga_ke_plggn,
              'wo_onetime_charge_plggn' => $cek_doc_obl_update->wo_onetime_charge_plggn,
              'wo_monthly_plggn' => $cek_doc_obl_update->wo_monthly_plggn,
              'wo_onetime_charge_telkom' => $cek_doc_obl_update->wo_onetime_charge_telkom,
              'wo_persen_telkom' => $cek_doc_obl_update->wo_persen_telkom,
              'wo_monthly_telkom' => $cek_doc_obl_update->wo_monthly_telkom,
              'wo_onetime_charge_mitra' => $cek_doc_obl_update->wo_onetime_charge_mitra,
              'wo_persen_mitra' => $cek_doc_obl_update->wo_persen_mitra,
              'wo_monthly_mitra' => $cek_doc_obl_update->wo_monthly_mitra,
              'kl_tgl_kl' => $cek_doc_obl_update->kl_tgl_kl,
              'kl_takah_kl' => $cek_doc_obl_update->kl_takah_kl,
              'kl_nomor_kb' => $cek_doc_obl_update->kl_nomor_kb,
              'kl_no_kl_mitra' => $cek_doc_obl_update->kl_no_kl_mitra,
              'kl_tempat_ttd_kl' => $cek_doc_obl_update->kl_tempat_ttd_kl,
              'kl_notaris' => $cek_doc_obl_update->kl_notaris,
              'kl_akta_notaris' => $cek_doc_obl_update->kl_akta_notaris,
              'kl_tgl_akta_notaris' => $cek_doc_obl_update->kl_tgl_akta_notaris,
              'kl_nama_pejabat_telkom' => $cek_doc_obl_update->kl_nama_pejabat_telkom,
              'kl_jabatan_pejabat_telkom' => $cek_doc_obl_update->kl_jabatan_pejabat_telkom,
              'kl_npwp_mitra' => $cek_doc_obl_update->kl_npwp_mitra,
              'kl_no_anggaran_mitra' => $cek_doc_obl_update->kl_no_anggaran_mitra,
              'kl_tgl_anggaran_mitra' => $cek_doc_obl_update->kl_tgl_anggaran_mitra,
              'kl_nama_pejabat_mitra' => $cek_doc_obl_update->kl_nama_pejabat_mitra,
              'kl_jabatan_pejabat_mitra' => $cek_doc_obl_update->kl_jabatan_pejabat_mitra,
              'kl_no_skm' => $cek_doc_obl_update->kl_no_skm,
              'kl_tgl_skm' => $cek_doc_obl_update->kl_tgl_skm,
              'kl_perihal_skm' => $cek_doc_obl_update->kl_perihal_skm,
              'kl_tgl_akhir_kl' => $cek_doc_obl_update->kl_tgl_akhir_kl,
              'kl_bayar_dp' => $cek_doc_obl_update->kl_bayar_dp,
              'kl_nama_bank_mitra' => $cek_doc_obl_update->kl_nama_bank_mitra,
              'kl_cabang_bank_mitra' => $cek_doc_obl_update->kl_cabang_bank_mitra,
              'kl_rek_bank_mitra' => $cek_doc_obl_update->kl_rek_bank_mitra,
              'kl_an_bank_mitra' => $cek_doc_obl_update->kl_an_bank_mitra,
              'file_p0' => $cek_doc_obl_update->file_p0,
              'file_p1' => $cek_doc_obl_update->file_p1,
              'file_p2' => $cek_doc_obl_update->file_p2,
              'file_p3' => $cek_doc_obl_update->file_p3,
              'file_p4' => $cek_doc_obl_update->file_p4,
              'file_p5' => $cek_doc_obl_update->file_p5,
              'file_p6' => $cek_doc_obl_update->file_p6,
              'file_p7' => $cek_doc_obl_update->file_p7,
              'file_p8' => $cek_doc_obl_update->file_p8,
              'file_sp' => $cek_doc_obl_update->file_sp,
              'file_wo' => $cek_doc_obl_update->file_wo,
              'file_kl' => $cek_doc_obl_update->file_kl
            ]);

            DocObl::where('id',$edit_draf_id)
            ->update(
                $filtered_draf->all()
            );


            if($request->p4_attendees){
                $arr_attendees_draf = [];
                foreach($request->p4_attendees as $key => $value){
                    array_push(
                        $arr_attendees_draf,
                        [
                            'obl_id' => $edit_draf_id,
                            'p4_attendees' => $value
                        ]
                    );
                }

                DB::connection('pgsql')->table('form_p4_attendees')
                ->where('obl_id',$edit_draf_id)
                ->delete();

                DB::connection('pgsql')->table('form_p4_attendees')
                ->insert(
                    $arr_attendees_draf
                );


            }
            return redirect()->route('obl.tables')->with('status', 'Sukses Simpan Draf Edit OBL!');
          }
          catch(Throwable $e){
            return back()->with('status','Oops! Gagal Simpan Draf Edit OBL');
          }
        }
        else{
          // SUBMIT WO,SP,KL (DENGAN VALIDASI)
          $inputan_masuk = [];
          if($request->submit){
            if($request->submit=='submit_wo'){ $inputan_masuk = ['wo_tgl_fo' => 'required']; }
            if($request->submit=='submit_sp' || $request->submit=='submit_kl'){ $inputan_masuk = ['f2_tgl_p1' => 'required']; }
          }
          $inputan_masuk['f1_nilai_kb'] = 'required';
          $inputan_masuk['f1_jenis_kontrak'] = 'required';
          $inputan_masuk['f1_judul_projek'] = 'required';
          $inputan_masuk['f1_nama_plggn'] = 'required';
          $validasi = $request->all();
          $validator = Validator::make($validasi,$inputan_masuk);
          if($validator->fails()){ return back()->withErrors($validator)->withInput(); }
          // $validated = $validator->validated();
          // dd($validated);

          try {
              $collection = collect($request->all());
              $filtered = $collection->except([
                  '_token',
                  'p4_attendees',
                  'edit_draf_id',
                  'f1_mitra_id',
                  'f1_nama_mitra_lain'
              ]);
              // dd($filtered);

              // nomor surat keluar obl (p3, p7, p8, wo, sp, kl)
              // submit draf: tanggal dokumen dan takah tidak terbit
              // submit kl,sp, dan wo : tanggal dokumen dan takah terbit
              // obl hari efektif : 9 hari kerja ( P1 s.d. WO/SP/KL )
              $hari_efektif = 9;
              $hari_efektif = $hari_efektif - 1; // pengecualian tanggal P1
              $cek_per_tanggal = null;

              // tanggal (AM) FO / P1
              $tanggal_mulai = null;
              if($request->submit){
                if($request->submit === 'submit_wo'){
                  if($request->wo_tgl_fo){ $tanggal_mulai = new Carbon($request->wo_tgl_fo); }
                }
                if($request->submit === 'submit_sp' || $request->submit === 'submit_kl'){
                  if($request->f2_tgl_p1){ $tanggal_mulai = new Carbon($request->f2_tgl_p1); }
                }
              }

              $d = $tanggal_mulai->day;
              $m = $tanggal_mulai->month;
              $Y = $tanggal_mulai->year;
              $tgl_p2 = Carbon::create($Y,$m,$d,0)->addDay(1);

              $tahun = $tgl_p1->translatedFormat('Y');
              $is_december = $tgl_p1->translatedFormat('m');
              $libur_nasional_res1 = null;
              $libur_nasional_res2 = null;
              $cuti_bersama_res3 = null;
              $cuti_bersama_res4 = null;
              $weekend = ['Sabtu','Minggu'];
              $hari_kerja = ['Senin','Selasa','Rabu','Kamis','Jumat'];

              $client1 = new Client();
              $client2 = new Client();
              $client3 = new Client();
              $client4 = new Client();

              try {
                $res1 = $client1->request('GET', 'https://api-harilibur.vercel.app/api?year='.$tahun);
                $libur_nasional_res1 = json_decode($res1->getBody()->getContents());
              }catch(ClientException $e){
                    $res1 = $e->getResponse();
                    if($res1->getStatusCode() !== 200){ $libur_nasional_res1 = []; }
              }
              try {
                $res3 = $client3->request('GET', 'https://dayoffapi.vercel.app/api?year='.$tahun);
                $cuti_bersama_res3 = json_decode($res3->getBody()->getContents());
              }catch(ClientException $e){
                    $res3 = $e->getResponse();
                    if($res3->getStatusCode() !== 200){ $cuti_bersama_res3 = []; }
              }

              if( $is_december == '12'){
                try {
                  $res2 = $client2->request('GET', 'https://api-harilibur.vercel.app/api?year='.((int)$tahun + 1));
                  $libur_nasional_res2 = json_decode($res2->getBody()->getContents());
                }catch(ClientException $e){
                      $res2 = $e->getResponse();
                      if($res2->getStatusCode() !== 200){ $libur_nasional_res2 = []; }
                }
                try {
                  $res4 = $client4->request('GET', 'https://dayoffapi.vercel.app/api?year='.((int)$tahun + 1));
                  $cuti_bersama_res4 = json_decode($res4->getBody()->getContents());
                }catch(ClientException $e){
                      $res4 = $e->getResponse();
                      if($res4->getStatusCode() !== 200){ $cuti_bersama_res4 = []; }
                }
              }

              $libur_nasional = [];
              $cuti_bersama = [];
              if($libur_nasional_res1){
                foreach($libur_nasional_res1 as $key => $value){
                  if($value->is_national_holiday == true){ array_push($libur_nasional,$value->holiday_date); }
                }
              }
              if($libur_nasional_res2){
                foreach($libur_nasional_res2 as $key => $value){
                  if($value->is_national_holiday == true){ array_push($libur_nasional,$value->holiday_date); }
                }
              }
              if($cuti_bersama_res3){
                foreach($cuti_bersama_res3 as $key => $value){
                  if($value->is_cuti == true){ array_push($cuti_bersama,$value->tanggal); }
                }
              }
              if($cuti_bersama_res4){
                foreach($cuti_bersama_res4 as $key => $value){
                  if($value->is_cuti == true){ array_push($cuti_bersama,$value->tanggal); }
                }
              }

              $tgl_p2 = $tgl_p1->addDay(1);
              $docs = 40; // 1 hari = 40 dokumen
              $cek = null;
              $arr_tanggal = [];
              $arr_insert_form_takah = [];
              $tanggal_cek = null;
              $tanggal_sebelum = $tgl_p2;
              for($i = 0; $i < $hari_efektif; $i++){
                do{
                  $tanggal_cek = $tanggal_sebelum;
                  $dayOfYear = $tanggal_cek->dayOfYear;
                  $string_tgl = $tanggal_cek->translatedFormat('Y-m-d');
                  $string_hari = $tanggal_cek->translatedFormat('l');
                  if( in_array($string_tgl,$cuti_bersama) ){
                    $cek = false;
                    $tanggal_sebelum = $tanggal_cek->addDay(1);
                  }
                  if( in_array($string_tgl,$libur_nasional) ){
                    $cek = false;
                    $tanggal_sebelum = $tanggal_cek->addDay(1);
                  }
                  else if( in_array($string_hari,$weekend) ){
                    $cek = false;
                    $tanggal_sebelum = $tanggal_cek->addDay(1);
                  }
                  else if( in_array($string_hari,$hari_kerja) ){
                    $cek = true;
                    $skip = null;
                    $takah_1 = null;
                    if($i==1||$i==5||$i==6||$i==7){
                      $takah_1 = ((($dayOfYear-1)*$docs)+1);
                      $takah_1 = sprintf("%04d", $takah_1);
                      do{
                        $cek_form_takah = DB::connection('pgsql')->table('form_takah')->select('*')->where('tanggal',$string_tgl)->where('takah_1',$takah_1)->get()->toArray();
                        if( count($cek_form_takah) > 0 ){ $skip = true; $takah_1++; }
                        else{ $skip = false; array_push($arr_tanggal,[$string_tgl,$takah_1]); array_push($arr_insert_form_takah,['obl_id'=> 0,'tanggal'=>$string_tgl,'takah_1'=>$takah_1]); }
                      }while($skip==true);
                    }
                    else{
                      array_push($arr_tanggal,[$string_tgl,$takah_1]);
                    }
                    $tanggal_sebelum = $tanggal_cek->addDay(1);
                  }
                }while($cek==false);
              }
              // dd($arr_tanggal);

              // append filtered array data
              // append user id
              $filtered->put('updated_by',$user_id);
              $filtered->put('updated_at',$submit_sekarang);
              if($request->p6_harga_negosiasi){ $filtered->put('p7_harga_pekerjaan',$p7_harga_pekerjaan); }
              if($request->f1_keterangan){ $filtered->put('f1_tgl_keterangan',$submit_sekarang); }
              $filtered->put('is_draf',0);
              $filtered->put('f1_jenis_spk',$request->global_jenis_spk);
              $filtered->put('f1_mitra_id',$f1_mitra_id);
              // append tanggal dokumen
              $filtered->put('p2_tgl_p2',$arr_tanggal[0][0]);
              $filtered->put('p3_tgl_p3',$arr_tanggal[1][0]);
              $filtered->put('p4_tgl_p4',$arr_tanggal[2][0]);
              $filtered->put('p5_tgl_p5',$arr_tanggal[3][0]);
              $filtered->put('p6_tgl_p6',$arr_tanggal[4][0]);
              $filtered->put('p7_tgl_p7',$arr_tanggal[5][0]);
              if($request->submit){
                if($request->submit === 'submit_wo'){ $filtered->put('wo_tgl_wo',$arr_tanggal[6][0]); }
                if($request->submit === 'submit_sp'){ $filtered->put('sp_tgl_sp',$arr_tanggal[6][0]); }
                if($request->submit === 'submit_kl'){
                  $filtered->put('p8_tgl_p8',$arr_tanggal[6][0]);
                  $filtered->put('kl_tgl_kl',$arr_tanggal[7][0]);
                }
              }
              // append takah p3,p7,p8,wo,sp,kl
              $arr_tanggal[1][0] = new Carbon( $arr_tanggal[1][0] );
              $arr_tanggal[1][0] = $arr_tanggal[1][0]->year;
              $filtered->put('p3_takah_p3', 'TEL.' . $arr_tanggal[1][1] . '/LG.220/TR6-603/' . $arr_tanggal[1][0]);

              $arr_tanggal[5][0] = new Carbon( $arr_tanggal[5][0] );
              $arr_tanggal[5][0] = $arr_tanggal[5][0]->year;
              $filtered->put('p7_takah_p7', 'TEL.' . $arr_tanggal[5][1] . '/LG.270/TR6-603/' . $arr_tanggal[5][0]);

              // Kontrak Baru / Perpanjangan
              $jenis_kontrak = '';
              if($request->f1_jenis_kontrak){
                if($request->f1_jenis_kontrak == 'perpanjangan'){ $jenis_kontrak = 'HK.820'; }
                if($request->f1_jenis_kontrak == 'baru'){ $jenis_kontrak = 'HK.810'; }
              }
              // Kode Pimpinan : Nilai KB < 1M / > 1M
              $kode_pimpinan = '';
              if($request->f1_nilai_kb){
                $nilai_kb = $request->f1_nilai_kb;
                $nilai_kb_filter = str_replace( ',','.',str_replace('Rp','',str_replace('.','',$nilai_kb) ) );
                if($nilai_kb_filter < 1000000000.00 ){ $kode_pimpinan = 'TR6-600'; }
                if($nilai_kb_filter >= 1000000000.00 ){ $kode_pimpinan = 'TR6-001'; }
              }

              if($request->submit){
                if($request->submit === 'submit_wo'){
                  $arr_tanggal[6][0] = new Carbon( $arr_tanggal[6][0] );
                  $arr_tanggal[6][0] = $arr_tanggal[6][0]->year;
                  $filtered->put('wo_takah_wo', 'K.TEL.' . $arr_tanggal[6][1] . '/' . $jenis_kontrak . '/' . $kode_pimpinan . '/' . $arr_tanggal[6][0]);
                  array_splice($arr_insert_form_takah,3);
                }
                if($request->submit === 'submit_sp'){
                  $arr_tanggal[6][0] = new Carbon( $arr_tanggal[6][0] );
                  $arr_tanggal[6][0] = $arr_tanggal[6][0]->year;
                  $filtered->put('sp_takah_sp', 'K.TEL.' . $arr_tanggal[6][1] . '/' . $jenis_kontrak . '/' . $kode_pimpinan . '/' . $arr_tanggal[6][0]);
                  array_splice($arr_insert_form_takah,3);
                }
                if($request->submit === 'submit_kl'){
                  $arr_tanggal[6][0] = new Carbon( $arr_tanggal[6][0] );
                  $arr_tanggal[6][0] = $arr_tanggal[6][0]->year;
                  $filtered->put('p8_takah_p8', 'TEL.' . $arr_tanggal[6][1] . '/LG.270/' . $kode_pimpinan . '/' . $arr_tanggal[6][0]);
                  $arr_tanggal[7][0] = new Carbon( $arr_tanggal[7][0] );
                  $arr_tanggal[7][0] = $arr_tanggal[7][0]->year;
                  $filtered->put('kl_takah_kl', 'K.TEL.' . $arr_tanggal[7][1] . '/' . $jenis_kontrak . '/' . $kode_pimpinan . '/' . $arr_tanggal[7][0]);
                }
              }


              // INSERT DATA TO OBL DATABASE
              DB::connection('pgsql')->table('form_obl_histori')
              ->insert([
                'obl_id' => $cek_doc_obl_update->id,
                'submit' => $cek_doc_obl_update->submit,
                'revisi_witel' => $cek_doc_obl_update->revisi_witel,
                'revisi_witel_count' => $cek_doc_obl_update->revisi_witel_count,
                'is_draf' => $cek_doc_obl_update->is_draf,
                'updated_at' => $cek_doc_obl_update->updated_at,
                'updated_by' => $cek_doc_obl_update->updated_by,
                'p0_nomor_p0' => $cek_doc_obl_update->p0_nomor_p0,
                'p0_nik_am' => $cek_doc_obl_update->p0_nik_am,
                'p0_nik_manager' => $cek_doc_obl_update->p0_nik_manager,
                'p0_tgl_submit' => $cek_doc_obl_update->p0_tgl_submit,
                'p0_pemeriksa' => $cek_doc_obl_update->p0_pemeriksa,
                'p0_nik_gm' => $cek_doc_obl_update->p0_nik_gm,
                'p1_nomor_p1' => $cek_doc_obl_update->p1_nomor_p1,
                'p1_tgl_p1' => $cek_doc_obl_update->p1_tgl_p1,
                'p1_pemeriksa' => $cek_doc_obl_update->p1_pemeriksa,
                'p1_tgl_delivery' => $cek_doc_obl_update->p1_tgl_delivery,
                'p1_lokasi_instal' => $cek_doc_obl_update->p1_lokasi_instal,
                'p1_skema_bisnis' => $cek_doc_obl_update->p1_skema_bisnis,
                'p1_skema_bayar' => $cek_doc_obl_update->p1_skema_bayar,
                'p1_mekanisme_bayar' => $cek_doc_obl_update->p1_mekanisme_bayar,
                'p1_tgl_kontrak_mulai' => $cek_doc_obl_update->p1_tgl_kontrak_mulai,
                'p1_tgl_kontrak_akhir' => $cek_doc_obl_update->p1_tgl_kontrak_akhir,
                'p1_tgl_doc_plggn' => $cek_doc_obl_update->p1_tgl_doc_plggn,
                'p1_estimasi_harga' => $cek_doc_obl_update->p1_estimasi_harga,
                'p1_disetujui_gm' => $cek_doc_obl_update->p1_disetujui_gm,
                'p1_dibuat_am' => $cek_doc_obl_update->p1_dibuat_am,
                'p1_diperiksa_manager' => $cek_doc_obl_update->p1_diperiksa_manager,
                'f1_nama_plggn' => $cek_doc_obl_update->f1_nama_plggn,
                'f1_alamat_plggn' => $cek_doc_obl_update->f1_alamat_plggn,
                'f1_witel' => $cek_doc_obl_update->f1_witel,
                'f1_judul_projek' => $cek_doc_obl_update->f1_judul_projek,
                'f1_segmen' => $cek_doc_obl_update->f1_segmen,
                'f1_proses' => $cek_doc_obl_update->f1_proses,
                'f1_folder' => $cek_doc_obl_update->f1_folder,
                'f1_nilai_kb' => $cek_doc_obl_update->f1_nilai_kb,
                'f1_no_kfs_spk' => $cek_doc_obl_update->f1_no_kfs_spk,
                'f1_quote_kontrak' => $cek_doc_obl_update->f1_quote_kontrak,
                'f1_nomor_akun' => $cek_doc_obl_update->f1_nomor_akun,
                'f1_jenis_kontrak' => $cek_doc_obl_update->f1_jenis_kontrak,
                'f1_skema_bayar' => $cek_doc_obl_update->f1_skema_bayar,
                'f1_status_order' => $cek_doc_obl_update->f1_status_order,
                'f1_status_sm' => $cek_doc_obl_update->f1_status_sm,
                'f1_tgl_keterangan' => $cek_doc_obl_update->f1_tgl_keterangan,
                'f1_keterangan' => $cek_doc_obl_update->f1_keterangan,
                'f1_mitra_id' => $cek_doc_obl_update->f1_mitra_id,
                'f1_pic_mitra' => $cek_doc_obl_update->f1_pic_mitra,
                'f1_jenis_spk' => $cek_doc_obl_update->f1_jenis_spk,
                'f1_masa_layanan_tahun' => $cek_doc_obl_update->f1_masa_layanan_tahun,
                'f1_masa_layanan_bulan' => $cek_doc_obl_update->f1_masa_layanan_bulan,
                'f1_masa_layanan_hari' => $cek_doc_obl_update->f1_masa_layanan_hari,
                'f1_pic_plggn' => $cek_doc_obl_update->f1_pic_plggn,
                'f2_nilai_kontrak' => $cek_doc_obl_update->f2_nilai_kontrak,
                'f2_tgl_p1' => $cek_doc_obl_update->f2_tgl_p1,
                'p2_tgl_p2' => $cek_doc_obl_update->p2_tgl_p2,
                'p2_tgl_justifikasi' => $cek_doc_obl_update->p2_tgl_justifikasi,
                'p2_dievaluasi_oleh' => $cek_doc_obl_update->p2_dievaluasi_oleh,
                'p2_disetujui_oleh' => $cek_doc_obl_update->p2_disetujui_oleh,
                'p2_pilihan_catatan' => $cek_doc_obl_update->p2_pilihan_catatan,
                'p2_catatan' => $cek_doc_obl_update->p2_catatan,
                'p3_tgl_p3' => $cek_doc_obl_update->p3_tgl_p3,
                'p3_takah_p3' => $cek_doc_obl_update->p3_takah_p3,
                'p3_pejabat_mitra_nama' => $cek_doc_obl_update->p3_pejabat_mitra_nama,
                'p3_pejabat_mitra_alamat' => $cek_doc_obl_update->p3_pejabat_mitra_alamat,
                'p3_pejabat_mitra_telepon' => $cek_doc_obl_update->p3_pejabat_mitra_telepon,
                'p3_status_rapat_pengadaan' => $cek_doc_obl_update->p3_status_rapat_pengadaan,
                'p3_tgl_rapat_pengadaan' => $cek_doc_obl_update->p3_tgl_rapat_pengadaan,
                'p3_tmpt_rapat_pengadaan' => $cek_doc_obl_update->p3_tmpt_rapat_pengadaan,
                'p3_tgl_terima_sp' => $cek_doc_obl_update->p3_tgl_terima_sp,
                'p3_alamat_terima_sp' => $cek_doc_obl_update->p3_alamat_terima_sp,
                'p3_manager_obl' => $cek_doc_obl_update->p3_manager_obl,
                'p4_tgl_p4' => $cek_doc_obl_update->p4_tgl_p4,
                'p4_waktu_layanan' => $cek_doc_obl_update->p4_waktu_layanan,
                'p4_skema_bisnis' => $cek_doc_obl_update->p4_skema_bisnis,
                'p4_mekanisme_pembayaran' => $cek_doc_obl_update->p4_mekanisme_pembayaran,
                'p4_slg' => $cek_doc_obl_update->p4_slg,
                'p4_fasilitator' => $cek_doc_obl_update->p4_fasilitator,
                'p4_pengesahan' => $cek_doc_obl_update->p4_pengesahan,
                'p5_tgl_p5' => $cek_doc_obl_update->p5_tgl_p5,
                'p5_harga_penawaran' => $cek_doc_obl_update->p5_harga_penawaran,
                'p5_ttd_evaluator' => $cek_doc_obl_update->p5_ttd_evaluator,
                'p6_tgl_p6' => $cek_doc_obl_update->p6_tgl_p6,
                'p6_ttd_bast_telkom' => $cek_doc_obl_update->p6_ttd_bast_telkom,
                'p6_ttd_bast_mitra' => $cek_doc_obl_update->p6_ttd_bast_mitra,
                'p6_harga_negosiasi' => $cek_doc_obl_update->p6_harga_negosiasi,
                'p6_nama_peserta_mitra' => $cek_doc_obl_update->p6_nama_peserta_mitra,
                'p6_jabatan_peserta_mitra' => $cek_doc_obl_update->p6_jabatan_peserta_mitra,
                'p6_peserta_rapat_telkom' => $cek_doc_obl_update->p6_peserta_rapat_telkom,
                'p6_pengesahan' => $cek_doc_obl_update->p6_pengesahan,
                'p7_tgl_p7' => $cek_doc_obl_update->p7_tgl_p7,
                'p7_takah_p7' => $cek_doc_obl_update->p7_takah_p7,
                'p7_lampiran_berkas' => $cek_doc_obl_update->p7_lampiran_berkas,
                'p7_harga_pekerjaan' => $cek_doc_obl_update->p7_harga_pekerjaan,
                'p7_skema_bayar' => $cek_doc_obl_update->p7_skema_bayar,
                'p7_pemeriksa' => $cek_doc_obl_update->p7_pemeriksa,
                'p7_tembusan' => $cek_doc_obl_update->p7_tembusan,
                'sp_tgl_sp' => $cek_doc_obl_update->sp_tgl_sp,
                'sp_takah_sp' => $cek_doc_obl_update->sp_takah_sp,
                'sp_nomor_kb' => $cek_doc_obl_update->sp_nomor_kb,
                'p8_tgl_p8' => $cek_doc_obl_update->p8_tgl_p8,
                'p8_takah_p8' => $cek_doc_obl_update->p8_takah_p8,
                'wo_tgl_wo' => $cek_doc_obl_update->wo_tgl_wo,
                'wo_takah_wo' => $cek_doc_obl_update->wo_takah_wo,
                'wo_tgl_fo' => $cek_doc_obl_update->wo_tgl_fo,
                'wo_nomor_kb' => $cek_doc_obl_update->wo_nomor_kb,
                'wo_jenis_layanan' => $cek_doc_obl_update->wo_jenis_layanan,
                'wo_jumlah_layanan' => $cek_doc_obl_update->wo_jumlah_layanan,
                'wo_harga_ke_plggn' => $cek_doc_obl_update->wo_harga_ke_plggn,
                'wo_onetime_charge_plggn' => $cek_doc_obl_update->wo_onetime_charge_plggn,
                'wo_monthly_plggn' => $cek_doc_obl_update->wo_monthly_plggn,
                'wo_onetime_charge_telkom' => $cek_doc_obl_update->wo_onetime_charge_telkom,
                'wo_persen_telkom' => $cek_doc_obl_update->wo_persen_telkom,
                'wo_monthly_telkom' => $cek_doc_obl_update->wo_monthly_telkom,
                'wo_onetime_charge_mitra' => $cek_doc_obl_update->wo_onetime_charge_mitra,
                'wo_persen_mitra' => $cek_doc_obl_update->wo_persen_mitra,
                'wo_monthly_mitra' => $cek_doc_obl_update->wo_monthly_mitra,
                'kl_tgl_kl' => $cek_doc_obl_update->kl_tgl_kl,
                'kl_takah_kl' => $cek_doc_obl_update->kl_takah_kl,
                'kl_nomor_kb' => $cek_doc_obl_update->kl_nomor_kb,
                'kl_no_kl_mitra' => $cek_doc_obl_update->kl_no_kl_mitra,
                'kl_tempat_ttd_kl' => $cek_doc_obl_update->kl_tempat_ttd_kl,
                'kl_notaris' => $cek_doc_obl_update->kl_notaris,
                'kl_akta_notaris' => $cek_doc_obl_update->kl_akta_notaris,
                'kl_tgl_akta_notaris' => $cek_doc_obl_update->kl_tgl_akta_notaris,
                'kl_nama_pejabat_telkom' => $cek_doc_obl_update->kl_nama_pejabat_telkom,
                'kl_jabatan_pejabat_telkom' => $cek_doc_obl_update->kl_jabatan_pejabat_telkom,
                'kl_npwp_mitra' => $cek_doc_obl_update->kl_npwp_mitra,
                'kl_no_anggaran_mitra' => $cek_doc_obl_update->kl_no_anggaran_mitra,
                'kl_tgl_anggaran_mitra' => $cek_doc_obl_update->kl_tgl_anggaran_mitra,
                'kl_nama_pejabat_mitra' => $cek_doc_obl_update->kl_nama_pejabat_mitra,
                'kl_jabatan_pejabat_mitra' => $cek_doc_obl_update->kl_jabatan_pejabat_mitra,
                'kl_no_skm' => $cek_doc_obl_update->kl_no_skm,
                'kl_tgl_skm' => $cek_doc_obl_update->kl_tgl_skm,
                'kl_perihal_skm' => $cek_doc_obl_update->kl_perihal_skm,
                'kl_tgl_akhir_kl' => $cek_doc_obl_update->kl_tgl_akhir_kl,
                'kl_bayar_dp' => $cek_doc_obl_update->kl_bayar_dp,
                'kl_nama_bank_mitra' => $cek_doc_obl_update->kl_nama_bank_mitra,
                'kl_cabang_bank_mitra' => $cek_doc_obl_update->kl_cabang_bank_mitra,
                'kl_rek_bank_mitra' => $cek_doc_obl_update->kl_rek_bank_mitra,
                'kl_an_bank_mitra' => $cek_doc_obl_update->kl_an_bank_mitra,
                'file_p0' => $cek_doc_obl_update->file_p0,
                'file_p1' => $cek_doc_obl_update->file_p1,
                'file_p2' => $cek_doc_obl_update->file_p2,
                'file_p3' => $cek_doc_obl_update->file_p3,
                'file_p4' => $cek_doc_obl_update->file_p4,
                'file_p5' => $cek_doc_obl_update->file_p5,
                'file_p6' => $cek_doc_obl_update->file_p6,
                'file_p7' => $cek_doc_obl_update->file_p7,
                'file_p8' => $cek_doc_obl_update->file_p8,
                'file_sp' => $cek_doc_obl_update->file_sp,
                'file_wo' => $cek_doc_obl_update->file_wo,
                'file_kl' => $cek_doc_obl_update->file_kl
              ]);

              DB::connection('pgsql')->table('form_obl')
              ->where('id',$edit_draf_id)
              ->update(
                  $filtered->all()
              );

              // INSERT TAKAH
              $insert_takah_1 = [];
              foreach($arr_insert_form_takah as $value){
                  array_push($insert_takah_1,
                    [
                      'obl_id' => $obl_id,
                      'tanggal' => $value['tanggal'],
                      'takah_1' => $value['takah_1']
                    ]
                  );
              }
              DB::connection('pgsql')->table('form_takah')
              ->insert(
                  $insert_takah_1
              );

              // INPUT P4 ATTENDEES
              if($request->p4_attendees){
                  $cek_p4_attendees = DB::connection('pgsql')->table('form_p4_attendees')->where('obl_id',$edit_draf_id)->get()->toArray();
                  if( count($cek_p4_attendees) > 0 ){ DB::connection('pgsql')->table('form_p4_attendees')->where('obl_id',$edit_draf_id)->delete(); }

                  $arr_attendees = [];
                  foreach($request->p4_attendees as $key => $value){
                      array_push(
                          $arr_attendees,
                          [
                              'obl_id' => $edit_draf_id,
                              'p4_attendees' => $value
                          ]
                      );
                  }

                  DB::connection('pgsql')->table('form_p4_attendees')
                  ->insert(
                      $arr_attendees
                  );
              }

              $dok_obl = '';
              if($request->submit){
                if($request->submit === 'submit_wo'){ $dok_obl = 'WO'; }
                if($request->submit === 'submit_sp'){ $dok_obl = 'SP'; }
                if($request->submit === 'submit_kl'){ $dok_obl = 'KL'; }
              }
              return redirect()->route('obl.tables')->with('status', 'Sukses Simpan Edit OBL : ' . $dok_obl);
          }
          catch(Throwable $e){
              // report($e);
              // return false;
              // return redirect()->back()->with('status',$e);
              // return redirect()->back()->with('status','Gagal Simpan OBL!');
              return back()->with('status','Oops! Gagal Simpan Edit OBL!');
          }
        }
      }
      // end user obl

      else{ redirect()->route('obl.tables')->with('status', 'Oops! Gagal Cek ID User.'); }

    }

}
