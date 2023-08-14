<?php

namespace App\Http\Controllers;

use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use App\Models\User;
use App\Models\DocObl;
use App\Models\DocOblHistori;


class FilesController extends Controller
{
  public function download(Request $request){
    $route_return  = '';
    $file_new_name  = 'file_downloaded.pdf';
    $tipe_form  = '';
    $obl_id  = '';
    if($request->rt){ $route_return  = 'obl.tables'; }else{ $route_return  = 'obl.upload.index'; }
    if($request->ft){ $tipe_form  = strtoupper(Crypt::decrypt($request->ft)); }
    if($request->st){ $obl_id  = $request->st; }else{ return redirect()->route($route_return )->with('status','Oops! Gagal Cek ID Dokumen OBL.'); }

    try{
      $download_doc  = DocObl::select(
        'id',
        'f1_judul_projek',
        'f1_segmen',
        'f1_jenis_spk',
        DB::raw("substring(f1_folder, 5, length(f1_folder)-4 ) as folder"),
        DB::raw("to_char(created_at,'yyyy') as tahun"),
        DB::raw("case when file_p2 is null or file_p2 = '' then '' else file_p2 end as nama_p2"),
        DB::raw("case when file_p3 is null or file_p3 = '' then '' else file_p3 end as nama_p3"),
        DB::raw("case when file_p4 is null or file_p4 = '' then '' else file_p4 end as nama_p4"),
        DB::raw("case when file_p5 is null or file_p5 = '' then '' else file_p5 end as nama_p5"),
        DB::raw("case when file_p6 is null or file_p6 = '' then '' else file_p6 end as nama_p6"),
        DB::raw("case when file_p7 is null or file_p7 = '' then '' else file_p7 end as nama_p7"),
        DB::raw("case when file_p8 is null or file_p8 = '' then '' else file_p8 end as nama_p8"),
        DB::raw("case when file_sp is null or file_sp = '' then '' else file_sp end as nama_sp"),
        DB::raw("case when file_wo is null or file_wo = '' then '' else file_wo end as nama_wo"),
        DB::raw("case when file_kl is null or file_kl = '' then '' else file_kl end as nama_kl")
        )->where('id',$obl_id )->get()->toArray();
        $file_new_name  = 'File-' . $tipe_form  .'_Segmen-'.$download_doc [0]['f1_segmen'].'_Folder-'.$download_doc [0]['folder'].'_Tahun-'.$download_doc [0]['tahun'].'_SPK-'.$download_doc [0]['f1_jenis_spk'].'.pdf';
    }
    catch(Throwable $e){
      return redirect()->route($route_return )->with('status','Oops! Gagal Cek ID Dokumen OBL.');
    }

    if( $tipe_form  ){
      $nama_file  = '';
      if($tipe_form ==='P2'){ $nama_file  = $download_doc [0]['nama_p2']; }
      if($tipe_form ==='P3'){ $nama_file  = $download_doc [0]['nama_p3']; }
      if($tipe_form ==='P4'){ $nama_file  = $download_doc [0]['nama_p4']; }
      if($tipe_form ==='P5'){ $nama_file  = $download_doc [0]['nama_p5']; }
      if($tipe_form ==='P6'){ $nama_file  = $download_doc [0]['nama_p6']; }
      if($tipe_form ==='P7'){ $nama_file  = $download_doc [0]['nama_p7']; }
      if($tipe_form ==='P8'){ $nama_file  = $download_doc [0]['nama_p8']; }
      if($tipe_form ==='SP'){ $nama_file  = $download_doc [0]['nama_sp']; }
      if($tipe_form ==='WO'){ $nama_file  = $download_doc [0]['nama_wo']; }
      if($tipe_form ==='KL'){ $nama_file  = $download_doc [0]['nama_kl']; }

      if(Storage::disk('sftp')->exists($nama_file )) {
        $headers  = array(
             'Content-Type: application/pdf',
           );
        return Storage::disk('sftp')->download($nama_file,$file_new_name,$headers);
      }
      else{ return redirect()->route($route_return )->with('status','Oops! Server Tidak Menyimpan File Download.'); }
    }
    else{ return redirect()->route($route_return )->with('status','Oops! Wrong Routing.'); }
  }

