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
      dd($request->all());
      if($request->submit){
        if($request->submit == 'submit_witel'){
          // "f1_quote_kontrak" => null
          // "f1_nomor_akun" => null
          // "f1_nilai_kb" => null
          // "f1_judul_projek" => null
          // "f1_nama_plggn" => null
          // "f1_alamat_plggn" => null
          // "f1_pic_plggn" => null
          $inputan_masuk = [];
          $inputan_masuk['f1_segmen'] = 'required';
          $inputan_masuk['f1_judul_projek'] = 'required';
          $inputan_masuk['f1_nama_plggn'] = 'required';
          $inputan_masuk['f1_nama_mitra'] = 'required';
          $validasi = $request->all();
          $validator_draf = Validator::make($validasi,$inputan_masuk);
          if($validator_draf->fails()){ return back()->withErrors($validator_draf)->withInput(); }

        }
        else{ return back()->withInput()->with('status','Oops! Gagal Routing'); }
      }
      else{
        return back()->withInput()->with('status','Oops! Gagal Routing.');
      }
    }
}
