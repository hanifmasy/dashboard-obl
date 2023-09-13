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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use NumberToWords\NumberToWords;
use Laraindo\RupiahFormat;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Writer\Word2007;
use App\Models\User;
use App\Models\MitraVendor;
use App\Models\DocObl;
use App\Models\DocOblHistori;
use Carbon\Carbon;
use DataTables;

class PraLopController extends Controller
{
  public function index(Request $request){
    // dd($request->all(),Crypt::decryptString($request->cl));
    if($request->ajax()){
      // dd($request->all());
      $user_in_is = User::leftJoin('user_role','user_role.user_id','=','users.id')
      ->leftJoin('witels','witels.id','=','users.witel_id')
      ->leftJoin('user_mitra','user_mitra.user_id','=','users.id')
      ->leftJoin('mitras','mitras.id','=','user_mitra.mitra_id')
      ->select('users.id','user_role.role_id','users.witel_id','witels.nama_witel','mitras.nama_mitra','mitras.id as mitra_id')->where('users.id',Auth::id())->first();

      $query = DB::connection('pgsql')->table('form_pralop as fp')
      ->leftJoin('users as u','u.id','=','fp.created_by')
      ->leftJoin('users as uu','uu.id','=','fp.updated_by')
      ->select('fp.*','u.nama_lengkap as user_create','uu.nama_lengkap as user_update');

      if($user_in_is->role_id === 4 || $user_in_is->role_id === 5){
        $query->where('fp.lop_witel',$user_in_is->nama_witel);
      }
      if($user_in_is->role_id !== 4 && $user_in_is->role_id !== 5){
        if($request->ajx_wl){ $query->where('fp.lop_witel',$request->ajx_wl); }
      }
      if($request->ajx_cl){
        $cl = $request->ajx_cl;
        if($cl==='b'){ $query->whereRaw(" fp.on_handling = 'witel' "); }
        if($cl==='c'){ $query->whereRaw(" fp.on_handling = 'solution' "); }
        if($cl==='d'){ $query->whereRaw(" fp.on_handling = 'legal' "); }
        if($cl==='e'){ $query->whereRaw(" fp.on_handling = 'final_pralop' "); }
        if($cl==='f'){ $query->whereRaw(" fp.lop_count_revisi > 0 "); }
        if($cl==='g'){ $query->whereRaw(" fp.lop_count_revisi > 0 "); }
      }

      $data = $query->whereRaw(" (fp.deleted_at is null or to_char(fp.deleted_at,'yyyy-mm-dd') = '') ")
        ->orderByRaw("CASE WHEN fp.updated_at IS NULL THEN 0 ELSE 1 END DESC")->orderBy('fp.updated_at','DESC')
        ->get();
      return DataTables::of($data)
      ->addIndexColumn()
      ->addColumn('id', function($row)
      {
        $salt = Crypt::encryptString(bin2hex('JANJIJIWA_' . $row->id));
        return $salt;
        // return $row->id;
      })
      ->make(true);
    }
    $user_pralop = User::leftJoin('user_role','user_role.user_id','=','users.id')
    ->leftJoin('witels','witels.id','=','users.witel_id')
    ->leftJoin('user_mitra','user_mitra.user_id','=','users.id')
    ->leftJoin('mitras','mitras.id','=','user_mitra.mitra_id')
    ->select('users.id','user_role.role_id','users.witel_id','witels.nama_witel','mitras.nama_mitra','mitras.id as mitra_id')->where('users.id',Auth::id())->first();
    $wl = '';
    $cl = '';
    if($user_pralop->role_id !== 4 && $user_pralop->role_id !== 5){
      if($request->wl){ $wl = $request->wl; }
    }
    if($request->cl){
      $cl = Crypt::decryptString($request->cl);
    }
    // dd($request->all(),Crypt::decryptString($request->cl));
    return view('pages.pralop.index',compact('user_pralop','wl','cl'));
  }

  public function detail(Request $request){
    $edit_pralop_id = str_replace('JANJIJIWA_','',hex2bin(Crypt::decryptString($request->edit_pralop_id)));
    $user_pralop = User::leftJoin('user_role','user_role.user_id','=','users.id')
    ->leftJoin('witels','witels.id','=','users.witel_id')
    ->leftJoin('user_mitra','user_mitra.user_id','=','users.id')
    ->leftJoin('mitras','mitras.id','=','user_mitra.mitra_id')
    ->select('users.id','user_role.role_id','users.witel_id','witels.nama_witel','mitras.nama_mitra','mitras.id as mitra_id')->where('users.id',Auth::id())->first();
    $pralop = DB::connection('pgsql')->table('form_pralop as fp')
    ->leftJoin('users as u','u.id','=','fp.updated_by')
    ->select('fp.*','fp.lop_keterangan as keterangan',DB::raw(" to_char(lop_tgl_keterangan,'DD MON YYYY hh24:mi') as tgl_keterangan"),DB::raw(" (case when lop_tgl_keterangan is null then 0 else TO_CHAR(lop_tgl_keterangan,'yyyymmdd.hh24mi')::NUMERIC end) as sort_tgl"),'u.nama_lengkap as user_update')
    ->where('fp.id',$edit_pralop_id)->first();

    if( ($user_pralop->role_id === 4 || $user_pralop->role_id === 5) && ( $pralop->on_handling !== 'witel' && $pralop->on_handling !== 'final_pralop' ) ){
      return redirect()->route('witels.pralop');
    }
    else if( $user_pralop->role_id === 8 && $pralop->on_handling !== 'solution' ){
      return redirect()->route('witels.pralop');
    }
    else if( $user_pralop->role_id === 13 && $pralop->on_handling !== 'legal' ){
      return redirect()->route('witels.pralop');
    }
    else if($user_pralop->role_id !== 9 && $user_pralop->role_id !== 4 && $user_pralop->role_id !== 5 && $user_pralop->role_id !== 8 && $user_pralop->role_id !== 13){
      return redirect()->route('witels.pralop');
    }



    $pralop_histori = DB::connection('pgsql')->table('form_pralop_histori as fp')
    ->leftJoin('users as u','u.id','=','fp.updated_by')
    ->select('fp.*','fp.lop_keterangan as keterangan',DB::raw(" to_char(lop_tgl_keterangan,'DD MON YYYY hh24:mi') as tgl_keterangan"),DB::raw(" (case when lop_tgl_keterangan is null then 0 else TO_CHAR(lop_tgl_keterangan,'yyyymmdd.hh24mi')::NUMERIC end) as sort_tgl"),'u.nama_lengkap as user_update')
    ->where('lop_id_pralop',$edit_pralop_id)->orderBy('updated_at','desc')
    ->orderByRaw("CASE WHEN fp.updated_at IS NULL THEN 0 ELSE 1 END DESC")->orderBy('fp.updated_at','DESC')
    ->get()->toArray();
    $obl = DB::connection('pgsql')->table('form_obl as fo')
    ->leftJoin('users as u','u.id','=','fo.updated_by')
    ->select('fo.f1_keterangan as keterangan',DB::raw(" to_char(fo.f1_tgl_keterangan,'DD MON YYYY hh24:mi') as tgl_keterangan"),DB::raw(" (case when fo.f1_tgl_keterangan is null then 0 else TO_CHAR(fo.f1_tgl_keterangan,'yyyymmdd.hh24mi')::NUMERIC end) as sort_tgl"),'u.nama_lengkap as user_update')
    ->where('fo.f1_id_form_pralop',$edit_pralop_id)
    ->orderByRaw("CASE WHEN fo.updated_at IS NULL THEN 0 ELSE 1 END DESC")->orderBy('fo.updated_at','DESC')
    ->get()->toArray();
    $obl_histori = DB::connection('pgsql')->table('form_obl_histori as fo')
    ->leftJoin('users as u','u.id','=','fo.updated_by')
    ->select('fo.f1_keterangan as keterangan',DB::raw(" to_char(fo.f1_tgl_keterangan,'DD MON YYYY hh24:mi') as tgl_keterangan"),DB::raw(" (case when fo.f1_tgl_keterangan is null then 0 else TO_CHAR(fo.f1_tgl_keterangan,'yyyymmdd.hh24mi')::NUMERIC end) as sort_tgl"),'u.nama_lengkap as user_update')
    ->where('fo.f1_id_form_pralop',$edit_pralop_id)
    ->orderByRaw("CASE WHEN fo.updated_at IS NULL THEN 0 ELSE 1 END DESC")->orderBy('fo.updated_at','DESC')
    ->get()->toArray();

    $arr_log_histori = [];
    array_push($arr_log_histori,json_decode(json_encode($pralop), true));
    foreach($pralop_histori as $key => $value){ array_push($arr_log_histori,json_decode(json_encode($value), true)); }
    foreach($obl as $key => $value){ array_push($arr_log_histori,json_decode(json_encode($value), true)); }
    foreach($obl_histori as $key => $value){ array_push($arr_log_histori,json_decode(json_encode($value), true)); }
    usort($arr_log_histori, function ($a, $b) {return $a['sort_tgl'] < $b['sort_tgl'];});

    $layanan = DB::connection('pgsql')->table('form_obl as fo')
    ->leftJoin('mitras as m','m.id','=','fo.f1_mitra_id')
    ->select('fo.*','m.nama_mitra',DB::raw("to_char(fo.p1_tgl_delivery,'yyyy-mm-dd') as tgl_delivery_p1"))
    ->where('fo.f1_id_form_pralop',$edit_pralop_id)
    ->get()->toArray();
    $encrypted = $request->edit_pralop_id;

    return view('pages.pralop.detail',compact('pralop','pralop_histori','layanan','encrypted','user_pralop','arr_log_histori'));
  }

