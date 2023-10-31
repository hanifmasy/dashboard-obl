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
      // dd( $request->all() );
      return view('pages.testing');
    }
}
