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
use App\Models\User;
use App\Models\DocObl;
use App\Models\DocOblHistori;
use Carbon\Carbon;

class ProsesOblController extends Controller
{
   public function prosesWitel(Request $request){
     dd($request->all());
   }

   public function prosesObl(Request $request){
     dd($request->all());
   }

   public function legalObl(Request $request){
     dd($request->all());
   }

   public function mitraObl(Request $request){
     dd($request->all());
   }

   public function closesmObl(Request $request){
     dd($request->all());
   }

   public function doneObl(Request $request){
     dd($request->all());
   }

   public function cancelObl(Request $request){
     dd($request->all());
   }

}