  public function updatePraLopHistori($var_pralop_id){
    $data_lama = DB::connection('pgsql')->table('form_pralop')->select('*')->where('id',$var_pralop_id)->first();
    DB::connection('pgsql')->table('form_pralop_histori')->insert([
      'on_handling' => $data_lama->on_handling,
      'lop_id_pralop' => $data_lama->id,
      'lop_judul_projek' => $data_lama->lop_judul_projek,
      'lop_nama_plggn' => $data_lama->lop_nama_plggn,
      'lop_alamat_plggn' => $data_lama->lop_alamat_plggn,
      'lop_pic_plggn' => $data_lama->lop_pic_plggn,
      'lop_id_mytens' => $data_lama->lop_id_mytens,
      'lop_nomor_akun' => $data_lama->lop_nomor_akun,
      'lop_nilai_kb' => $data_lama->lop_nilai_kb,
      'lop_segmen' => $data_lama->lop_segmen,
      'lop_skema_bayar' => $data_lama->lop_skema_bayar,
      'lop_status_order' => $data_lama->lop_status_order,
      'lop_tgl_keterangan' => $data_lama->lop_tgl_keterangan,
      'lop_keterangan' => $data_lama->lop_keterangan,
      'updated_at' => $data_lama->updated_at,
      'updated_by' => $data_lama->updated_by
    ]);
    return $data_lama;
  }

  public function update(Request $request){
    // dd($request->all());
    $user_in_is = User::leftJoin('user_role','user_role.user_id','=','users.id')
    ->leftJoin('witels','witels.id','=','users.witel_id')
    ->leftJoin('user_mitra','user_mitra.user_id','=','users.id')
    ->leftJoin('mitras','mitras.id','=','user_mitra.mitra_id')
    ->select('users.id','user_role.role_id','users.witel_id','witels.nama_witel','mitras.nama_mitra','mitras.id as mitra_id')->where('users.id',Auth::id())->first();
    $on_handling = '';
    if( $user_in_is->role_id === 4 ){ $on_handling = 'witel'; }
    if( $user_in_is->role_id === 8 || $user_in_is->role_id === 9 ){ $on_handling = 'solution'; }
    if( $user_in_is->role_id === 13 ){ $on_handling = 'legal'; }
    // if( $user_in_is->role_id === 9 ){ $on_handling = 'superadmin'; }

    if(str_contains($request->submit,'lop_keterangan_')){
      // if(!$request->lop_keterangan){ return redirect()->route('witels.pralop.detail',['edit_pralop_id'=>Crypt::encryptString(bin2hex('JANJIJIWA_' . str_replace('lop_keterangan_','',$request->submit)))])->with('status','Oops! Keterangan Kosong.'); }
      $inputan_masuk = [];
      $inputan_masuk['lop_keterangan'] = 'required';
      $validasi = $request->all();
      $validator_draf = Validator::make($validasi,$inputan_masuk);
      if($validator_draf->fails()){ return back()->withErrors($validator_draf)->withInput(); }

      $data_lama = $this->updatePraLopHistori(str_replace('lop_keterangan_','',$request->submit));
      DB::connection('pgsql')->table('form_pralop')->where('id',str_replace('lop_keterangan_','',$request->submit))->update([
        'on_handling' => $on_handling,
        'lop_tgl_keterangan' => Carbon::now()->translatedFormat('Y-m-d H:i:s'),
        'lop_keterangan' => '[' . ucfirst($on_handling) .'] ' . $request->lop_keterangan,
        'updated_at' => Carbon::now()->translatedFormat('Y-m-d H:i:s'),
        'updated_by' => Auth::id()
      ]);

      return redirect()->route('witels.pralop.detail',['edit_pralop_id'=>Crypt::encryptString(bin2hex('JANJIJIWA_' . str_replace('lop_keterangan_','',$request->submit)))])->with('status','Sukses Simpan PRA LOP Keterangan.');
    }
    if(str_contains($request->submit,'pralop_detail_')){
      $inputan_masuk = [];
      $inputan_masuk['lop_judul_projek'] = 'required';
      $inputan_masuk['lop_nama_plggn'] = 'required';
      $validasi = $request->all();
      $validator_draf = Validator::make($validasi,$inputan_masuk);
      if($validator_draf->fails()){ return back()->withErrors($validator_draf)->withInput(); }

      $data_lama = $this->updatePraLopHistori(str_replace('pralop_detail_','',$request->submit));
      $lop_keterangan = '[' . ucfirst($on_handling) .'] ';
      if( $request->lop_judul_projek !== $data_lama->lop_judul_projek ){ $lop_keterangan = $lop_keterangan . ' JUDUL_PROJEK: [ old=' . $data_lama->lop_judul_projek . ';new=' . $request->lop_judul_projek . ' ] | '; }
      if( $request->lop_nama_plggn !== $data_lama->lop_nama_plggn ){ $lop_keterangan = $lop_keterangan . ' NAMA_PLGGN: [ old=' . $data_lama->lop_nama_plggn . ';new=' . $request->lop_nama_plggn . ' ] | '; }
      if( $request->lop_alamat_plggn !== $data_lama->lop_alamat_plggn ){ $lop_keterangan = $lop_keterangan . ' ALAMAT_PLGGN: [ old=' . $data_lama->lop_alamat_plggn . ';new=' . $request->lop_alamat_plggn . ' ] | '; }
      if( $request->lop_pic_plggn !== $data_lama->lop_pic_plggn ){ $lop_keterangan = $lop_keterangan . ' PIC_PLGGN: [ old=' . $data_lama->lop_pic_plggn . ';new=' . $request->lop_pic_plggn . ' ] | '; }
      if( $request->lop_id_mytens !== $data_lama->lop_id_mytens ){ $lop_keterangan = $lop_keterangan . ' ID_MYTENS: [ old=' . $data_lama->lop_id_mytens . ';new=' . $request->lop_id_mytens . ' ] | '; }
      if( $request->lop_nomor_akun !== $data_lama->lop_nomor_akun ){ $lop_keterangan = $lop_keterangan . ' NOMOR_AKUN: [ old=' . $data_lama->lop_nomor_akun . ';new=' . $request->lop_nomor_akun . ' ] | '; }
      if( $request->lop_nilai_kb !== $data_lama->lop_nilai_kb ){ $lop_keterangan = $lop_keterangan . ' NILAI_KB: [ old=' . $data_lama->lop_nilai_kb . ';new=' . $request->lop_nilai_kb . ' ] | '; }
      if( $request->lop_segmen !== $data_lama->lop_segmen ){ $lop_keterangan = $lop_keterangan . ' SEGMEN: [ old=' . $data_lama->lop_segmen . ';new=' . $request->lop_segmen . ' ] | '; }
      if( $request->lop_skema_bayar !== $data_lama->lop_skema_bayar ){ $lop_keterangan = $lop_keterangan . ' SKEMA_BAYAR: [ old=' . $data_lama->lop_skema_bayar . ';new=' . $request->lop_skema_bayar . ' ] | '; }
      if( $request->lop_status_order !== $data_lama->lop_status_order ){ $lop_keterangan = $lop_keterangan . ' STATUS_ORDER: [ old=' . $data_lama->lop_status_order . ';new=' . $request->lop_status_order . ' ] | '; }

      if( $lop_keterangan === '[' . ucfirst($on_handling) .'] ' ){ $lop_keterangan = '[SISTEM]: USER ' . ucwords($on_handling) .' TIDAK MENGUBAH PRA LOP DETAIL, TOMBOL SIMPAN DITEKAN.'; }

      DB::connection('pgsql')->table('form_pralop')->where('id',str_replace('pralop_detail_','',$request->submit))->update([
        'on_handling' => $on_handling,
        'lop_judul_projek' => $request->lop_judul_projek,
        'lop_nama_plggn' => $request->lop_nama_plggn,
        'lop_alamat_plggn' => $request->lop_alamat_plggn,
        'lop_pic_plggn' => $request->lop_pic_plggn,
        'lop_id_mytens' => $request->lop_id_mytens,
        'lop_nomor_akun' => $request->lop_nomor_akun,
        'lop_nilai_kb' => $request->lop_nilai_kb,
        'lop_segmen' => $request->lop_segmen,
        'lop_skema_bayar' => $request->lop_skema_bayar,
        'lop_status_order' => $request->lop_status_order,
        'lop_tgl_keterangan' => Carbon::now()->translatedFormat('Y-m-d H:i:s'),
        'lop_keterangan' => $lop_keterangan,
        'updated_at' => Carbon::now()->translatedFormat('Y-m-d H:i:s'),
        'updated_by' => Auth::id()
      ]);

      return redirect()->route('witels.pralop.detail',['edit_pralop_id'=>Crypt::encryptString(bin2hex('JANJIJIWA_' . str_replace('pralop_detail_','',$request->submit)))])->with('status','Sukses Simpan PRA LOP Detail.');
    }
  }

