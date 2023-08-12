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
use App\Models\MitraVendor;
use App\Models\DocObl;
use Carbon\Carbon;

class PrintController extends Controller
{
    public function index(Request $request){
      // dd($request->all());
      if($request->print_obl_id){
        if($request->print_obl_id !== ''){
          try{
            $list_print_obl = DB::connection('pgsql')->table('form_obl')->select('id','submit')->where('id',intval($request->print_obl_id))->whereRaw("(submit is not null and submit <> '' and submit not in ('submit_witel','draf_filter_kontrak','draf_filter_kl') )")->get()->toArray();
            if($list_print_obl && count($list_print_obl) > 0){ return response()->json(['status_id'=>'1','status'=>'','list_print_obl'=>$list_print_obl,'print_obl_id'=>$request->print_obl_id]); }
            else{ return response()->json(['status_id'=>'2','status'=>'Lengkapi Dokumen OBL Sebelum Print.']); }
          }
            catch(Throwable $e){
              return response()->json(['status_id'=>'3', 'status'=>'Oops! Gagal Mengambil Data Print OBL.']);
            }
        }
      }
      else{ return response()->json(['status_id'=>'4', 'status'=>'Oops! Wrong Routing.']); }
    }

    public function printOblDoc($var_obl_id,$var_tipe_form){
      $headers = array(
          'Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document',
      );
      return response()->download('path/to/file','nama_file.docx'.$headers);
    }

    public function create(Request $request){
      dd($request->all());
      if($request->submit){
        if( str_contains($request->submit,'submit_print_') ){
          try{
            // $headers = array(
            //     'Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            // );
            // $nilai = substr($request->submit,13,2);
            // return response()->download( public_path()."/basic_documents/basic_doc_".$nilai.".docx",'Doc_'.strtoupper($nilai).'.docx',$headers);
            $tipe_form = substr($request->submit,13,2);
            printOblDoc($request->print_obl_id,$tipe_form);
          }
          catch(Throwable $e){
           return redirect()->route('obl.tables')->with('status', 'Oops! Gagal Print Dokumen');
          }
        }
        else{ return redirect()->route('obl.tables')->with('status', 'Oops! Gagal Cek Form Print.'); }
      }
      else{ return redirect()->route('obl.tables')->with('status', 'Oops! Wrong Routing.'); }
    }
}
