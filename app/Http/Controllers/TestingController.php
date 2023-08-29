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
      // dd($request->all());
      if($request->print_obl_id && $request->print_form){
        if($request->print_form==='p0'){ $this->generateDocP0($request->print_obl_id); }
      }
      else{ return redirect()->route('obl.tables')->with('status','Oops! Gagal Cek ID Dokumen OBL.'); }
    }

    public function generateDocP0($var_obl_id){
      $docs = DB::connection('pgsql')->table('form_obl')->select('*')->where('id',$var_obl_id)->first();
      $docs_year = new Carbon($docs->created_at);
      $docs_year->translatedFormat('Y-m-d');
      $templateProcessor = new TemplateProcessor(public_path() . '/basic_documents/basic_p0_doc.docx');
      $templateProcessor->setValues([
          f1_nama_plggn
          f1_judul_projek
          p0_nomor_p0
          p0_pemeriksa
          f1_witel
          p0_tgl_submit
          f1_skema_bayar
          f1_nilai_kb
          string_f1_nilai_kb
          periode_bulan
          f1_mitra_id
          revenue
          harga_ke_mitra
          p0_nik_am
          p0_nik_manager
          p0_nik_gm
          f1_segmen
          f1_folder
      ]);
      $filename = Auth::id() . '_' . (string) Str::uuid();
      $file_path = public_path().'/temp_saved_docs';
      $templateProcessor->save($file_path.'/'.$filename.'.docx');
      $headers = array(
          'Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document',
      );
      return response()->download( $file_path . '/'.$filename.'.docx', $docs->f1_segmen . '_' . $docs->f1_folder . '_'. $docs_year . '_Form_P0.docx', $headers)->deleteFileAfterSend(true);
    }
}