  public function layananUpdate(Request $request){
    // dd($request->all());
    $user_in_is = User::leftJoin('user_role','user_role.user_id','=','users.id')
    ->leftJoin('witels','witels.id','=','users.witel_id')
    ->leftJoin('user_mitra','user_mitra.user_id','=','users.id')
    ->leftJoin('mitras','mitras.id','=','user_mitra.mitra_id')
    ->select('users.id','user_role.role_id','users.witel_id','witels.nama_witel','mitras.nama_mitra','mitras.id as mitra_id')->where('users.id',Auth::id())->first();
    $on_handling = '';
    if( $user_in_is->role_id === 4 ){ $on_handling = 'witel'; }
    if( $user_in_is->role_id === 8 || $user_in_is->role_id === 9 ){ $on_handling = 'solution'; }
    if( $user_in_is->role_id === 13 ){ $on_handling = 'legal'; }
    // if( $user_in_is->role_id === 9 ){ $on_handling = 'superadmin'; }

    if( $request->simpan_layanan_id && $request->f1_judul_projek && count($request->f1_judul_projek) > 0 ){
      $nama_folder = '';
      $temp_folder_old_name = '';
      $temp_folder_old_id = '';
      $hari = Carbon::now();
      $hari_ini = $hari->dayOfYear;
      $tahun_ini = $hari->year;
      $tahun_ini = strval($tahun_ini);
      $hari_ini = ($hari_ini*40);
      $skip_folder = null;
      do{
        $string_hari_ini = sprintf("%04d", $hari_ini);
        $nama_folder = $string_hari_ini;
        $cek_nama_folder = DB::connection('pgsql')->table('form_obl')->select('id','f1_folder')
        ->where(DB::raw("to_char(created_at,'yyyy')"),'=',$tahun_ini)
        ->where(DB::raw("NULLIF(regexp_replace(f1_folder, '\D','','g'), '')"),'=',$nama_folder)->first();
        if( $cek_nama_folder ){ $skip_folder = true; $hari_ini++; }
        else{ $skip_folder = false; }
      }while($skip_folder==true);

      $data_lama = $this->updatePraLopHistori($request->simpan_layanan_id);

      $nama_layanan = '';
      $alpabet = 'A';
      $arr_f1_judul_projek = [];
      if( count($request->f1_judul_projek) > 1 ){
        foreach($request->f1_judul_projek as $key => $value){
          array_push($arr_f1_judul_projek,[
              'f1_judul_projek' => $data_lama->lop_judul_projek . ' Layanan ' . $value,
              'f1_id_form_pralop' => $data_lama->id,
              'f1_witel' => $data_lama->lop_witel,
              'f1_nama_plggn' => $data_lama->lop_nama_plggn,
              'f1_alamat_plggn' => $data_lama->lop_alamat_plggn,
              'f1_pic_plggn' => $data_lama->lop_pic_plggn,
              'f1_lop_id_mytens' => $data_lama->lop_id_mytens,
              'f1_nomor_akun' => $data_lama->lop_nomor_akun,
              'f1_nilai_kb' => $data_lama->lop_nilai_kb,
              'f1_segmen' => $data_lama->lop_segmen,
              'f1_skema_bayar' => $data_lama->lop_skema_bayar,
              'f1_status_order' => $data_lama->lop_status_order,
              'created_at' => Carbon::now()->translatedFormat('Y-m-d H:i:s'),
              'created_by' => Auth::id(),
              'updated_at' => Carbon::now()->translatedFormat('Y-m-d H:i:s'),
              'updated_by' => Auth::id(),
              'is_draf' => 8,
              'f1_folder' => $nama_folder . $alpabet
          ] );
          $nama_layanan = $nama_layanan . '  [' . ($key+1) . '] ' . $value;
          $alpabet++;
        }
      }
      if( count($request->f1_judul_projek) === 1 ){
        foreach($request->f1_judul_projek as $key => $value){
          array_push($arr_f1_judul_projek,[
              'f1_judul_projek' => $data_lama->lop_judul_projek . ' Layanan ' . $value,
              'f1_id_form_pralop' => $data_lama->id,
              'f1_witel' => $data_lama->lop_witel,
              'f1_nama_plggn' => $data_lama->lop_nama_plggn,
              'f1_alamat_plggn' => $data_lama->lop_alamat_plggn,
              'f1_pic_plggn' => $data_lama->lop_pic_plggn,
              'f1_lop_id_mytens' => $data_lama->lop_id_mytens,
              'f1_nomor_akun' => $data_lama->lop_nomor_akun,
              'f1_nilai_kb' => $data_lama->lop_nilai_kb,
              'f1_segmen' => $data_lama->lop_segmen,
              'f1_skema_bayar' => $data_lama->lop_skema_bayar,
              'f1_status_order' => $data_lama->lop_status_order,
              'created_at' => Carbon::now()->translatedFormat('Y-m-d H:i:s'),
              'created_by' => Auth::id(),
              'updated_at' => Carbon::now()->translatedFormat('Y-m-d H:i:s'),
              'updated_by' => Auth::id(),
              'is_draf' => 8,
              'f1_folder' => $nama_folder
          ] );
          $nama_layanan = $value;
        }
      }

      DB::connection('pgsql')->table('form_pralop')->where('id',$request->simpan_layanan_id)->update([
        'on_handling' => $on_handling,
        'lop_tgl_keterangan' => Carbon::now()->translatedFormat('Y-m-d H:i:s'),
        'lop_keterangan' => '[SISTEM] TAMBAH LAYANAN: ' . $nama_layanan,
        'updated_at' => Carbon::now()->translatedFormat('Y-m-d H:i:s'),
        'updated_by' => Auth::id()
      ]);

      DB::connection('pgsql')->table('form_obl')->insert( $arr_f1_judul_projek );

      return redirect()->route('witels.pralop.detail',['edit_pralop_id'=>Crypt::encryptString(bin2hex('JANJIJIWA_' . $request->simpan_layanan_id))])->with('status','Sukses Tambah Layanan.');
    }
    else{
      return redirect()->route('witels.pralop.detail',['edit_pralop_id'=>Crypt::encryptString(bin2hex('JANJIJIWA_' . $request->simpan_layanan_id))])->with('status','Oops! Tidak Ada Layanan Ditambah.');
    }
  }

