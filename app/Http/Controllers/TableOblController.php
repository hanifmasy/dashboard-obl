<?php

namespace App\Http\Controllers;

use App\Exceptions\Handler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\DocObl;
use Carbon\Carbon;
use DataTables;

class TableOblController extends Controller
{
    public function tables(Request $request){
      if($request->ajax()){
        $data = DocObl::leftJoin('users as u','u.id','=','obl.user_id')
        ->select(
                  'obl.id as obl_id',
                  DB::raw("
                  case
                  when submit like 'draf_filter_%' then 'filter'
                  when submit like 'draf_p%' then 'form'
                  when submit in ('draf_wo','draf_sp','draf_kl') then 'kontrak1'
                  when submit in ('submit_wo','submit_sp','submit_kl') then 'kontrak2'
                  end as filter_submit"),
                  DB::raw("replace(submit,'_',' ') as string_submit"),
                  DB::raw("case when f1_segmen is null or f1_segmen = '' then '' else f1_segmen end as segmen"),
                  DB::raw("to_char(obl.created_at,'YYYY-MM-DD HH24:MI') as string_tgl_submit"),
                  DB::raw("to_char(obl.updated_at,'YYYY-MM-DD HH24:MI') as string_tgl_update"),
                  DB::raw("case when f1_jenis_spk is null or f1_jenis_spk = '' then '' else f1_jenis_spk end as jenis_spk"),
                  DB::raw("case when f1_witel is null or f1_witel = '' then '' else f1_witel end as witel"),
                  DB::raw("case when f1_nama_plggn is null or f1_nama_plggn = '' then '' else f1_nama_plggn end as nama_plggn"),
                  DB::raw("
                  case
                  when p2_lingkup_kerja is null or p2_lingkup_kerja = '' then wo_jenis_layanan
                  when wo_jenis_layanan is null or wo_jenis_layanan = '' then p2_lingkup_kerja
                  else '-'
                  end as layanan
                  "),
                  DB::raw("case when f1_nama_mitra is null or f1_nama_mitra = '' then '' else f1_nama_mitra end as nama_vendor"),
                  DB::raw("case when p4_masa_layanan is null or p4_masa_layanan = '' then '' else concat(p4_masa_layanan,' ',p4_satuan_masa_layanan) end as jangka_waktu"),
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
                  DB::raw("f1_tgl_keterangan as tgl_keterangan"),
                  DB::raw("case when f1_keterangan is null or f1_keterangan = '' then '' else f1_keterangan end as keterangan"),
                  DB::raw("u.nama_lengkap as updated_by")
                )
          // ->where('user_id', Auth::user()->id)
          // ->where('is_draf', 0)
          ->orderBy('obl.created_at','DESC')
          ->orderBy('obl.updated_at','DESC')
          ->get();
        // dd($data);
        return DataTables::of($data)->addIndexColumn()->make(true);
      }
      return view('pages.obls.tables');
    }
}