  public function visibility(Request $request){
    $route_return_vis = '';
    $file_new_name_vis = 'file_downloaded.pdf';
    $tipe_form_vis = '';
    $obl_id_vis = '';
    if($request->rt){ $route_return_vis = 'obl.tables'; }else{ $route_return_vis = 'obl.upload.index'; }
    if($request->ft){ $tipe_form_vis = strtoupper(Crypt::decrypt($request->ft)); }
    if($request->st){ $obl_id_vis = $request->st; }else{ return redirect()->route($route_return_vis)->with('status','Oops! Gagal Cek ID Dokumen OBL.'); }

    try{
      $download_doc_vis = DocObl::select(
        'id',
        'f1_judul_projek',
        'f1_segmen',
        'f1_jenis_spk',
        DB::raw("substring(f1_folder, 5, length(f1_folder)-4 ) as folder"),
        DB::raw("to_char(created_at,'yyyy') as tahun"),
        DB::raw("case when file_p2 is null or file_p2 = '' then '' else file_p2 end as nama_p2"),
        DB::raw("case when file_p3 is null or file_p3 = '' then '' else file_p3 end as nama_p3"),
        DB::raw("case when file_p4 is null or file_p4 = '' then '' else file_p4 end as nama_p4"),
        DB::raw("case when file_p5 is null or file_p5 = '' then '' else file_p5 end as nama_p5"),
        DB::raw("case when file_p6 is null or file_p6 = '' then '' else file_p6 end as nama_p6"),
        DB::raw("case when file_p7 is null or file_p7 = '' then '' else file_p7 end as nama_p7"),
        DB::raw("case when file_p8 is null or file_p8 = '' then '' else file_p8 end as nama_p8"),
        DB::raw("case when file_sp is null or file_sp = '' then '' else file_sp end as nama_sp"),
        DB::raw("case when file_wo is null or file_wo = '' then '' else file_wo end as nama_wo"),
        DB::raw("case when file_kl is null or file_kl = '' then '' else file_kl end as nama_kl")
        )->where('id',$obl_id_vis)->get()->toArray();
        $file_new_name_vis = 'File-' . $tipe_form_vis .'_Segmen-'.$download_doc_vis[0]['f1_segmen'].'_Folder-'.$download_doc_vis[0]['folder'].'_Tahun-'.$download_doc_vis[0]['tahun'].'_SPK-'.$download_doc_vis[0]['f1_jenis_spk'].'.pdf';
    }
    catch(Throwable $e){
      return redirect()->route($route_return_vis)->with('status','Oops! Gagal Cek ID Dokumen OBL.');
    }

    if( $tipe_form_vis ){
      $nama_file_vis = '';
      if($tipe_form_vis==='P2'){ $nama_file_vis = $download_doc_vis[0]['nama_p2']; }
      if($tipe_form_vis==='P3'){ $nama_file_vis = $download_doc_vis[0]['nama_p3']; }
      if($tipe_form_vis==='P4'){ $nama_file_vis = $download_doc_vis[0]['nama_p4']; }
      if($tipe_form_vis==='P5'){ $nama_file_vis = $download_doc_vis[0]['nama_p5']; }
      if($tipe_form_vis==='P6'){ $nama_file_vis = $download_doc_vis[0]['nama_p6']; }
      if($tipe_form_vis==='P7'){ $nama_file_vis = $download_doc_vis[0]['nama_p7']; }
      if($tipe_form_vis==='P8'){ $nama_file_vis = $download_doc_vis[0]['nama_p8']; }
      if($tipe_form_vis==='SP'){ $nama_file_vis = $download_doc_vis[0]['nama_sp']; }
      if($tipe_form_vis==='WO'){ $nama_file_vis = $download_doc_vis[0]['nama_wo']; }
      if($tipe_form_vis==='KL'){ $nama_file_vis = $download_doc_vis[0]['nama_kl']; }

      if(Storage::disk('sftp')->exists($nama_file_vis)) {
        $headers_vis = array(
             'Content-Type: application/pdf',
           );
        return Storage::disk('sftp')->response($nama_file_vis);
      }
      else{ return redirect()->route($route_return_vis)->with('status','Oops! Server Tidak Menyimpan File Download.'); }
    }
    else{ return redirect()->route($route_return_vis)->with('status','Oops! Wrong Routing.'); }

  }

}
