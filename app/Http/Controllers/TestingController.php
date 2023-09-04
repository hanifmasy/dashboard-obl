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
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use PhpOffice\PhpWord\PhpWord;
use \PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Writer\Word2007;
use App\Models\User;
use App\Models\DocObl;
use Carbon\Carbon;
use DataTables;

class TestingController extends Controller
{
    public function index(Request $request)
    {
      $data_lama = DB::connection('pgsql')->table('form_obl')
      ->where('f1_id_form_pralop','3')
      ->get()->toArray();
      $arr = [];
      foreach( $data_lama as $key => $value ){
        array_push($arr,$value->id);
      }
      dd($data_lama,$data_lama[0]->id,$arr);
    }
}
