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
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Models\User;
use App\Models\DocObl;
use Carbon\Carbon;

class UploadController extends Controller
{
    public function index(Request $request){
      // dd($request->all());
      return view('pages.obls.upload');
    }

    public function tableUpload(Request $request){
       if($request->upload_doc_id){
         $upload_doc_id = $request->upload_doc_id;
         try{
           $upload_doc = DocObl::select('id','f1_judul_projek','f1_segmen',DB::raw("substring(f1_folder, 5, length(f1_folder)-4 ) as folder"))->where('id',$upload_doc_id)->get()->toArray();
           return view('pages.obls.upload',compact('upload_doc'));
         }
         catch(Throwable $e){ return redirect()->route('obl.tables')->with('status', 'Oops! Gagal Cek ID Dokumen OBL'); }
       }
       else{ return redirect()->route('obl.tables')->with('status', 'Oops! Wrong Routing.'); }
    }
}
