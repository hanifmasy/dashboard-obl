<?php

namespace App\Http\Controllers;

Use Str;
Use Hash;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;

class WitelsController extends Controller
{
    public function create(Request $request): RedirectResponse
    {
      // dd($request->all());
      $created_by = Auth::id();
      $created_by_witel = User::leftJoin('witels','witels.id','=','users.witel_id')->select('users.id','users.witel_id','witels.nama_witel')->where('users.id',Auth::id())->first();
      $created_at = Carbon::now()->translatedFormat('Y-m-d H:i:s');

      if($request->submit){
        if($request->submit == 'submit_witel'){
          $inputan_masuk = [];
          $inputan_masuk['f1_segmen'] = 'required';
          $inputan_masuk['f1_judul_projek'] = 'required';
          $inputan_masuk['f1_nama_plggn'] = 'required';
          $inputan_masuk['f1_mitra_id'] = 'required';
          $validasi = $request->all();
          $validator_draf = Validator::make($validasi,$inputan_masuk);
          if($validator_draf->fails()){ return back()->withErrors($validator_draf)->withInput(); }

          try{
            // PENAMAAN FOLDER & SUBFOLDER
            $nama_folder = '';
            if($request->f1_segmen){
                $hari = Carbon::now();
                $hari_ini = $hari->dayOfYear;
                $tahun_ini = $hari->year;
                $tahun_ini = strval($tahun_ini);
                $hari_ini = ($hari_ini*40);
                if($request->f1_quote_kontrak){
                  try{
                    $cek_quote_kontrak = DB::connection('pgsql')->table('form_obl')->select('id','f1_quote_kontrak')->where('f1_quote_kontrak',$request->f1_quote_kontrak)->orderBy('created_at','ASC')->get()->toArray();
                    $nama_subfolder = '';
                    if( count($cek_quote_kontrak) > 0 ){
                        $tambah_subfolder = 'A';
                        $digits_subfolder = strlen(strval(count($cek_quote_kontrak)));
                        for($i = 0; $i < $digits_subfolder; $i++){ $nama_subfolder = $nama_subfolder . $tambah_subfolder; }
                        $skip_subfolder = null;
                        $string_hari_ini = sprintf("%04d", $hari_ini);
                        do{
                          $nama_folder = $request->f1_segmen . '_' . $string_hari_ini . $nama_subfolder;
                          $cek_nama_folder = DB::connection('pgsql')->table('form_obl')->select('id','f1_folder')->where(DB::raw("to_char(created_at,'yyyy')"),'=',$tahun_ini)->where('f1_folder',$nama_folder)->get()->toArray();
                          if( count($cek_nama_folder) > 0 ){ $skip_subfolder = true; $nama_subfolder++; }
                          else{ $skip_subfolder = false; }
                        }while($skip_subfolder==true);
                    }
                    else{
                      $skip_folder = null;
                      do{
                        $string_hari_ini = sprintf("%04d", $hari_ini);
                        $nama_folder = $request->f1_segmen . '_' . $string_hari_ini;
                        $cek_nama_folder = DB::connection('pgsql')->table('form_obl')->select('id','f1_folder')->where(DB::raw("to_char(created_at,'yyyy')"),'=',$tahun_ini)->where('f1_folder',$nama_folder)->get()->toArray();
                        if( count($cek_nama_folder) > 0 ){ $skip_folder = true; $hari_ini++; }
                        else{ $skip_folder = false; }
                      }while($skip_folder==true);
                    }
                  }
                  catch(Throwable $e){ return back()->withInput()->with('status','Oops! Gagal Check Quote Kontrak.'); }
                }
                else{
                  $skip_folder = null;
                  do{
                    $string_hari_ini = sprintf("%04d", $hari_ini);
                    $nama_folder = $request->f1_segmen . '_' . $string_hari_ini;
                    $cek_nama_folder = DB::connection('pgsql')->table('form_obl')->select('id','f1_folder')->where(DB::raw("to_char(created_at,'yyyy')"),'=',$tahun_ini)->where('f1_folder',$nama_folder)->get()->toArray();
                    if( count($cek_nama_folder) > 0 ){ $skip_folder = true; $hari_ini++; }
                    else{ $skip_folder = false; }
                  }while($skip_folder==true);
                }
            }

            // GET ALL INPUTS
            $collection = collect($request->all());
            $filtered = $collection->except([
                '_token'
            ]);
            $filtered->put('created_by',$created_by);
            $filtered->put('created_at',$created_at);
            $filtered->put('f1_proses','witel');
            $filtered->put('f1_witel',$created_by_witel->nama_witel);
            $filtered->put('f1_folder',$nama_folder);
            $obl_id = DB::connection('pgsql')->table('form_obl')
            ->insertGetId(
                $filtered->all()
            );
            return redirect('witels')->with('status', 'Sukses Simpan Form Witel');
          }
          catch(Throwable $e){ return back()->withInput()->with('status','Oops! Gagal Simpan Input Form Witel.'); }

        }
        else{ return back()->withInput()->with('status','Oops! Gagal Submit Form Witel.'); }
      }
      else{
        return back()->withInput()->with('status','Oops! Gagal Routing.');
      }
    }
}