  public function ketdoc(Request $request){
    // dd($request->all());
    if($request->ket_obl_id){
      $edit_pralop_id = str_replace('JANJIJIWA_','',hex2bin(Crypt::decryptString($request->ket_obl_id)));
      try{
        $pralop = DB::connection('pgsql')->table('form_pralop as fp')
        ->leftJoin('users as u','u.id','=','fp.updated_by')
        ->select('fp.*','fp.lop_keterangan as keterangan',DB::raw(" to_char(lop_tgl_keterangan,'DD MON YYYY hh24:mi') as tgl_keterangan"),DB::raw(" (case when lop_tgl_keterangan is null then 0 else TO_CHAR(lop_tgl_keterangan,'yyyymmdd.hh24mi')::NUMERIC end) as sort_tgl"),'u.nama_lengkap as user_update')
        ->where('fp.id',$edit_pralop_id)->first();
        $pralop_histori = DB::connection('pgsql')->table('form_pralop_histori as fp')
        ->leftJoin('users as u','u.id','=','fp.updated_by')
        ->select('fp.*','fp.lop_keterangan as keterangan',DB::raw(" to_char(lop_tgl_keterangan,'DD MON YYYY hh24:mi') as tgl_keterangan"),DB::raw(" (case when lop_tgl_keterangan is null then 0 else TO_CHAR(lop_tgl_keterangan,'yyyymmdd.hh24mi')::NUMERIC end) as sort_tgl"),'u.nama_lengkap as user_update')
        ->where('lop_id_pralop',$edit_pralop_id)->orderBy('updated_at','desc')
        ->orderByRaw("CASE WHEN fp.updated_at IS NULL THEN 0 ELSE 1 END DESC")->orderBy('fp.updated_at','DESC')
        ->get()->toArray();
        $obl = DB::connection('pgsql')->table('form_obl as fo')
        ->leftJoin('users as u','u.id','=','fo.updated_by')
        ->select('fo.f1_keterangan as keterangan',DB::raw(" to_char(fo.f1_tgl_keterangan,'DD MON YYYY hh24:mi') as tgl_keterangan"),DB::raw(" (case when fo.f1_tgl_keterangan is null then 0 else TO_CHAR(fo.f1_tgl_keterangan,'yyyymmdd.hh24mi')::NUMERIC end) as sort_tgl"),'u.nama_lengkap as user_update')
        ->where('fo.f1_id_form_pralop',$edit_pralop_id)
        ->whereRaw(" is_draf <> 7 ")
        ->orderByRaw("CASE WHEN fo.updated_at IS NULL THEN 0 ELSE 1 END DESC")->orderBy('fo.updated_at','DESC')
        ->get()->toArray();
        $obl_histori = DB::connection('pgsql')->table('form_obl_histori as fo')
        ->leftJoin('users as u','u.id','=','fo.updated_by')
        ->select('fo.f1_keterangan as keterangan',DB::raw(" to_char(fo.f1_tgl_keterangan,'DD MON YYYY hh24:mi') as tgl_keterangan"),DB::raw(" (case when fo.f1_tgl_keterangan is null then 0 else TO_CHAR(fo.f1_tgl_keterangan,'yyyymmdd.hh24mi')::NUMERIC end) as sort_tgl"),'u.nama_lengkap as user_update')
        ->where('fo.f1_id_form_pralop',$edit_pralop_id)
        ->whereRaw(" is_draf <> 7 ")
        ->orderByRaw("CASE WHEN fo.updated_at IS NULL THEN 0 ELSE 1 END DESC")->orderBy('fo.updated_at','DESC')
        ->get()->toArray();

        $arr_log_histori = [];
        array_push($arr_log_histori,json_decode(json_encode($pralop), true));
        foreach($pralop_histori as $key => $value){ array_push($arr_log_histori,json_decode(json_encode($value), true)); }
        foreach($obl as $key => $value){ array_push($arr_log_histori,json_decode(json_encode($value), true)); }
        foreach($obl_histori as $key => $value){ array_push($arr_log_histori,json_decode(json_encode($value), true)); }
        usort($arr_log_histori, function ($a, $b) {return $a['sort_tgl'] < $b['sort_tgl'];});

        if( $arr_log_histori ){
          if( count($arr_log_histori) > 0 ){ return response()->json(['status_id'=>'1','status'=>'Success','arr_log_histori'=>$arr_log_histori]); }
          else{ return response()->json(['status_id'=>'2','status'=>'Tidak Ada Data Keterangan PRA LOP.']); }
        }
        else{
            return response()->json(['status_id'=>'2','status'=>'Tidak Ada Data Keterangan PRA LOP.']);
        }
      }
      catch(Throwable $e){ return response()->json(['status_id'=>'3','status'=>'Oops! Gagal Mengambil Data Keterangan PRA LOP.']); }
    }
    else{ return response()->json(['status_id'=>'4','status'=>'Oops! Wrong Routing.']); }
  }


  public function langkah(Request $request){
    $proses = '';
    $on_handling = '';
    $pralop_id = '';
    $lop_count_revisi = 0;
    if($request->submit_verifikasi){
      $proses = 'Lanjut Verifikasi Solution';
      $on_handling = 'solution';
      $pralop_id = str_replace('JANJIJIWA_','',hex2bin(Crypt::decryptString($request->submit_verifikasi)));
    }
    if($request->submit_witel){
      $proses = 'Kembali Ke Witel';
      $lop_count_revisi = 1;
      $on_handling = 'witel';
      $pralop_id = str_replace('JANJIJIWA_','',hex2bin(Crypt::decryptString($request->submit_witel)));
    }
    if($request->submit_legal){
      $proses = 'Lanjut Ke Legal';
      $on_handling = 'legal';
      $pralop_id = str_replace('JANJIJIWA_','',hex2bin(Crypt::decryptString($request->submit_legal)));
    }
    if($request->submit_solution){
      $proses = 'Kembali Ke Solution';
      $on_handling = 'solution';
      $pralop_id = str_replace('JANJIJIWA_','',hex2bin(Crypt::decryptString($request->submit_solution)));
    }
    if($request->submit_final){
      $proses = 'Final PRA LOP';
      $on_handling = 'final_pralop';
      $pralop_id = str_replace('JANJIJIWA_','',hex2bin(Crypt::decryptString($request->submit_final)));
    }

    $data_lama = $this->updatePraLopHistori($pralop_id);
    if( $request->submit_final ){
      DB::connection('pgsql')->table('form_pralop')->where('id',$pralop_id)->update([
        'on_handling' => $on_handling,
        'lop_tgl_keterangan' => Carbon::now()->translatedFormat('Y-m-d H:i:s'),
        'lop_keterangan' => 'PRA LOP PROSES : ' . $proses,
        'lop_count_revisi' => ($data_lama->lop_count_revisi + $lop_count_revisi),
        'updated_at' => Carbon::now()->translatedFormat('Y-m-d H:i:s'),
        'updated_by' => Auth::id(),
        'lop_review_kb' => true
      ]);
    }
    else{
      DB::connection('pgsql')->table('form_pralop')->where('id',$pralop_id)->update([
        'on_handling' => $on_handling,
        'lop_tgl_keterangan' => Carbon::now()->translatedFormat('Y-m-d H:i:s'),
        'lop_keterangan' => 'PRA LOP PROSES : ' . $proses,
        'lop_count_revisi' => ($data_lama->lop_count_revisi + $lop_count_revisi),
        'updated_at' => Carbon::now()->translatedFormat('Y-m-d H:i:s'),
        'updated_by' => Auth::id(),
        'lop_review_kb' => false
      ]);
    }

    if($request->submit_final){
      $data_lama_obl = $this->updatePraLopToObl($pralop_id);
      DB::connection('pgsql')->table('form_obl')->where('f1_id_form_pralop',$pralop_id)->update([
        'is_draf' => 7,
        'revisi_witel' => false,
        'revisi_witel_count' => 0,
        'submit' => 'solution_edit',
        'f1_proses' => 'witel',
        'f1_tgl_keterangan' => Carbon::now()->translatedFormat('Y-m-d H:i:s'),
        'f1_keterangan' => 'FINAL PRA LOP: ' . $data_lama->lop_judul_projek,
        'updated_at' => Carbon::now()->translatedFormat('Y-m-d H:i:s'),
        'updated_by' => Auth::id()
      ]);
    }

    return $this->index($request);
  }

