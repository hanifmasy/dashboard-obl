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
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class TestingController extends Controller
{
    public function index(Request $request)
    {

      $cek_user = User::leftJoin('user_role as ur','ur.user_id','=','users.id')->leftJoin('roles as r','r.id','=','ur.role_id')
      ->select('users.id','ur.role_id','r.nama_role')
      ->where('users.id',Auth::user()->id)
      ->first();
      dd( $cek_user->role_id );
      // $insert_user_db = [
      //     [ 'nama_lengkap'=>'Permata Sari Sugianto'	,'username'=>'adminpermata', 'email'=>'adminpermata@material.com'	, 'password'=>'zakypandaungu' ],
      //     [ 'nama_lengkap'=>'Pertiwi Mega Reformasintia'	,'username'=>'adminpertiwi', 'email'=>'adminpertiwi@material.com'	, 'password'=>'adminobl2' ],
      //     [ 'nama_lengkap'=>'Puspa Ramadhani'	,'username'=>'adminpuspa', 'email'=>'adminpuspa@material.com'	, 'password'=>'adminobl3' ],
      //     [ 'nama_lengkap'=>'Domas Indri Lestari'	,'username'=>'admindomas', 'email'=>'admindomas@material.com'	, 'password'=>'adminobl4' ],
      //     [ 'nama_lengkap'=>'Chaeril'	,'username'=>'adminchaeril', 'email'=>'adminchaeril@material.com'	, 'password'=>'adminobl5' ],
      //     [ 'nama_lengkap'=>'Dinul Qoyimah'	,'username'=>'admindinul', 'email'=>'admindinul@material.com'	, 'password'=>'adminpjm1' ],
      //     [ 'nama_lengkap'=>'Sthevy Simak Lando'	,'username'=>'adminsthevy', 'email'=>'adminsthevy@material.com'	, 'password'=>'adminpjm2' ],
      //     [ 'nama_lengkap'=>'Witel Balikpapan'	,'username'=>'witelbpp', 'email'=>'witelbpp@material.com'	, 'password'=>'akunwitelbpp' ],
      //     [ 'nama_lengkap'=>'Witel Samarinda'	,'username'=>'witelsmd', 'email'=>'witelsmd@material.com'	, 'password'=>'akunwitelsmd' ],
      //     [ 'nama_lengkap'=>'Witel Kalbar'	,'username'=>'witelkalbar', 'email'=>'witelkalbar@material.com'	, 'password'=>'akunwitelkalbar' ],
      //     [ 'nama_lengkap'=>'Witel Kalsel'	,'username'=>'witelkalsel', 'email'=>'witelkalsel@material.com'	, 'password'=>'akunwitelkalsel' ],
      //     [ 'nama_lengkap'=>'Witel Kalteng'	,'username'=>'witelkalteng', 'email'=>'witelkalteng@material.com'	, 'password'=>'akunwitelkalteng' ],
      //     [ 'nama_lengkap'=>'Witel Kaltara'	,'username'=>'witelkaltara', 'email'=>'witelkaltara@material.com'	, 'password'=>'akunwitelkaltara' ],
      //     [ 'nama_lengkap'=>'TELKOMSAT'	,'username'=>'mitratelkomsat', 'email'=>'mitratelkomsat@material.com'	, 'password'=>'akunmitratelkomsat' ],
      //     [ 'nama_lengkap'=>'KOPEGTEL BANJARMASIN'	,'username'=>'mitrakopegtel', 'email'=>'mitrakopegtel@material.com'	, 'password'=>'akunmitrakopegtel' ],
      //     [ 'nama_lengkap'=>'INFOMEDIA NUSANTARA'	,'username'=>'mitrainfomedia', 'email'=>'mitrainfomedia@material.com'	, 'password'=>'akunmitrainfomedia' ],
      //     [ 'nama_lengkap'=>'MD MEDIA'	,'username'=>'mitramd', 'email'=>'mitramd@material.com'	, 'password'=>'akunmitramd' ],
      //     [ 'nama_lengkap'=>'SIGMA'	,'username'=>'mitrasigma', 'email'=>'mitrasigma@material.com'	, 'password'=>'akunmitrasigma' ],
      //     [ 'nama_lengkap'=>'KOPKAR SMART MEDIA'	,'username'=>'mitrakopkar', 'email'=>'mitrakopkar@material.com'	, 'password'=>'akunmitrakopkar' ],
      //     [ 'nama_lengkap'=>'WAVECOMINDO'	,'username'=>'mitrawavecomindo', 'email'=>'mitrawavecomindo@material.com'	, 'password'=>'akunmitrawavecomindo' ],
      //     [ 'nama_lengkap'=>'SUMBER SOLUSINDO HITECH'	,'username'=>'mitrasumber', 'email'=>'mitrasumber@material.com'	, 'password'=>'akunmitrasumber' ],
      //     [ 'nama_lengkap'=>'CEMITEL'	,'username'=>'mitracemitel', 'email'=>'mitracemitel@material.com'	, 'password'=>'akunmitracemitel' ],
      //     [ 'nama_lengkap'=>'MITRATEL'	,'username'=>'mitramitratel', 'email'=>'mitramitratel@material.com'	, 'password'=>'akunmitramitratel' ],
      //     [ 'nama_lengkap'=>'PUTRA BISTEL'	,'username'=>'mitraputra', 'email'=>'mitraputra@material.com'	, 'password'=>'akunmitraputra' ],
      //     [ 'nama_lengkap'=>'INDOSAT'	,'username'=>'mitraindosat', 'email'=>'mitraindosat@material.com'	, 'password'=>'akunmitraindosat' ],
      //     [ 'nama_lengkap'=>'SISTELINDO'	,'username'=>'mitrasistelindo', 'email'=>'mitrasistelindo@material.com'	, 'password'=>'akunmitrasistelindo' ],
      //     [ 'nama_lengkap'=>'TPCC'	,'username'=>'mitratpcc', 'email'=>'mitratpcc@material.com'	, 'password'=>'akunmitratpcc' ],
      //     [ 'nama_lengkap'=>'PINS'	,'username'=>'mitrapins', 'email'=>'mitrapins@material.com'	, 'password'=>'akunmitrapins' ],
      //     [ 'nama_lengkap'=>'MINOVA'	,'username'=>'mitraminova', 'email'=>'mitraminova@material.com'	, 'password'=>'akunmitraminova' ],
      //     [ 'nama_lengkap'=>'SYPUMA'	,'username'=>'mitrasypuma', 'email'=>'mitrasypuma@material.com'	, 'password'=>'akunmitrasypuma' ],
      //     [ 'nama_lengkap'=>'SYNETCOM'	,'username'=>'mitrasynetcom', 'email'=>'mitrasynetcom@material.com'	, 'password'=>'akunmitrasynetcom' ],
      //     [ 'nama_lengkap'=>'COMTECH AGUNG'	,'username'=>'mitracomtech', 'email'=>'mitracomtech@material.com'	, 'password'=>'akunmitracomtech' ],
      //     [ 'nama_lengkap'=>'NUTECH'	,'username'=>'mitranutech', 'email'=>'mitranutech@material.com'	, 'password'=>'akunmitranutech' ],
      //     [ 'nama_lengkap'=>'POINTER'	,'username'=>'mitrapointer', 'email'=>'mitrapointer@material.com'	, 'password'=>'akunmitrapointer' ],
      //     [ 'nama_lengkap'=>'TELKOM AKSES'	,'username'=>'mitratelkom', 'email'=>'mitratelkom@material.com'	, 'password'=>'akunmitratelkom' ],
      //     [ 'nama_lengkap'=>'METRANET'	,'username'=>'mitrametranet', 'email'=>'mitrametranet@material.com'	, 'password'=>'akunmitrametranet' ],
      //     [ 'nama_lengkap'=>'ISH'	,'username'=>'mitraish', 'email'=>'mitraish@material.com'	, 'password'=>'akunmitraish' ],
      //     [ 'nama_lengkap'=>'Rio Wibisono'	,'username'=>'adminrio', 'email'=>'adminrio@material.com'	, 'password'=>'adminpjm' ],
      //     [ 'nama_lengkap'=>'Septian Zakaria'	,'username'=>'adminseptian', 'email'=>'adminseptian@material.com'	, 'password'=>'septianz' ],
      //     [ 'nama_lengkap'=>'Andhy Panca Saputra'	,'username'=>'adminandhy', 'email'=>'adminandhy@material.com'	, 'password'=>'adminobl6' ],
      //     [ 'nama_lengkap'=>'Taufik'	,'username'=>'admintaufik', 'email'=>'admintaufik@material.com'	, 'password'=>'adminobl7' ],
      //     [ 'nama_lengkap'=>'Yayan Nuryana'	,'username'=>'adminyayan', 'email'=>'adminyayan@material.com'	, 'password'=>'adminobl8' ],
      //     [ 'nama_lengkap'=>'Witel Balikpapan'	,'username'=>'balikpapan', 'email'=>'balikpapan@material.com'	, 'password'=>'akunmgrwitelbpp' ],
      //     [ 'nama_lengkap'=>'Witel Samarinda'	,'username'=>'samarinda', 'email'=>'samarinda@material.com'	, 'password'=>'akunmgrwitelsmd' ],
      //     [ 'nama_lengkap'=>'Manager Witel Kalbar'	,'username'=>'kalbar', 'email'=>'kalbar@material.com'	, 'password'=>'akunmgrwitelkalbar' ],
      //     [ 'nama_lengkap'=>'Witel Kalsel'	,'username'=>'kalsel', 'email'=>'kalsel@material.com'	, 'password'=>'akunmgrwitelkalsel' ],
      //     [ 'nama_lengkap'=>'Witel Kaltara'	,'username'=>'kaltara', 'email'=>'kaltara@material.com'	, 'password'=>'akunmgrwitelkaltara' ],
      //     [ 'nama_lengkap'=>'Witel Kalteng'	,'username'=>'kalteng', 'email'=>'kalteng@material.com'	, 'password'=>'akunmgrwitelkalteng' ],
      //     [ 'nama_lengkap'=>'TESTER'	,'username'=>'tester', 'email'=>'tester@material.com'	, 'password'=>'akuntester' ],
      //     [ 'nama_lengkap'=>'PT TELKOM  SATELIT INDONESIA'	,'username'=>'mitrapt', 'email'=>'mitrapt@material.com'	, 'password'=>'akunmitrapt' ],
      //     [ 'nama_lengkap'=>'Cahaya'	,'username'=>'admincahaya', 'email'=>'admincahaya@material.com'	, 'password'=>'mamadedeh' ],
      //     [ 'nama_lengkap'=>'SSH'	,'username'=>'mitrassh', 'email'=>'mitrassh@material.com'	, 'password'=>'akunmitrassh' ],
      //     [ 'nama_lengkap'=>'Haris Solution'	,'username'=>'harissolution', 'email'=>'harissolution@material.com'	, 'password'=>'harissolution' ],
      //     [ 'nama_lengkap'=>'Satria Solution'	,'username'=>'satriasolution', 'email'=>'satriasolution@material.com'	, 'password'=>'satriasolution' ],
      //     [ 'nama_lengkap'=>'Titis Yulinar'	,'username'=>'titissolution', 'email'=>'titissolution@material.com'	, 'password'=>'titissolution' ],
      //     [ 'nama_lengkap'=>'Novi'	,'username'=>'adminnovi', 'email'=>'adminnovi@material.com'	, 'password'=>'adminobl9' ],
      //     [ 'nama_lengkap'=>'Eva'	,'username'=>'evasolution', 'email'=>'evasolution@material.com'	, 'password'=>'evasolution1' ],
      //     [ 'nama_lengkap'=>'Risa'	,'username'=>'adminrisa', 'email'=>'adminrisa@material.com'	, 'password'=>'adminobl10' ],
      //     [ 'nama_lengkap'=>'Adel'	,'username'=>'adminadel', 'email'=>'adminadel@material.com'	, 'password'=>'adminobl11' ],
      //     [ 'nama_lengkap'=>'Akbar'	,'username'=>'adminakbar', 'email'=>'adminakbar@material.com'	, 'password'=>'adminobl12' ]
      //   ];
      //   $insert_user_db_1 = [];
      //   foreach($insert_user_db as $key => $value){
      //     array_push($insert_user_db_1,
      //       [
      //         'nama_lengkap'=>$value['nama_lengkap'],
      //         'username'=>$value['username'],
      //         'email'=>$value['email'],
      //         'password'=>bcrypt($value['password'])
      //       ]
      //     );
      //   }
      //   // dd($insert_user_db_1);
      //   $return_hasil = DB::connection('pgsql')->table('users')->insert($insert_user_db_1);
      //
      //   dd($return_hasil);
    }
}
