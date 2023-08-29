<?php

namespace App\Http\Controllers;

use App\Exceptions\Handler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use NumberToWords\NumberToWords;
use Laraindo\RupiahFormat;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Writer\Word2007;
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
            $user_in_is = User::leftJoin('user_role','user_role.user_id','=','users.id')
            ->leftJoin('witels','witels.id','=','users.witel_id')
            ->leftJoin('user_mitra','user_mitra.user_id','=','users.id')
            ->leftJoin('mitras','mitras.id','=','user_mitra.mitra_id')
            ->select('users.id','user_role.role_id','users.witel_id','witels.nama_witel','mitras.nama_mitra','mitras.id as mitra_id')->where('users.id',Auth::id())->first();

            $list_print_obl = DB::connection('pgsql')->table('form_obl')
            ->select('*')
            ->where('id',intval($request->print_obl_id))
            ->whereRaw("
              (submit is not null and submit <> '' and submit not in ('am_submit','solution_submit','obl_submit','obl_lampiran','obl_edit','solution_file_p0','solution_file_p1','solution_edit','am_edit','am_file_p1','am_file_p0') ) and
              (f1_proses is not null and f1_proses <> '') and
              (f1_segmen is not null and f1_segmen <> '') and
              (f1_folder is not null and f1_folder <> '')
            ")
            ->first();
            if( $list_print_obl ){
              return response()->json(['status_id'=>'1','status'=>'','list_print_obl'=>$list_print_obl,'print_obl_id'=>$request->print_obl_id,'user_in_is'=>$user_in_is]);
            }
            else{ return response()->json(['status_id'=>'2','status'=>'Sesuaikan Status Update Form.']); }
          }
            catch(Throwable $e){
              return response()->json(['status_id'=>'3', 'status'=>'Oops! Gagal Mengambil Data Print OBL.']);
            }
        }
      }
      else{ return response()->json(['status_id'=>'4', 'status'=>'Oops! Wrong Routing.']); }
    }

    public function generateDocP0($var_obl_id){
      $docs = DB::connection('pgsql')->table('form_obl')->leftJoin('mitras','mitras.id','=','f1_mitra_id')
      ->select(
        'form_obl.id',
        'f1_nama_plggn',
        'f1_judul_projek',
        'p0_nomor_p0',
        'p0_pemeriksa',
        'f1_witel',
        DB::raw("to_char(p0_tgl_submit,'DD Mon YYYY') as tgl_submit"),
        DB::raw("
        case
        when f1_skema_bayar = 'otc' then 'One Time Charge (OTC)'
        when f1_skema_bayar = 'recurring' then 'Recurring'
        when f1_skema_bayar = 'termin' then 'Termin'
        when f1_skema_bayar = 'otc_recurring' then 'OTC Recurring'
        else ''
        end as skema_bayar
        "),
        DB::raw(" date_part('month', age(p1_tgl_kontrak_akhir ,p1_tgl_kontrak_mulai) ) as periode_bulan"),
        'p1_estimasi_harga',
        'f1_nilai_kb',
        'f1_mitra_id',
        'mitras.nama_mitra',
        'p0_nik_am',
        'p0_nik_manager',
        'p0_nik_gm',
        'f1_segmen',
        'f1_folder',
        'created_at'
      )
      ->where('form_obl.id',$var_obl_id)->first();
      $docs_year = new Carbon($docs->created_at);
      $docs_year = $docs_year->translatedFormat('Y');
      $templateProcessor = new TemplateProcessor(public_path() . '/basic_documents/basic_p0_doc.docx');
      $templateProcessor->setValues([
          'f1_nama_plggn' => $docs->f1_nama_plggn,
          'f1_judul_projek' => $docs->f1_judul_projek,
          'p0_nomor_p0' => $docs->p0_nomor_p0,
          'p0_pemeriksa' => strtoupper(((string)strtok($docs->p0_pemeriksa,'_'))),
          'f1_witel' =>  ucfirst((strtolower($docs->f1_witel))),
          'p0_tgl_submit' => $docs->tgl_submit,
          'f1_skema_bayar' => $docs->skema_bayar,
          'p1_estimasi_harga' => $docs->p1_estimasi_harga,
          'string_p1_estimasi_harga' => RupiahFormat::terbilang( (int)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,',')))) ),
          'periode_bulan' => $docs->periode_bulan,
          'f1_mitra_id' => $docs->nama_mitra,
          'revenue' =>   RupiahFormat::currency( (int)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,','))))  * 0.1 ),
          'harga_ke_mitra' => RupiahFormat::currency( ( (float)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,',')))) - ( (int)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,','))))  * 0.1 ) ) ),
          'p0_nik_am' => $docs->p0_nik_am,
          'p0_nik_manager' => $docs->p0_nik_manager,
          'p0_nik_gm' => $docs->p0_nik_gm,
          'f1_segmen' => $docs->f1_segmen,
          'f1_folder' => $docs->f1_folder
      ]);
      $filename = Auth::id() . '_' . (string) Str::uuid();
      $file_path = public_path().'/temp_saved_docs';
      $templateProcessor->saveAs($file_path.'/'.$filename.'.docx');
      $headers = array(
          'Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document',
      );
      return response()->download( $file_path . '/'.$filename.'.docx', $docs->f1_segmen . '_' . $docs->f1_folder . '_'. $docs_year . '_Form_P0.docx', $headers)->deleteFileAfterSend(true);
    }

    public function generateDocP1($var_obl_id){
      $docs = DB::connection('pgsql')->table('form_obl')->leftJoin('mitras','mitras.id','=','f1_mitra_id')
      ->select(
        'form_obl.id',
        'f1_nama_plggn',
        'f1_judul_projek',
        'p1_nomor_p1',
        'p1_pemeriksa',
        'f1_witel',
        'p1_tgl_delivery',
        'p1_tgl_p1',
        DB::raw("
        case
        when p1_skema_bayar = 'otc' then 'One Time Charge (OTC)'
        when p1_skema_bayar = 'recurring' then 'Recurring'
        when p1_skema_bayar = 'termin' then 'Termin'
        when p1_skema_bayar = 'otc_recurring' then 'OTC Recurring'
        else ''
        end as skema_bayar
        "),
        DB::raw("
        case
        when p1_skema_bisnis = 'sewa_murni' then 'Sewa Murni'
        when p1_skema_bisnis = 'sewa_beli' then 'Sewa Beli'
        when p1_skema_bisnis = 'beli_putus' then 'Pengadaan Beli Putus'
        else ''
        end as skema_bisnis
        "),
        DB::raw("
        case
        when p1_mekanisme_bayar = 'back_to_back' then 'Back To Back'
        when p1_mekanisme_bayar = 'non_back_to_back' then 'Non Back To Back'
        else ''
        end as mekanisme_bayar
        "),
        DB::raw(" date_part('month', age(p1_tgl_kontrak_akhir ,p1_tgl_kontrak_mulai) ) as periode_bulan"),
        'p1_estimasi_harga',
        'f1_nilai_kb',
        'f1_mitra_id',
        'mitras.nama_mitra',
        'p1_dibuat_am',
        'p1_diperiksa_manager',
        'p1_disetujui_gm',
        'p1_lokasi_instal',
        'p1_tgl_doc_plggn',
        'f1_segmen',
        'f1_folder',
        'created_at'
      )
      ->where('form_obl.id',$var_obl_id)->first();
      $docs_year = new Carbon($docs->created_at);
      $docs_year = $docs_year->translatedFormat('Y');
      $p1_tgl_p1 = new Carbon($docs->p1_tgl_p1);
      $p1_tgl_p1 = $p1_tgl_p1->translatedFormat('d F Y');
      $p1_tgl_delivery = new Carbon($docs->p1_tgl_delivery);
      $p1_tgl_delivery = $p1_tgl_delivery->translatedFormat('d F Y');
      $p1_tgl_doc_plggn = new Carbon($docs->p1_tgl_doc_plggn);
      $p1_tgl_doc_plggn = $p1_tgl_doc_plggn->translatedFormat('d F Y');

      $templateProcessor = new TemplateProcessor(public_path() . '/basic_documents/basic_p1_doc.docx');
      $templateProcessor->setValues([
          'p1_nomor_p1' => $docs->p1_nomor_p1,
          'p1_pemeriksa' => strtoupper(((string)strtok($docs->p1_pemeriksa,'_'))),
          'f1_witel' =>  ucfirst((strtolower($docs->f1_witel))),
          'p1_tgl_p1' => $p1_tgl_p1,
          'p1_tgl_delivery' => $p1_tgl_delivery,
          'p1_tgl_doc_plggn' => $p1_tgl_doc_plggn,
          'p1_lokasi_instal' => $docs->p1_lokasi_instal,
          'p1_skema_bayar' => $docs->skema_bayar,
          'p1_skema_bisnis' => $docs->skema_bisnis,
          'p1_mekanisme_bayar' => $docs->mekanisme_bayar,
          'p1_estimasi_harga' => $docs->p1_estimasi_harga,
          'string_p1_estimasi_harga' => RupiahFormat::terbilang( (int)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,',')))) ),
          'revenue' =>   RupiahFormat::currency( (int)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,','))))  * 0.1 ),
          'harga_ke_mitra' => RupiahFormat::currency( ( (float)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,',')))) - ( (int)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,','))))  * 0.1 ) ) ),
          'f1_nama_plggn' => $docs->f1_nama_plggn,
          'f1_judul_projek' => $docs->f1_judul_projek,
          'periode_bulan' => $docs->periode_bulan,
          'f1_mitra_id' => $docs->nama_mitra,
          'p1_dibuat_am' => $docs->p1_dibuat_am,
          'p1_diperiksa_manager' => $docs->p1_diperiksa_manager,
          'p1_disetujui_gm' => $docs->p1_disetujui_gm
      ]);
      $filename = Auth::id() . '_' . (string) Str::uuid();
      $file_path = public_path().'/temp_saved_docs';
      $templateProcessor->saveAs($file_path.'/'.$filename.'.docx');
      $headers = array(
          'Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document',
      );
      return response()->download( $file_path . '/'.$filename.'.docx', $docs->f1_segmen . '_' . $docs->f1_folder . '_'. $docs_year . '_Form_P1.docx', $headers)->deleteFileAfterSend(true);
    }

      // generateDocP2
      // generateDocP3
      // generateDocP4
      // generateDocP5
      // generateDocP6
      // generateDocP7
      // generateDocP8
      // generateDocWO
      // generateDocSP
      // generateDocKL

    public function create(Request $request){
      // dd($request->all());
      if($request->submit && $request->print_obl_id){
        if( str_contains($request->submit,'print_') ){
          try{
            if( substr($request->submit,6,2) === 'p0' ){ return $this->generateDocP0($request->print_obl_id); }
            if( substr($request->submit,6,2) === 'p1' ){ return $this->generateDocP1($request->print_obl_id); }
            if( substr($request->submit,6,2) === 'p2' ){ return $this->generateDocP2($request->print_obl_id); }
            if( substr($request->submit,6,2) === 'p3' ){ return $this->generateDocP3($request->print_obl_id); }
            if( substr($request->submit,6,2) === 'p4' ){ return $this->generateDocP4($request->print_obl_id); }
            if( substr($request->submit,6,2) === 'p5' ){ return $this->generateDocP5($request->print_obl_id); }
            if( substr($request->submit,6,2) === 'p6' ){ return $this->generateDocP6($request->print_obl_id); }
            if( substr($request->submit,6,2) === 'p7' ){ return $this->generateDocP7($request->print_obl_id); }
            if( substr($request->submit,6,2) === 'p8' ){ return $this->generateDocP8($request->print_obl_id); }
            if( substr($request->submit,6,2) === 'wo' ){ return $this->generateDocWO($request->print_obl_id); }
            if( substr($request->submit,6,2) === 'sp' ){ return $this->generateDocSP($request->print_obl_id); }
            if( substr($request->submit,6,2) === 'kl' ){ return $this->generateDocKL($request->print_obl_id); }
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