  public function generateDocP0($var_obl_id){
    $docs = DB::connection('pgsql')->table('form_obl')->leftJoin('mitras','mitras.id','=','f1_mitra_id')
    ->select(
      'form_obl.id',
      'f1_nama_plggn',
      'f1_judul_projek',
      'p0_nomor_p0',
      'p0_pemeriksa',
      'f1_witel',
      DB::raw("to_char(p0_tgl_submit,'DD Mon YYYY') as tgl_submit"),
      DB::raw("
      case
      when f1_skema_bayar = 'otc' then 'One Time Charge (OTC)'
      when f1_skema_bayar = 'recurring' then 'Recurring'
      when f1_skema_bayar = 'termin' then 'Termin'
      when f1_skema_bayar = 'otc_recurring' then 'OTC Recurring'
      else ''
      end as skema_bayar
      "),
      DB::raw(" date_part('month', age(p1_tgl_kontrak_akhir ,p1_tgl_kontrak_mulai) ) as periode_bulan"),
      'p1_estimasi_harga',
      'f1_nilai_kb',
      'f1_mitra_id',
      'mitras.nama_mitra',
      'p0_nik_am',
      'p0_nik_manager',
      'p0_nik_gm',
      'f1_segmen',
      'f1_folder',
      'created_at'
    )
    ->where('form_obl.id',$var_obl_id)->first();
    $docs_year = new Carbon($docs->created_at);
    $docs_year = $docs_year->translatedFormat('Y');
    $templateProcessor = new TemplateProcessor(public_path() . '/basic_documents/basic_p0_doc.docx');
    $templateProcessor->setValues([
        'f1_nama_plggn' => $docs->f1_nama_plggn,
        'f1_judul_projek' => $docs->f1_judul_projek,
        'p0_nomor_p0' => $docs->p0_nomor_p0,
        'p0_pemeriksa' => strtoupper(((string)strtok($docs->p0_pemeriksa,'_'))),
        'f1_witel' =>  ucfirst((strtolower($docs->f1_witel))),
        'p0_tgl_submit' => $docs->tgl_submit,
        'f1_skema_bayar' => $docs->skema_bayar,
        'p1_estimasi_harga' => $docs->p1_estimasi_harga,
        'string_p1_estimasi_harga' => RupiahFormat::terbilang( (int)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,',')))) ),
        'periode_bulan' => $docs->periode_bulan,
        'f1_mitra_id' => $docs->nama_mitra,
        'revenue' =>   RupiahFormat::currency( (int)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,','))))  * 0.1 ),
        'harga_ke_mitra' => RupiahFormat::currency( ( (float)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,',')))) - ( (int)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,','))))  * 0.1 ) ) ),
        'p0_nik_am' => $docs->p0_nik_am,
        'p0_nik_manager' => $docs->p0_nik_manager,
        'p0_nik_gm' => $docs->p0_nik_gm,
        'f1_segmen' => $docs->f1_segmen,
        'f1_folder' => $docs->f1_folder
    ]);
    $filename = Auth::id() . '_' . (string) Str::uuid();
    $file_path = public_path().'/temp_saved_docs';
    $templateProcessor->saveAs($file_path.'/'.$filename.'.docx');
    $headers = array(
        'Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    );
    return response()->download( $file_path . '/'.$filename.'.docx', $docs->f1_segmen . '_' . $docs->f1_folder . '_'. $docs_year . '_Form_P0.docx', $headers)->deleteFileAfterSend(true);
  }

  public function generateDocP1($var_obl_id){
    $docs = DB::connection('pgsql')->table('form_obl')->leftJoin('mitras','mitras.id','=','f1_mitra_id')
    ->select(
      'form_obl.id',
      'f1_nama_plggn',
      'f1_judul_projek',
      'p1_nomor_p1',
      'p1_pemeriksa',
      'f1_witel',
      'p1_tgl_delivery',
      'p1_tgl_p1',
      DB::raw("
      case
      when p1_skema_bayar = 'otc' then 'One Time Charge (OTC)'
      when p1_skema_bayar = 'recurring' then 'Recurring'
      when p1_skema_bayar = 'termin' then 'Termin'
      when p1_skema_bayar = 'otc_recurring' then 'OTC Recurring'
      else ''
      end as skema_bayar
      "),
      DB::raw("
      case
      when p1_skema_bisnis = 'sewa_murni' then 'Sewa Murni'
      when p1_skema_bisnis = 'sewa_beli' then 'Sewa Beli'
      when p1_skema_bisnis = 'beli_putus' then 'Pengadaan Beli Putus'
      else ''
      end as skema_bisnis
      "),
      DB::raw("
      case
      when p1_mekanisme_bayar = 'back_to_back' then 'Back To Back'
      when p1_mekanisme_bayar = 'non_back_to_back' then 'Non Back To Back'
      else ''
      end as mekanisme_bayar
      "),
      DB::raw(" date_part('month', age(p1_tgl_kontrak_akhir ,p1_tgl_kontrak_mulai) ) as periode_bulan"),
      'p1_estimasi_harga',
      'f1_nilai_kb',
      'f1_mitra_id',
      'mitras.nama_mitra',
      'p1_dibuat_am',
      'p1_diperiksa_manager',
      'p1_disetujui_gm',
      'p1_lokasi_instal',
      'p1_tgl_doc_plggn',
      'f1_segmen',
      'f1_folder',
      'created_at',
      'p1_paragraf'
    )
    ->where('form_obl.id',$var_obl_id)->first();
    $docs_year = new Carbon($docs->created_at);
    $docs_year = $docs_year->translatedFormat('Y');
    $p1_tgl_p1 = new Carbon($docs->p1_tgl_p1);
    $p1_tgl_p1 = $p1_tgl_p1->translatedFormat('d F Y');
    $p1_tgl_delivery = new Carbon($docs->p1_tgl_delivery);
    $p1_tgl_delivery = $p1_tgl_delivery->translatedFormat('d F Y');
    $p1_tgl_doc_plggn = new Carbon($docs->p1_tgl_doc_plggn);
    $p1_tgl_doc_plggn = $p1_tgl_doc_plggn->translatedFormat('d F Y');

    $templateProcessor = new TemplateProcessor(public_path() . '/basic_documents/basic_p1_doc.docx');
    $templateProcessor->setValues([
        'p1_nomor_p1' => $docs->p1_nomor_p1,
        'p1_pemeriksa' => strtoupper(((string)strtok($docs->p1_pemeriksa,'_'))),
        'f1_witel' =>  ucfirst((strtolower($docs->f1_witel))),
        'p1_tgl_p1' => $p1_tgl_p1,
        'p1_tgl_delivery' => $p1_tgl_delivery,
        'p1_tgl_doc_plggn' => $p1_tgl_doc_plggn,
        'p1_lokasi_instal' => $docs->p1_lokasi_instal,
        'p1_skema_bayar' => $docs->skema_bayar,
        'p1_skema_bisnis' => $docs->skema_bisnis,
        'p1_mekanisme_bayar' => $docs->mekanisme_bayar,
        'p1_estimasi_harga' => $docs->p1_estimasi_harga,
        'string_p1_estimasi_harga' => RupiahFormat::terbilang( (int)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,',')))) ),
        'revenue' =>   RupiahFormat::currency( (int)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,','))))  * 0.1 ),
        'harga_ke_mitra' => RupiahFormat::currency( ( (float)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,',')))) - ( (int)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,','))))  * 0.1 ) ) ),
        'f1_nama_plggn' => $docs->f1_nama_plggn,
        'f1_judul_projek' => $docs->f1_judul_projek,
        'periode_bulan' => $docs->periode_bulan,
        'f1_mitra_id' => $docs->nama_mitra,
        'p1_dibuat_am' => $docs->p1_dibuat_am,
        'p1_diperiksa_manager' => $docs->p1_diperiksa_manager,
        'p1_disetujui_gm' => $docs->p1_disetujui_gm,
        'p1_paragraf' => $docs->p1_paragraf
    ]);
    $filename = Auth::id() . '_' . (string) Str::uuid();
    $file_path = public_path().'/temp_saved_docs';
    $templateProcessor->saveAs($file_path.'/'.$filename.'.docx');
    $headers = array(
        'Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    );
    return response()->download( $file_path . '/'.$filename.'.docx', $docs->f1_segmen . '_' . $docs->f1_folder . '_'. $docs_year . '_Form_P1.docx', $headers)->deleteFileAfterSend(true);
  }

  public function layananPrint(Request $request){
    if( $request->file_print ){
      if( str_contains($request->file_print,'p1_') ){ return $this->generateDocP1(str_replace('p1_','',$request->file_print)); }
      if( str_contains($request->file_print,'p0_') ){ return $this->generateDocP0(str_replace('p0_','',$request->file_print)); }
    }
    else{ return redirect()->route('witels.pralop.detail',['edit_pralop_id'=>$request->encrypted[0]])->with('status','Oops! Gagal Print'); }
  }


  public function generateUniqueId(){
    $hasil = '';
    $is_skip = null;
    do{
        $hasil = Str::uuid()->toString();
        $temp_id = $hasil . '.pdf';
        $cek_uuid_db1 = DocObl::select('id')
        ->whereRaw("
        file_p0 = '$temp_id' or
        file_p1 = '$temp_id' or
        file_p2 = '$temp_id' or
        file_p3 = '$temp_id' or
        file_p4 = '$temp_id' or
        file_p5 = '$temp_id' or
        file_p6 = '$temp_id' or
        file_p7 = '$temp_id' or
        file_p8 = '$temp_id' or
        file_sp = '$temp_id' or
        file_wo = '$temp_id' or
        file_kl = '$temp_id'
        ")
        ->get()->toArray();

        $cek_uuid_db2 = DocOblHistori::select('id')
        ->whereRaw("
        file_p0 = '$temp_id' or
        file_p1 = '$temp_id' or
        file_p2 = '$temp_id' or
        file_p3 = '$temp_id' or
        file_p4 = '$temp_id' or
        file_p5 = '$temp_id' or
        file_p6 = '$temp_id' or
        file_p7 = '$temp_id' or
        file_p8 = '$temp_id' or
        file_sp = '$temp_id' or
        file_wo = '$temp_id' or
        file_kl = '$temp_id'
        ")
        ->get()->toArray();
        if( ($cek_uuid_db1 && count($cek_uuid_db1)>0) || ($cek_uuid_db2 && count($cek_uuid_db2)>0) ){ $is_skip = true; }
        else{ $is_skip = false; }
    }while($is_skip==true);
    return $hasil;
  }


  public function updatePraLopToObl($var_pralop_id){
    $data_lama = DB::connection('pgsql')->table('form_obl')
    ->where('f1_id_form_pralop',$var_pralop_id)
    ->get()->toArray();
    $arr_ids = [];
    foreach( $data_lama as $key => $value ){
      array_push($arr_ids,$value->id);
      DB::connection('pgsql')->table('form_obl_histori')
      ->insert([
        'obl_id' => $value->id,
        'submit' => $value->submit,
        'revisi_witel' => $value->revisi_witel,
        'revisi_witel_count' => $value->revisi_witel_count,
        'is_draf' => $value->is_draf,
        'updated_at' => $value->updated_at,
        'updated_by' => $value->updated_by,
        'p0_nomor_p0' => $value->p0_nomor_p0,
        'p0_nik_am' => $value->p0_nik_am,
        'p0_nik_manager' => $value->p0_nik_manager,
        'p0_tgl_submit' => $value->p0_tgl_submit,
        'p0_pemeriksa' => $value->p0_pemeriksa,
        'p0_nik_gm' => $value->p0_nik_gm,
        'p1_nomor_p1' => $value->p1_nomor_p1,
        'p1_tgl_p1' => $value->p1_tgl_p1,
        'p1_pemeriksa' => $value->p1_pemeriksa,
        'p1_tgl_delivery' => $value->p1_tgl_delivery,
        'p1_lokasi_instal' => $value->p1_lokasi_instal,
        'p1_skema_bisnis' => $value->p1_skema_bisnis,
        'p1_skema_bayar' => $value->p1_skema_bayar,
        'p1_mekanisme_bayar' => $value->p1_mekanisme_bayar,
        'p1_tgl_kontrak_mulai' => $value->p1_tgl_kontrak_mulai,
        'p1_tgl_kontrak_akhir' => $value->p1_tgl_kontrak_akhir,
        'p1_tgl_doc_plggn' => $value->p1_tgl_doc_plggn,
        'p1_estimasi_harga' => $value->p1_estimasi_harga,
        'p1_disetujui_gm' => $value->p1_disetujui_gm,
        'p1_dibuat_am' => $value->p1_dibuat_am,
        'p1_diperiksa_manager' => $value->p1_diperiksa_manager,
        'f1_nama_plggn' => $value->f1_nama_plggn,
        'f1_alamat_plggn' => $value->f1_alamat_plggn,
        'f1_witel' => $value->f1_witel,
        'f1_judul_projek' => $value->f1_judul_projek,
        'f1_segmen' => $value->f1_segmen,
        'f1_proses' => $value->f1_proses,
        'f1_folder' => $value->f1_folder,
        'f1_nilai_kb' => $value->f1_nilai_kb,
        'f1_no_kfs_spk' => $value->f1_no_kfs_spk,
        'f1_quote_kontrak' => $value->f1_quote_kontrak,
        'f1_nomor_akun' => $value->f1_nomor_akun,
        'f1_jenis_kontrak' => $value->f1_jenis_kontrak,
        'f1_skema_bayar' => $value->f1_skema_bayar,
        'f1_status_order' => $value->f1_status_order,
        'f1_status_sm' => $value->f1_status_sm,
        'f1_tgl_keterangan' => $value->f1_tgl_keterangan,
        'f1_keterangan' => $value->f1_keterangan,
        'f1_mitra_id' => $value->f1_mitra_id,
        'f1_pic_mitra' => $value->f1_pic_mitra,
        'f1_jenis_spk' => $value->f1_jenis_spk,
        'f1_masa_layanan_tahun' => $value->f1_masa_layanan_tahun,
        'f1_masa_layanan_bulan' => $value->f1_masa_layanan_bulan,
        'f1_masa_layanan_hari' => $value->f1_masa_layanan_hari,
        'f1_pic_plggn' => $value->f1_pic_plggn,
        'f2_nilai_kontrak' => $value->f2_nilai_kontrak,
        'f2_tgl_p1' => $value->f2_tgl_p1,
        'p2_tgl_p2' => $value->p2_tgl_p2,
        'p2_tgl_justifikasi' => $value->p2_tgl_justifikasi,
        'p2_dievaluasi_oleh' => $value->p2_dievaluasi_oleh,
        'p2_disetujui_oleh' => $value->p2_disetujui_oleh,
        'p2_pilihan_catatan' => $value->p2_pilihan_catatan,
        'p2_catatan' => $value->p2_catatan,
        'p3_tgl_p3' => $value->p3_tgl_p3,
        'p3_takah_p3' => $value->p3_takah_p3,
        'p3_pejabat_mitra_nama' => $value->p3_pejabat_mitra_nama,
        'p3_pejabat_mitra_alamat' => $value->p3_pejabat_mitra_alamat,
        'p3_pejabat_mitra_telepon' => $value->p3_pejabat_mitra_telepon,
        'p3_status_rapat_pengadaan' => $value->p3_status_rapat_pengadaan,
        'p3_tgl_rapat_pengadaan' => $value->p3_tgl_rapat_pengadaan,
        'p3_tmpt_rapat_pengadaan' => $value->p3_tmpt_rapat_pengadaan,
        'p3_tgl_terima_sp' => $value->p3_tgl_terima_sp,
        'p3_alamat_terima_sp' => $value->p3_alamat_terima_sp,
        'p3_manager_obl' => $value->p3_manager_obl,
        'p4_tgl_p4' => $value->p4_tgl_p4,
        'p4_waktu_layanan' => $value->p4_waktu_layanan,
        'p4_skema_bisnis' => $value->p4_skema_bisnis,
        'p4_mekanisme_pembayaran' => $value->p4_mekanisme_pembayaran,
        'p4_slg' => $value->p4_slg,
        'p4_fasilitator' => $value->p4_fasilitator,
        'p4_pengesahan' => $value->p4_pengesahan,
        'p5_tgl_p5' => $value->p5_tgl_p5,
        'p5_harga_penawaran' => $value->p5_harga_penawaran,
        'p5_ttd_evaluator' => $value->p5_ttd_evaluator,
        'p6_tgl_p6' => $value->p6_tgl_p6,
        'p6_ttd_bast_telkom' => $value->p6_ttd_bast_telkom,
        'p6_ttd_bast_mitra' => $value->p6_ttd_bast_mitra,
        'p6_harga_negosiasi' => $value->p6_harga_negosiasi,
        'p6_nama_peserta_mitra' => $value->p6_nama_peserta_mitra,
        'p6_jabatan_peserta_mitra' => $value->p6_jabatan_peserta_mitra,
        'p6_peserta_rapat_telkom' => $value->p6_peserta_rapat_telkom,
        'p6_pengesahan' => $value->p6_pengesahan,
        'p7_tgl_p7' => $value->p7_tgl_p7,
        'p7_takah_p7' => $value->p7_takah_p7,
        'p7_lampiran_berkas' => $value->p7_lampiran_berkas,
        'p7_harga_pekerjaan' => $value->p7_harga_pekerjaan,
        'p7_skema_bayar' => $value->p7_skema_bayar,
        'p7_pemeriksa' => $value->p7_pemeriksa,
        'p7_tembusan' => $value->p7_tembusan,
        'sp_tgl_sp' => $value->sp_tgl_sp,
        'sp_takah_sp' => $value->sp_takah_sp,
        'sp_nomor_kb' => $value->sp_nomor_kb,
        'p8_tgl_p8' => $value->p8_tgl_p8,
        'p8_takah_p8' => $value->p8_takah_p8,
        'wo_tgl_wo' => $value->wo_tgl_wo,
        'wo_takah_wo' => $value->wo_takah_wo,
        'wo_tgl_fo' => $value->wo_tgl_fo,
        'wo_nomor_kb' => $value->wo_nomor_kb,
        'wo_jenis_layanan' => $value->wo_jenis_layanan,
        'wo_jumlah_layanan' => $value->wo_jumlah_layanan,
        'wo_harga_ke_plggn' => $value->wo_harga_ke_plggn,
        'wo_onetime_charge_plggn' => $value->wo_onetime_charge_plggn,
        'wo_monthly_plggn' => $value->wo_monthly_plggn,
        'wo_onetime_charge_telkom' => $value->wo_onetime_charge_telkom,
        'wo_persen_telkom' => $value->wo_persen_telkom,
        'wo_monthly_telkom' => $value->wo_monthly_telkom,
        'wo_onetime_charge_mitra' => $value->wo_onetime_charge_mitra,
        'wo_persen_mitra' => $value->wo_persen_mitra,
        'wo_monthly_mitra' => $value->wo_monthly_mitra,
        'kl_tgl_kl' => $value->kl_tgl_kl,
        'kl_takah_kl' => $value->kl_takah_kl,
        'kl_nomor_kb' => $value->kl_nomor_kb,
        'kl_no_kl_mitra' => $value->kl_no_kl_mitra,
        'kl_tempat_ttd_kl' => $value->kl_tempat_ttd_kl,
        'kl_notaris' => $value->kl_notaris,
        'kl_akta_notaris' => $value->kl_akta_notaris,
        'kl_tgl_akta_notaris' => $value->kl_tgl_akta_notaris,
        'kl_nama_pejabat_telkom' => $value->kl_nama_pejabat_telkom,
        'kl_jabatan_pejabat_telkom' => $value->kl_jabatan_pejabat_telkom,
        'kl_npwp_mitra' => $value->kl_npwp_mitra,
        'kl_no_anggaran_mitra' => $value->kl_no_anggaran_mitra,
        'kl_tgl_anggaran_mitra' => $value->kl_tgl_anggaran_mitra,
        'kl_nama_pejabat_mitra' => $value->kl_nama_pejabat_mitra,
        'kl_jabatan_pejabat_mitra' => $value->kl_jabatan_pejabat_mitra,
        'kl_no_skm' => $value->kl_no_skm,
        'kl_tgl_skm' => $value->kl_tgl_skm,
        'kl_perihal_skm' => $value->kl_perihal_skm,
        'kl_tgl_akhir_kl' => $value->kl_tgl_akhir_kl,
        'kl_bayar_dp' => $value->kl_bayar_dp,
        'kl_nama_bank_mitra' => $value->kl_nama_bank_mitra,
        'kl_cabang_bank_mitra' => $value->kl_cabang_bank_mitra,
        'kl_rek_bank_mitra' => $value->kl_rek_bank_mitra,
        'kl_an_bank_mitra' => $value->kl_an_bank_mitra,
        'file_p0' => $value->file_p0,
        'file_p1' => $value->file_p1,
        'file_p2' => $value->file_p2,
        'file_p3' => $value->file_p3,
        'file_p4' => $value->file_p4,
        'file_p5' => $value->file_p5,
        'file_p6' => $value->file_p6,
        'file_p7' => $value->file_p7,
        'file_p8' => $value->file_p8,
        'file_sp' => $value->file_sp,
        'file_wo' => $value->file_wo,
        'file_kl' => $value->file_kl,
        'p1_paragraf' => $value->p1_paragraf,
        'p0_paragraf' => $value->p0_paragraf
      ]);
    }

    return $arr_ids;
  }

  public function updateOblHistori($var_obl_id){
    $data_lama = DB::connection('pgsql')->table('form_obl')
    ->where('id',$var_obl_id)
    ->first();
    DB::connection('pgsql')->table('form_obl_histori')
    ->insert([
      'obl_id' => $data_lama->id,
      'submit' => $data_lama->submit,
      'revisi_witel' => $data_lama->revisi_witel,
      'revisi_witel_count' => $data_lama->revisi_witel_count,
      'is_draf' => $data_lama->is_draf,
      'updated_at' => $data_lama->updated_at,
      'updated_by' => $data_lama->updated_by,
      'p0_nomor_p0' => $data_lama->p0_nomor_p0,
      'p0_nik_am' => $data_lama->p0_nik_am,
      'p0_nik_manager' => $data_lama->p0_nik_manager,
      'p0_tgl_submit' => $data_lama->p0_tgl_submit,
      'p0_pemeriksa' => $data_lama->p0_pemeriksa,
      'p0_nik_gm' => $data_lama->p0_nik_gm,
      'p1_nomor_p1' => $data_lama->p1_nomor_p1,
      'p1_tgl_p1' => $data_lama->p1_tgl_p1,
      'p1_pemeriksa' => $data_lama->p1_pemeriksa,
      'p1_tgl_delivery' => $data_lama->p1_tgl_delivery,
      'p1_lokasi_instal' => $data_lama->p1_lokasi_instal,
      'p1_skema_bisnis' => $data_lama->p1_skema_bisnis,
      'p1_skema_bayar' => $data_lama->p1_skema_bayar,
      'p1_mekanisme_bayar' => $data_lama->p1_mekanisme_bayar,
      'p1_tgl_kontrak_mulai' => $data_lama->p1_tgl_kontrak_mulai,
      'p1_tgl_kontrak_akhir' => $data_lama->p1_tgl_kontrak_akhir,
      'p1_tgl_doc_plggn' => $data_lama->p1_tgl_doc_plggn,
      'p1_estimasi_harga' => $data_lama->p1_estimasi_harga,
      'p1_disetujui_gm' => $data_lama->p1_disetujui_gm,
      'p1_dibuat_am' => $data_lama->p1_dibuat_am,
      'p1_diperiksa_manager' => $data_lama->p1_diperiksa_manager,
      'f1_nama_plggn' => $data_lama->f1_nama_plggn,
      'f1_alamat_plggn' => $data_lama->f1_alamat_plggn,
      'f1_witel' => $data_lama->f1_witel,
      'f1_judul_projek' => $data_lama->f1_judul_projek,
      'f1_segmen' => $data_lama->f1_segmen,
      'f1_proses' => $data_lama->f1_proses,
      'f1_folder' => $data_lama->f1_folder,
      'f1_nilai_kb' => $data_lama->f1_nilai_kb,
      'f1_no_kfs_spk' => $data_lama->f1_no_kfs_spk,
      'f1_quote_kontrak' => $data_lama->f1_quote_kontrak,
      'f1_nomor_akun' => $data_lama->f1_nomor_akun,
      'f1_jenis_kontrak' => $data_lama->f1_jenis_kontrak,
      'f1_skema_bayar' => $data_lama->f1_skema_bayar,
      'f1_status_order' => $data_lama->f1_status_order,
      'f1_status_sm' => $data_lama->f1_status_sm,
      'f1_tgl_keterangan' => $data_lama->f1_tgl_keterangan,
      'f1_keterangan' => $data_lama->f1_keterangan,
      'f1_mitra_id' => $data_lama->f1_mitra_id,
      'f1_pic_mitra' => $data_lama->f1_pic_mitra,
      'f1_jenis_spk' => $data_lama->f1_jenis_spk,
      'f1_masa_layanan_tahun' => $data_lama->f1_masa_layanan_tahun,
      'f1_masa_layanan_bulan' => $data_lama->f1_masa_layanan_bulan,
      'f1_masa_layanan_hari' => $data_lama->f1_masa_layanan_hari,
      'f1_pic_plggn' => $data_lama->f1_pic_plggn,
      'f2_nilai_kontrak' => $data_lama->f2_nilai_kontrak,
      'f2_tgl_p1' => $data_lama->f2_tgl_p1,
      'p2_tgl_p2' => $data_lama->p2_tgl_p2,
      'p2_tgl_justifikasi' => $data_lama->p2_tgl_justifikasi,
      'p2_dievaluasi_oleh' => $data_lama->p2_dievaluasi_oleh,
      'p2_disetujui_oleh' => $data_lama->p2_disetujui_oleh,
      'p2_pilihan_catatan' => $data_lama->p2_pilihan_catatan,
      'p2_catatan' => $data_lama->p2_catatan,
      'p3_tgl_p3' => $data_lama->p3_tgl_p3,
      'p3_takah_p3' => $data_lama->p3_takah_p3,
      'p3_pejabat_mitra_nama' => $data_lama->p3_pejabat_mitra_nama,
      'p3_pejabat_mitra_alamat' => $data_lama->p3_pejabat_mitra_alamat,
      'p3_pejabat_mitra_telepon' => $data_lama->p3_pejabat_mitra_telepon,
      'p3_status_rapat_pengadaan' => $data_lama->p3_status_rapat_pengadaan,
      'p3_tgl_rapat_pengadaan' => $data_lama->p3_tgl_rapat_pengadaan,
      'p3_tmpt_rapat_pengadaan' => $data_lama->p3_tmpt_rapat_pengadaan,
      'p3_tgl_terima_sp' => $data_lama->p3_tgl_terima_sp,
      'p3_alamat_terima_sp' => $data_lama->p3_alamat_terima_sp,
      'p3_manager_obl' => $data_lama->p3_manager_obl,
      'p4_tgl_p4' => $data_lama->p4_tgl_p4,
      'p4_waktu_layanan' => $data_lama->p4_waktu_layanan,
      'p4_skema_bisnis' => $data_lama->p4_skema_bisnis,
      'p4_mekanisme_pembayaran' => $data_lama->p4_mekanisme_pembayaran,
      'p4_slg' => $data_lama->p4_slg,
      'p4_fasilitator' => $data_lama->p4_fasilitator,
      'p4_pengesahan' => $data_lama->p4_pengesahan,
      'p5_tgl_p5' => $data_lama->p5_tgl_p5,
      'p5_harga_penawaran' => $data_lama->p5_harga_penawaran,
      'p5_ttd_evaluator' => $data_lama->p5_ttd_evaluator,
      'p6_tgl_p6' => $data_lama->p6_tgl_p6,
      'p6_ttd_bast_telkom' => $data_lama->p6_ttd_bast_telkom,
      'p6_ttd_bast_mitra' => $data_lama->p6_ttd_bast_mitra,
      'p6_harga_negosiasi' => $data_lama->p6_harga_negosiasi,
      'p6_nama_peserta_mitra' => $data_lama->p6_nama_peserta_mitra,
      'p6_jabatan_peserta_mitra' => $data_lama->p6_jabatan_peserta_mitra,
      'p6_peserta_rapat_telkom' => $data_lama->p6_peserta_rapat_telkom,
      'p6_pengesahan' => $data_lama->p6_pengesahan,
      'p7_tgl_p7' => $data_lama->p7_tgl_p7,
      'p7_takah_p7' => $data_lama->p7_takah_p7,
      'p7_lampiran_berkas' => $data_lama->p7_lampiran_berkas,
      'p7_harga_pekerjaan' => $data_lama->p7_harga_pekerjaan,
      'p7_skema_bayar' => $data_lama->p7_skema_bayar,
      'p7_pemeriksa' => $data_lama->p7_pemeriksa,
      'p7_tembusan' => $data_lama->p7_tembusan,
      'sp_tgl_sp' => $data_lama->sp_tgl_sp,
      'sp_takah_sp' => $data_lama->sp_takah_sp,
      'sp_nomor_kb' => $data_lama->sp_nomor_kb,
      'p8_tgl_p8' => $data_lama->p8_tgl_p8,
      'p8_takah_p8' => $data_lama->p8_takah_p8,
      'wo_tgl_wo' => $data_lama->wo_tgl_wo,
      'wo_takah_wo' => $data_lama->wo_takah_wo,
      'wo_tgl_fo' => $data_lama->wo_tgl_fo,
      'wo_nomor_kb' => $data_lama->wo_nomor_kb,
      'wo_jenis_layanan' => $data_lama->wo_jenis_layanan,
      'wo_jumlah_layanan' => $data_lama->wo_jumlah_layanan,
      'wo_harga_ke_plggn' => $data_lama->wo_harga_ke_plggn,
      'wo_onetime_charge_plggn' => $data_lama->wo_onetime_charge_plggn,
      'wo_monthly_plggn' => $data_lama->wo_monthly_plggn,
      'wo_onetime_charge_telkom' => $data_lama->wo_onetime_charge_telkom,
      'wo_persen_telkom' => $data_lama->wo_persen_telkom,
      'wo_monthly_telkom' => $data_lama->wo_monthly_telkom,
      'wo_onetime_charge_mitra' => $data_lama->wo_onetime_charge_mitra,
      'wo_persen_mitra' => $data_lama->wo_persen_mitra,
      'wo_monthly_mitra' => $data_lama->wo_monthly_mitra,
      'kl_tgl_kl' => $data_lama->kl_tgl_kl,
      'kl_takah_kl' => $data_lama->kl_takah_kl,
      'kl_nomor_kb' => $data_lama->kl_nomor_kb,
      'kl_no_kl_mitra' => $data_lama->kl_no_kl_mitra,
      'kl_tempat_ttd_kl' => $data_lama->kl_tempat_ttd_kl,
      'kl_notaris' => $data_lama->kl_notaris,
      'kl_akta_notaris' => $data_lama->kl_akta_notaris,
      'kl_tgl_akta_notaris' => $data_lama->kl_tgl_akta_notaris,
      'kl_nama_pejabat_telkom' => $data_lama->kl_nama_pejabat_telkom,
      'kl_jabatan_pejabat_telkom' => $data_lama->kl_jabatan_pejabat_telkom,
      'kl_npwp_mitra' => $data_lama->kl_npwp_mitra,
      'kl_no_anggaran_mitra' => $data_lama->kl_no_anggaran_mitra,
      'kl_tgl_anggaran_mitra' => $data_lama->kl_tgl_anggaran_mitra,
      'kl_nama_pejabat_mitra' => $data_lama->kl_nama_pejabat_mitra,
      'kl_jabatan_pejabat_mitra' => $data_lama->kl_jabatan_pejabat_mitra,
      'kl_no_skm' => $data_lama->kl_no_skm,
      'kl_tgl_skm' => $data_lama->kl_tgl_skm,
      'kl_perihal_skm' => $data_lama->kl_perihal_skm,
      'kl_tgl_akhir_kl' => $data_lama->kl_tgl_akhir_kl,
      'kl_bayar_dp' => $data_lama->kl_bayar_dp,
      'kl_nama_bank_mitra' => $data_lama->kl_nama_bank_mitra,
      'kl_cabang_bank_mitra' => $data_lama->kl_cabang_bank_mitra,
      'kl_rek_bank_mitra' => $data_lama->kl_rek_bank_mitra,
      'kl_an_bank_mitra' => $data_lama->kl_an_bank_mitra,
      'file_p0' => $data_lama->file_p0,
      'file_p1' => $data_lama->file_p1,
      'file_p2' => $data_lama->file_p2,
      'file_p3' => $data_lama->file_p3,
      'file_p4' => $data_lama->file_p4,
      'file_p5' => $data_lama->file_p5,
      'file_p6' => $data_lama->file_p6,
      'file_p7' => $data_lama->file_p7,
      'file_p8' => $data_lama->file_p8,
      'file_sp' => $data_lama->file_sp,
      'file_wo' => $data_lama->file_wo,
      'file_kl' => $data_lama->file_kl,
      'p1_paragraf' => $data_lama->p1_paragraf,
      'p0_paragraf' => $data_lama->p0_paragraf
    ]);
    return $data_lama;
  }

  public function layananUpload(Request $request){

    if(  $request->file_upload  && $request->hasFile('file_'.$request->file_upload) === false ){
        return redirect()->route('witels.pralop.detail',['edit_pralop_id'=>$request->encrypted[0]])->with('status','Oops! Gagal File Upload');
    }
    else if(  $request->file_upload  && $request->hasFile('file_'.$request->file_upload) === true ){
      $tipe_doc_1 = 'pdf';
      $tipe_doc_2 = 'docx';
      if($request->file('file_'.$request->file_upload)->getClientOriginalExtension() !== $tipe_doc_1 && $request->file('file_'.$request->file_upload)->getClientOriginalExtension() !== $tipe_doc_2){
          return redirect()->route('witels.pralop.detail',['edit_pralop_id'=>$request->encrypted[0]])->with('status','Oops! Format File Upload PDF atau DOCX.');
      }

      $filenametostore = '';
      if( ucwords(strtok($request->file_upload,'_')) === 'P0' ) {
          $filenametostore = $this->generateUniqueId() . '.' . $request->file('file_'.$request->file_upload)->getClientOriginalExtension();
          Storage::disk('sftp')->put( $filenametostore, fopen( $request->file('file_'.$request->file_upload), 'r+') );
      }
      if( ucwords(strtok($request->file_upload,'_')) === 'P1' ) {
          $filenametostore = $this->generateUniqueId() . '.' . $request->file('file_'.$request->file_upload)->getClientOriginalExtension();
          Storage::disk('sftp')->put( $filenametostore, fopen( $request->file('file_'.$request->file_upload), 'r+') );
      }
      $data_lama = $this->updateOblHistori( substr($request->file_upload, strpos($request->file_upload, "_") + 1) );
      $data_update = [
        'updated_at' => Carbon::now()->translatedFormat('Y-m-d H:i:s'),
        'updated_by' => Auth::id(),
        'f1_tgl_keterangan' => Carbon::now()->translatedFormat('Y-m-d H:i:s'),
        'f1_keterangan' => 'Upload File ' . ucwords(strtok($request->file_upload,'_')) . ' Layanan ' . $data_lama->f1_judul_projek
      ];
      if( ucwords(strtok($request->file_upload,'_')) === 'P1' ){ $data_update['file_p1'] = $filenametostore; }
      if( ucwords(strtok($request->file_upload,'_')) === 'P0' ){ $data_update['file_p0'] = $filenametostore; }
      DB::connection('pgsql')->table('form_obl')
      ->where('id', substr($request->file_upload, strpos($request->file_upload, "_") + 1) )
      ->update( $data_update );
      return redirect()->route('witels.pralop.detail',['edit_pralop_id'=>$request->encrypted[0]])->with('status','Sukses File Upload ' . ucwords(strtok($request->file_upload,'_')) . ' Layanan ' . $data_lama->f1_judul_projek);
    }
    else{ return redirect()->route('witels.pralop.detail',['edit_pralop_id'=>$request->encrypted[0]])->with('status','Oops! Gagal Upload'); }
  }

  public function layananDownload(Request $request){
    $data_download = DB::connection('pgsql')->table('form_obl')
    ->select('*',DB::raw("to_char(created_at,'yyyy-mm-dd') as tgl_create"))
    ->where('id', substr($request->file_download, strpos($request->file_download, "_") + 1) )
    ->first();
    $headers = null;
    $file_new_name = '';
    $docs_year = Carbon::parse($data_download->tgl_create)->translatedFormat('Y');

    if( ucwords(strtok($request->file_download,'_')) === 'P1' ){
      $file_new_name = $data_download->f1_segmen . '_' . $data_download->f1_folder . '_'. $docs_year . '_Form_P1.';
      if( substr($data_download->file_p1, strpos($data_download->file_p1, ".") + 1) === 'pdf' ){
        $headers  = array(
             'Content-Type: application/pdf',
           );
      }
      if( substr($data_download->file_p1, strpos($data_download->file_p1, ".") + 1) === 'docx' ){
        $headers = array(
            'Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        );
      }

      if(Storage::disk('sftp')->exists($data_download->file_p1)) {
        return Storage::disk('sftp')->download($data_download->file_p1,$file_new_name . substr($data_download->file_p1, strpos($data_download->file_p1, ".") + 1),$headers);
      }
    }
    else if( ucwords(strtok($request->file_download,'_')) === 'P0' ){
      $file_new_name = $data_download->f1_segmen . '_' . $data_download->f1_folder . '_'. $docs_year . '_Form_P0.';
      if( substr($data_download->file_p0, strpos($data_download->file_p0, ".") + 1) === 'pdf' ){
        $headers  = array(
             'Content-Type: application/pdf',
           );
      }
      if( substr($data_download->file_p0, strpos($data_download->file_p0, ".") + 1) === 'docx' ){
        $headers = array(
            'Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        );
      }
      if(Storage::disk('sftp')->exists($data_download->file_p0)) {
        return Storage::disk('sftp')->download($data_download->file_p0,$file_new_name . substr($data_download->file_p0, strpos($data_download->file_p0, ".") + 1),$headers);
      }
    }
    else{
      return redirect()->route('witels.pralop.detail',['edit_pralop_id'=>$request->encrypted[0]])->with('status','Oops! Gagal Download');
    }

  }


  public function reviewKB(Request $request){
    dd($request->all());
  }

  public function layananEdit(Request $request){
    dd($request->all());
  }

  public function layananEditUpdate(Request $request){
    dd($request->all());
  }




}
