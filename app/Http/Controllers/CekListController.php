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
use App\Models\User;
use App\Models\MitraVendor;
use App\Models\DocObl;
use App\Models\DocOblHistori;
use Carbon\Carbon;
use DataTables;
use File;

class CekListController extends Controller
{
    public function ceklistSol(Request $request){
      // dd( $request->all() );
      strtok($request->var_list_sol, '_');
      $id = strtok("");
      $tipe = strtok($request->var_list_sol, '_');
      // dd( $request->all(), $id, $tipe );

      $data = null;
      if( $tipe && $tipe === 'pralop' ){
        $data = DB::connection('pgsql')->table('form_pralop')
        ->select('*')->where('id', $id )->first();
      }
      if( $tipe && $tipe === 'histori' ){
        $data = DB::connection('pgsql')->table('form_pralop_histori')
        ->select('*')->where('id', $id )->first();
      }

      return response()->json($data);
    }

    public function ceklistLeg(Request $request){
      // dd( $request->all() );
      strtok($request->var_list_leg, '_');
      $id = strtok("");
      $tipe = strtok($request->var_list_leg, '_');
      // dd( $request->all(), $id, $tipe );

      $data = null;
      if( $tipe && $tipe === 'pralop' ){
        $data = DB::connection('pgsql')->table('form_pralop')
        ->select('*')->where('id', $id )->first();
      }
      if( $tipe && $tipe === 'histori' ){
        $data = DB::connection('pgsql')->table('form_pralop_histori')
        ->select('*')->where('id', $id )->first();
      }

      return response()->json($data);
    }
}
