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
        'form_obl.*',
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
        'mitras.nama_mitra'
      )->where('form_obl.id',$var_obl_id)->first();

      $docs_year = new Carbon($docs->created_at);
      $docs_year = $docs_year->translatedFormat('Y');

      $p1_tgl_p1 = new Carbon($docs->p1_tgl_p1);
      $p1_tgl_p1 = $p1_tgl_p1->translatedFormat('d F Y');
      $p1_tgl_delivery = new Carbon($docs->p1_tgl_delivery);
      $p1_tgl_delivery = $p1_tgl_delivery->translatedFormat('d F Y');
      $p1_tgl_doc_plggn = new Carbon($docs->p1_tgl_doc_plggn);
      $p1_tgl_doc_plggn = $p1_tgl_doc_plggn->translatedFormat('d F Y');

      $p1_pemeriksa = '';
      $p1_gm_witel = '';
      $p1_mgr_pemeriksa = '';
      if( $docs->f1_segmen === 'DBS' ){
        $p1_pemeriksa = 'Business Service Witel ' . ucfirst((strtolower($docs->f1_witel)));
        $p1_mgr_pemeriksa = 'Manager Business Service Witel ' . ucfirst((strtolower($docs->f1_witel)));
        $p1_gm_witel = 'GM Telkom Witel ' . ucfirst((strtolower($docs->f1_witel)));
      }
      if( $docs->f1_segmen === 'DES' ){
        $p1_pemeriksa = 'Enterprise Service Regional';
        $p1_mgr_pemeriksa = 'Manager Enterprise Regional';
        $p1_gm_witel = 'GM RGES';
      }
      if( $docs->f1_segmen === 'DGS' ){
        $p1_pemeriksa = 'Government Service Regional';
        $p1_mgr_pemeriksa = 'Manager Government Regional';
        $p1_gm_witel = 'GM RGES';
      }

      $harga_mrc = '';
      $harga_otc = '';
      if( $docs->p1_skema_bayar === 'otc' ){ $harga_otc = $docs->p1_estimasi_harga; }
      if( $docs->p1_skema_bayar === 'recurring' ){ $harga_mrc = $docs->p1_estimasi_harga; }

      $tgl_submit = new Carbon($docs->p0_tgl_submit);
      $tgl_submit = $tgl_submit->translatedFormat('d F Y');

      $templateProcessor = new TemplateProcessor(public_path() . '/basic_documents/basic_p0_doc.docx');
      $templateProcessor->setValues([
        'p0_nomor_p0' => $docs->p0_nomor_p0,
        'p0_tgl_submit' => $tgl_submit,
        'p1_pemeriksa' => $p1_pemeriksa,
        'p1_mgr_pemeriksa' => $p1_mgr_pemeriksa,
        'p1_gm_witel' => $p1_gm_witel,
        'f1_witel' =>  ucfirst((strtolower($docs->f1_witel))),
        'p1_tgl_p1' => $p1_tgl_p1,
        'p1_tgl_delivery' => $p1_tgl_delivery,
        'p1_tgl_doc_plggn' => $p1_tgl_doc_plggn,
        'p1_lokasi_instal' => $docs->p1_lokasi_instal,
        'p1_skema_bayar' => $docs->skema_bayar,
        'p1_skema_bisnis' => $docs->skema_bisnis,
        'p1_mekanisme_bayar' => $docs->mekanisme_bayar,
        'f1_nama_plggn' => $docs->f1_nama_plggn,
        'f1_judul_projek' => $docs->f1_judul_projek,
        'periode_bulan' => $docs->periode_bulan,
        'string_periode_bulan' => NumberToWords::transformNumber('id', (int)$docs->periode_bulan),
        'f1_mitra_id' => $docs->nama_mitra,
        'f1_nilai_kb' => $docs->f1_nilai_kb,
        'p1_dibuat_am' => $docs->p1_dibuat_am,
        'p1_diperiksa_manager' => $docs->p1_diperiksa_manager,
        'p1_disetujui_gm' => $docs->p1_disetujui_gm,
        'p1_paragraf' => $docs->p1_paragraf,
        'p1_aspek_strategis' => $docs->p1_aspek_strategis,
        'p1_lingkup_kerja' => $docs->p1_lingkup_kerja,
        'p1_slg' => $docs->p1_slg,
        'harga_mrc' => $harga_mrc,
        'harga_otc' => $harga_otc,
        'ppn' =>  RupiahFormat::currency( (float)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,',')))) * 0.11 ),
        'total_ppn' =>  RupiahFormat::currency( (float)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,',')))) + ( (float)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,',')))) * 0.11 ) ),
        'rev_total_telkom' => RupiahFormat::currency( (float)str_replace('.','',str_replace('Rp. ','',(strtok($docs->f1_nilai_kb,',')))) - (float)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,',')))) ),
        'p1_estimasi_harga' => $docs->p1_estimasi_harga,
        'string_p1_estimasi_harga' => RupiahFormat::terbilang( (int)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,',')))) ),
        'revenue' =>   RupiahFormat::currency( (int)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,','))))  * 0.1 ),
        'harga_ke_mitra' => RupiahFormat::currency( ( (float)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,',')))) - ( (int)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,','))))  * 0.1 ) ) )
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
        'form_obl.*',
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
        'mitras.nama_mitra'
      )->where('form_obl.id',$var_obl_id)->first();

      $docs_year = new Carbon($docs->created_at);
      $docs_year = $docs_year->translatedFormat('Y');

      $p1_tgl_p1 = new Carbon($docs->p1_tgl_p1);
      $p1_tgl_p1 = $p1_tgl_p1->translatedFormat('d F Y');
      $p1_tgl_delivery = new Carbon($docs->p1_tgl_delivery);
      $p1_tgl_delivery = $p1_tgl_delivery->translatedFormat('d F Y');
      $p1_tgl_doc_plggn = new Carbon($docs->p1_tgl_doc_plggn);
      $p1_tgl_doc_plggn = $p1_tgl_doc_plggn->translatedFormat('d F Y');

      $p1_pemeriksa = '';
      $p1_gm_witel = '';
      $p1_mgr_pemeriksa = '';
      if( $docs->f1_segmen === 'DBS' ){
        $p1_pemeriksa = 'Business Service Witel ' . ucfirst((strtolower($docs->f1_witel)));
        $p1_mgr_pemeriksa = 'Manager Business Service Witel ' . ucfirst((strtolower($docs->f1_witel)));
        $p1_gm_witel = 'GM Telkom Witel ' . ucfirst((strtolower($docs->f1_witel)));
      }
      if( $docs->f1_segmen === 'DES' ){
        $p1_pemeriksa = 'Enterprise Service Regional';
        $p1_mgr_pemeriksa = 'Manager Enterprise Regional';
        $p1_gm_witel = 'GM RGES';
      }
      if( $docs->f1_segmen === 'DGS' ){
        $p1_pemeriksa = 'Government Service Regional';
        $p1_mgr_pemeriksa = 'Manager Government Regional';
        $p1_gm_witel = 'GM RGES';
      }

      $harga_mrc = '';
      $harga_otc = '';
      if( $docs->p1_skema_bayar === 'otc' ){ $harga_otc = $docs->p1_estimasi_harga; }
      if( $docs->p1_skema_bayar === 'recurring' ){ $harga_mrc = $docs->p1_estimasi_harga; }

      $templateProcessor = new TemplateProcessor(public_path() . '/basic_documents/basic_p1_doc.docx');
      $templateProcessor->setValues([
        'p1_nomor_p1' => $docs->p1_nomor_p1,
        'p1_pemeriksa' => $p1_pemeriksa,
        'p1_mgr_pemeriksa' => $p1_mgr_pemeriksa,
        'p1_gm_witel' => $p1_gm_witel,
        'f1_witel' =>  ucfirst((strtolower($docs->f1_witel))),
        'p1_tgl_p1' => $p1_tgl_p1,
        'p1_tgl_delivery' => $p1_tgl_delivery,
        'p1_tgl_doc_plggn' => $p1_tgl_doc_plggn,
        'p1_lokasi_instal' => $docs->p1_lokasi_instal,
        'p1_skema_bayar' => $docs->skema_bayar,
        'p1_skema_bisnis' => $docs->skema_bisnis,
        'p1_mekanisme_bayar' => $docs->mekanisme_bayar,
        'f1_nama_plggn' => $docs->f1_nama_plggn,
        'f1_judul_projek' => $docs->f1_judul_projek,
        'periode_bulan' => $docs->periode_bulan,
        'string_periode_bulan' => NumberToWords::transformNumber('id', (int)$docs->periode_bulan),
        'f1_mitra_id' => $docs->nama_mitra,
        'f1_nilai_kb' => $docs->f1_nilai_kb,
        'p1_dibuat_am' => $docs->p1_dibuat_am,
        'p1_diperiksa_manager' => $docs->p1_diperiksa_manager,
        'p1_disetujui_gm' => $docs->p1_disetujui_gm,
        'p1_paragraf' => $docs->p1_paragraf,
        'p1_aspek_strategis' => $docs->p1_aspek_strategis,
        'p1_lingkup_kerja' => $docs->p1_lingkup_kerja,
        'p1_slg' => $docs->p1_slg,
        'harga_mrc' => $harga_mrc,
        'harga_otc' => $harga_otc,
        'ppn' =>  RupiahFormat::currency( (float)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,',')))) * 0.11 ),
        'total_ppn' =>  RupiahFormat::currency( (float)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,',')))) + ( (float)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,',')))) * 0.11 ) ),
        'rev_total_telkom' => RupiahFormat::currency( (float)str_replace('.','',str_replace('Rp. ','',(strtok($docs->f1_nilai_kb,',')))) - (float)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,',')))) ),
        'p1_estimasi_harga' => $docs->p1_estimasi_harga,
        'string_p1_estimasi_harga' => RupiahFormat::terbilang( (int)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,',')))) ),
        'revenue' =>   RupiahFormat::currency( (int)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,','))))  * 0.1 ),
        'harga_ke_mitra' => RupiahFormat::currency( ( (float)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,',')))) - ( (int)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p1_estimasi_harga,','))))  * 0.1 ) ) )
      ]);
      $filename = Auth::id() . '_' . (string) Str::uuid();
      $file_path = public_path().'/temp_saved_docs';
      $templateProcessor->saveAs($file_path.'/'.$filename.'.docx');
      $headers = array(
          'Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document',
      );
      return response()->download( $file_path . '/'.$filename.'.docx', $docs->f1_segmen . '_' . $docs->f1_folder . '_'. $docs_year . '_Form_P1.docx', $headers)->deleteFileAfterSend(true);
    }

    public function generateDocP2($var_obl_id){
      $docs = DB::connection('pgsql')->table('form_obl')->leftJoin('mitras','mitras.id','=','f1_mitra_id')
      ->select(
        'form_obl.id',
        'f1_nama_plggn',
        'f1_judul_projek',
        'mitras.nama_mitra',
        'f1_segmen',
        'f1_folder',
        'created_at',
        'p2_tgl_p2',
        'p2_tgl_justifikasi',
      )
      ->where('form_obl.id',$var_obl_id)->first();

      $docs_year = new Carbon($docs->created_at);
      $docs_year = $docs_year->translatedFormat('Y');
      $hari = new Carbon($docs->p2_tgl_p2);
      $hari = $hari->translatedFormat('l');
      $bulan = new Carbon($docs->p2_tgl_p2);
      $bulan = $bulan->translatedFormat('F');
      $tahun = new Carbon($docs->p2_tgl_p2);
      $tahun = $tahun->translatedFormat('Y');
      $tahun = NumberToWords::transformNumber('id',(int)$tahun);
      $tanggal = new Carbon($docs->p2_tgl_p2);
      $tanggal = $tanggal->translatedFormat('d');
      $tanggal = NumberToWords::transformNumber('id',(int)$tanggal);
      $p2_tgl_p2 = new Carbon($docs->p2_tgl_p2);
      $p2_tgl_p2 = $p2_tgl_p2->translatedFormat('d-m-Y');
      $p2_tgl_justifikasi = new Carbon($docs->p2_tgl_justifikasi);
      $p2_tgl_justifikasi = $p2_tgl_justifikasi->translatedFormat('d F Y');

      $templateProcessor = new TemplateProcessor(public_path() . '/basic_documents/basic_p2_doc.docx');
      $templateProcessor->setValues([
          'f1_nama_plggn' => $docs->f1_nama_plggn,
          'f1_judul_projek' => $docs->f1_judul_projek,
          'f1_mitra_id' => $docs->nama_mitra,
          'hari' => $hari,
          'tanggal' => ucwords($tanggal),
          'bulan' => $bulan,
          'tahun' => ucwords($tahun),
          'p2_tgl_p2' => $p2_tgl_p2,
          'p2_tgl_justifikasi' => $p2_tgl_justifikasi,
          'f1_segmen' => $docs->f1_segmen,
          'f1_folder' => $docs->f1_folder
      ]);
      $filename = Auth::id() . '_' . (string) Str::uuid();
      $file_path = public_path().'/temp_saved_docs';
      $templateProcessor->saveAs($file_path.'/'.$filename.'.docx');
      $headers = array(
          'Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document',
      );
      return response()->download( $file_path . '/'.$filename.'.docx', $docs->f1_segmen . '_' . $docs->f1_folder . '_'. $docs_year . '_Form_P2.docx', $headers)->deleteFileAfterSend(true);
    }

    public function generateDocP3($var_obl_id){
      $docs = DB::connection('pgsql')->table('form_obl')->leftJoin('mitras','mitras.id','=','f1_mitra_id')
      ->select(
        'form_obl.id',
        'f1_nama_plggn',
        'f1_judul_projek',
        'f1_witel',
        'f1_segmen',
        'f1_folder',
        'created_at',
        'mitras.nama_mitra',
        'p3_tgl_p3',
        'p3_takah_p3',
        'p3_tgl_rapat_pengadaan',
        'p3_pejabat_mitra_alamat'
      )
      ->where('form_obl.id',$var_obl_id)->first();
      $docs_year = new Carbon($docs->created_at);
      $docs_year = $docs_year->translatedFormat('Y');
      $p3_tgl_p3 = new Carbon($docs->p3_tgl_p3);
      $p3_tgl_p3 = $p3_tgl_p3->translatedFormat('d F Y');
      $p3_tgl_rapat_pengadaan = new Carbon($docs->p3_tgl_rapat_pengadaan);
      $p3_tgl_rapat_pengadaan = $p3_tgl_rapat_pengadaan->translatedFormat('d F Y');

      $templateProcessor = new TemplateProcessor(public_path() . '/basic_documents/basic_p3_doc.docx');
      $templateProcessor->setValues([
          'f1_nama_plggn' => $docs->f1_nama_plggn,
          'f1_judul_projek' => $docs->f1_judul_projek,
          'f1_mitra_id' => $docs->nama_mitra,
          'f1_segmen' => $docs->f1_segmen,
          'f1_folder' => $docs->f1_folder,
          'p3_tgl_p3' => $p3_tgl_p3,
          'p3_takah_p3' => $docs->p3_takah_p3,
          'p3_tgl_rapat_pengadaan' => $p3_tgl_rapat_pengadaan,
          'p3_pejabat_mitra_alamat' => $docs->p3_pejabat_mitra_alamat,
      ]);
      $filename = Auth::id() . '_' . (string) Str::uuid();
      $file_path = public_path().'/temp_saved_docs';
      $templateProcessor->saveAs($file_path.'/'.$filename.'.docx');
      $headers = array(
          'Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document',
      );
      return response()->download( $file_path . '/'.$filename.'.docx', $docs->f1_segmen . '_' . $docs->f1_folder . '_'. $docs_year . '_Form_P3.docx', $headers)->deleteFileAfterSend(true);
    }

    public function generateDocP4($var_obl_id){
      $docs = DB::connection('pgsql')->table('form_obl')->leftJoin('mitras','mitras.id','=','f1_mitra_id')
      ->select(
        'form_obl.id',
        'f1_nama_plggn',
        'f1_judul_projek',
        'f1_segmen',
        'f1_folder',
        'created_at',
        'mitras.nama_mitra',
        'p1_tgl_kontrak_mulai',
        'p1_tgl_kontrak_akhir',
        'p2_tgl_justifikasi',
        'p4_tgl_p4',
        'p4_waktu_layanan',
        'p4_slg',
        DB::raw("
        case
        when p4_skema_bisnis = 'sewa_murni' then 'Sewa Murni'
        when p4_skema_bisnis = 'sewa_beli' then 'Sewa Beli'
        when p4_skema_bisnis = 'beli_putus' then 'Pengadaan Beli Putus'
        else ''
        end as skema_bisnis"),
        DB::raw("case
        when p4_mekanisme_pembayaran = 'back_to_back' then 'Back To Back'
        when p4_mekanisme_pembayaran = 'non_back_to_back' then 'Non Back To Back'
        else ''
        end as mekanisme_pembayaran")
      )
      ->where('form_obl.id',$var_obl_id)->first();
      $docs_year = new Carbon($docs->created_at);
      $docs_year = $docs_year->translatedFormat('Y');

      $p1_tgl_kontrak_mulai = new Carbon($docs->p1_tgl_kontrak_mulai);
      $p1_tgl_kontrak_mulai = $p1_tgl_kontrak_mulai->translatedFormat('d F Y');
      $p1_tgl_kontrak_akhir = new Carbon($docs->p1_tgl_kontrak_akhir);
      $p1_tgl_kontrak_akhir = $p1_tgl_kontrak_akhir->translatedFormat('d F Y');
      $p2_tgl_justifikasi = new Carbon($docs->p2_tgl_justifikasi);
      $p2_tgl_justifikasi = $p2_tgl_justifikasi->translatedFormat('d F Y');
      $p4_tgl_p4 = new Carbon($docs->p4_tgl_p4);
      $p4_tgl_p4 = $p4_tgl_p4->translatedFormat('d F Y');
      $p4_waktu_layanan = new Carbon($docs->p4_waktu_layanan);
      $p4_waktu_layanan = $p4_waktu_layanan->translatedFormat('d F Y');

      $templateProcessor = new TemplateProcessor(public_path() . '/basic_documents/basic_p4_doc.docx');
      $templateProcessor->setValues([
          'f1_nama_plggn' => $docs->f1_nama_plggn,
          'f1_judul_projek' => $docs->f1_judul_projek,
          'f1_segmen' => $docs->f1_segmen,
          'f1_folder' => $docs->f1_folder,
          'p1_tgl_kontrak_mulai' => $p1_tgl_kontrak_mulai,
          'p1_tgl_kontrak_akhir' => $p1_tgl_kontrak_akhir,
          'p2_tgl_justifikasi' => $p2_tgl_justifikasi,
          'p4_tgl_p4' => $p4_tgl_p4,
          'p4_waktu_layanan' => $p4_waktu_layanan,
          'p4_slg' => $docs->p4_slg,
          'p4_skema_bisnis' => $docs->skema_bisnis,
          'p4_mekanisme_pembayaran' => $docs->mekanisme_pembayaran
      ]);
      $filename = Auth::id() . '_' . (string) Str::uuid();
      $file_path = public_path().'/temp_saved_docs';
      $templateProcessor->saveAs($file_path.'/'.$filename.'.docx');
      $headers = array(
          'Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document',
      );
      return response()->download( $file_path . '/'.$filename.'.docx', $docs->f1_segmen . '_' . $docs->f1_folder . '_'. $docs_year . '_Form_P4.docx', $headers)->deleteFileAfterSend(true);
    }

    public function generateDocP5($var_obl_id){
      $docs = DB::connection('pgsql')->table('form_obl')->leftJoin('mitras','mitras.id','=','f1_mitra_id')
      ->select(
        'form_obl.id',
        'f1_nama_plggn',
        'f1_judul_projek',
        'f1_segmen',
        'f1_folder',
        'created_at',
        'mitras.nama_mitra',
        'p4_tgl_p4',
        'p5_tgl_p5',
        'p5_harga_penawaran'
      )
      ->where('form_obl.id',$var_obl_id)->first();
      $docs_year = new Carbon($docs->created_at);
      $docs_year = $docs_year->translatedFormat('Y');

      $p4_tgl_p4 = new Carbon($docs->p4_tgl_p4);
      $p4_tgl_p4 = $p4_tgl_p4->translatedFormat('d F Y');
      $p5_tgl_p5 = new Carbon($docs->p5_tgl_p5);
      $p5_tgl_p5 = $p5_tgl_p5->translatedFormat('d F Y');
      $hari = new Carbon($docs->p5_tgl_p5);
      $hari = $hari->translatedFormat('l');
      $tanggal = new Carbon($docs->p5_tgl_p5);
      $tanggal = $tanggal->translatedFormat('d');
      $tanggal = NumberToWords::transformNumber('id',(int)$tanggal);
      $bulan = new Carbon($docs->p5_tgl_p5);
      $bulan = $bulan->translatedFormat('F');
      $tahun = new Carbon($docs->p5_tgl_p5);
      $tahun = $tahun->translatedFormat('Y');
      $tahun = NumberToWords::transformNumber('id',(int)$tahun);

      $templateProcessor = new TemplateProcessor(public_path() . '/basic_documents/basic_p5_doc.docx');
      $templateProcessor->setValues([
          'f1_nama_plggn' => $docs->f1_nama_plggn,
          'f1_judul_projek' => $docs->f1_judul_projek,
          'f1_segmen' => $docs->f1_segmen,
          'f1_folder' => $docs->f1_folder,
          'p4_tgl_p4' => $p4_tgl_p4,
          'p5_tgl_p5' => $p5_tgl_p5,
          'hari' => $hari,
          'tanggal' => ucwords($tanggal),
          'bulan' => $bulan,
          'tahun' => ucwords($tahun),
          'p5_harga_penawaran' => $docs->p5_harga_penawaran,
          'string_p5_harga_penawaran' => RupiahFormat::terbilang( (int)str_replace('.','',str_replace('Rp. ','',(strtok($docs->p5_harga_penawaran,',')))) )
      ]);
      $filename = Auth::id() . '_' . (string) Str::uuid();
      $file_path = public_path().'/temp_saved_docs';
      $templateProcessor->saveAs($file_path.'/'.$filename.'.docx');
      $headers = array(
          'Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document',
      );
      return response()->download( $file_path . '/'.$filename.'.docx', $docs->f1_segmen . '_' . $docs->f1_folder . '_'. $docs_year . '_Form_P5.docx', $headers)->deleteFileAfterSend(true);
    }

    public function generateDocP6($var_obl_id){
      $docs = DB::connection('pgsql')->table('form_obl')->leftJoin('mitras','mitras.id','=','f1_mitra_id')
      ->select(
        'form_obl.id',
        'f1_nama_plggn',
        'f1_judul_projek',
        'f1_segmen',
        'f1_folder',
        'created_at',
        'mitras.nama_mitra',
        'p6_tgl_p6',
        'p4_tgl_p4',
        DB::raw("
        case
        when p4_skema_bisnis = 'sewa_murni' then 'Sewa Murni'
        when p4_skema_bisnis = 'sewa_beli' then 'Sewa Beli'
        when p4_skema_bisnis = 'beli_putus' then 'Pengadaan Beli Putus'
        else ''
        end as skema_bisnis"),
        DB::raw("case
        when p4_mekanisme_pembayaran = 'back_to_back' then 'Back To Back'
        when p4_mekanisme_pembayaran = 'non_back_to_back' then 'Non Back To Back'
        else ''
        end as mekanisme_pembayaran"),
        'p4_waktu_layanan',
        'p4_slg',
        'p5_harga_penawaran',
        'p6_harga_negosiasi',
        'p1_tgl_kontrak_mulai',
        'p1_tgl_kontrak_akhir',
        DB::raw("case
        when p1_pemeriksa = 'business_service' then 'BS'
        when p1_pemeriksa = 'government_service' then 'GS'
        when p1_pemeriksa = 'enterprise_service' then 'ES'
        else ''
        end as singkatan_p1_pemeriksa"),
        DB::raw("case
        when f1_witel = 'BALIKPAPAN' then 'Balikpapan'
        when f1_witel = 'KALBAR' then 'Kalimantan Barat'
        when f1_witel = 'KALTENG' then 'Kalimantan Tengah'
        when f1_witel = 'KALSEL' then 'Kalimantan Selatan'
        when f1_witel = 'KALTARA' then 'Kalimantan Utara'
        when f1_witel = 'SAMARINDA' then 'Samarinda'
        else ''
        end as witel")
      )
      ->where('form_obl.id',$var_obl_id)->first();
      $docs_year = new Carbon($docs->created_at);
      $docs_year = $docs_year->translatedFormat('Y');

      $p6_tgl_p6 = new Carbon($docs->p6_tgl_p6);
      $p6_tgl_p6 = $p6_tgl_p6->translatedFormat('d F Y');
      $hari = new Carbon($docs->p6_tgl_p6);
      $hari = $hari->translatedFormat('l');
      $tanggal = new Carbon($docs->p6_tgl_p6);
      $tanggal = $tanggal->translatedFormat('d');
      $tanggal = NumberToWords::transformNumber('id',(int)$tanggal);
      $bulan = new Carbon($docs->p6_tgl_p6);
      $bulan = $bulan->translatedFormat('F');
      $tahun = new Carbon($docs->p6_tgl_p6);
      $tahun = $tahun->translatedFormat('Y');
      $tahun = NumberToWords::transformNumber('id',(int)$tahun);
      $p4_tgl_p4 = new Carbon($docs->p4_tgl_p4);
      $p4_tgl_p4 = $p4_tgl_p4->translatedFormat('d F Y');
      $p4_waktu_layanan = new Carbon($docs->p4_waktu_layanan);
      $p4_waktu_layanan = $p4_waktu_layanan->translatedFormat('d F Y');
      $p1_tgl_kontrak_mulai = new Carbon($docs->p1_tgl_kontrak_mulai);
      $p1_tgl_kontrak_mulai = $p1_tgl_kontrak_mulai->translatedFormat('d F Y');
      $p1_tgl_kontrak_akhir = new Carbon($docs->p1_tgl_kontrak_akhir);
      $p1_tgl_kontrak_akhir = $p1_tgl_kontrak_akhir->translatedFormat('d F Y');

      $templateProcessor = new TemplateProcessor(public_path() . '/basic_documents/basic_p6_doc.docx');
      $templateProcessor->setValues([
          'f1_nama_plggn' => $docs->f1_nama_plggn,
          'f1_judul_projek' => $docs->f1_judul_projek,
          'f1_mitra_id' => $docs->nama_mitra,
          'f1_segmen' => $docs->f1_segmen,
          'f1_folder' => $docs->f1_folder,
          'p6_tgl_p6' => $p6_tgl_p6,
          'hari' => $hari,
          'tanggal' => ucwords($tanggal),
          'bulan' => $bulan,
          'tahun' => ucwords($tahun),
          'p4_tgl_p4' => $p4_tgl_p4,
          'p4_skema_bisnis' => $docs->skema_bisnis,
          'p4_mekanisme_pembayaran' => $docs->mekanisme_pembayaran,
          'p4_waktu_layanan' => $p4_waktu_layanan,
          'p4_slg' => $docs->p4_slg,
          'p5_harga_penawaran' => $docs->p5_harga_penawaran,
          'string_p5_harga_penawaran' => RupiahFormat::terbilang( (int)str_replace('.','',str_replace('Rp. ','',(strtok( $docs->p5_harga_penawaran,',')))) ),
          'p6_harga_negosiasi' => $docs->p6_harga_negosiasi,
          'string_p6_harga_negosiasi' => RupiahFormat::terbilang( (int)str_replace('.','',str_replace('Rp. ','',(strtok( $docs->p6_harga_negosiasi,',')))) ),
          'p1_tgl_kontrak_mulai' => $p1_tgl_kontrak_mulai,
          'p1_tgl_kontrak_akhir' => $p1_tgl_kontrak_akhir,
          'singkatan_p1_pemeriksa' => $docs->singkatan_p1_pemeriksa,
          'f1_witel' => $docs->witel
      ]);
      $filename = Auth::id() . '_' . (string) Str::uuid();
      $file_path = public_path().'/temp_saved_docs';
      $templateProcessor->saveAs($file_path.'/'.$filename.'.docx');
      $headers = array(
          'Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document',
      );
      return response()->download( $file_path . '/'.$filename.'.docx', $docs->f1_segmen . '_' . $docs->f1_folder . '_'. $docs_year . '_Form_P6.docx', $headers)->deleteFileAfterSend(true);
    }

    public function generateDocP7($var_obl_id){
      $docs = DB::connection('pgsql')->table('form_obl')->leftJoin('mitras','mitras.id','=','f1_mitra_id')
      ->select(
        'form_obl.id',
        'f1_nama_plggn',
        'f1_judul_projek',
        'f1_segmen',
        'f1_folder',
        'created_at',
        'mitras.nama_mitra',
        DB::raw("case
        when p1_pemeriksa = 'business_service' then 'BS'
        when p1_pemeriksa = 'government_service' then 'GS'
        when p1_pemeriksa = 'enterprise_service' then 'ES'
        else ''
        end as singkatan_p1_pemeriksa"),
        DB::raw("case
        when f1_witel = 'BALIKPAPAN' then 'Balikpapan'
        when f1_witel = 'KALBAR' then 'Kalimantan Barat'
        when f1_witel = 'KALTENG' then 'Kalimantan Tengah'
        when f1_witel = 'KALSEL' then 'Kalimantan Selatan'
        when f1_witel = 'KALTARA' then 'Kalimantan Utara'
        when f1_witel = 'SAMARINDA' then 'Samarinda'
        else ''
        end as witel"),
        DB::raw("
        case
        when p4_skema_bisnis = 'sewa_murni' then 'Sewa Murni'
        when p4_skema_bisnis = 'sewa_beli' then 'Sewa Beli'
        when p4_skema_bisnis = 'beli_putus' then 'Pengadaan Beli Putus'
        else ''
        end as skema_bisnis"),
        DB::raw("case
        when p4_mekanisme_pembayaran = 'back_to_back' then 'Back To Back'
        when p4_mekanisme_pembayaran = 'non_back_to_back' then 'Non Back To Back'
        else ''
        end as mekanisme_pembayaran"),
        'p4_waktu_layanan',
        'p4_slg',
        'p1_tgl_kontrak_mulai',
        'p1_tgl_kontrak_akhir',
        'p3_takah_p3',
        'p3_tgl_p3',
        'p3_pejabat_mitra_alamat',
        'p4_tgl_p4',
        'p5_tgl_p5',
        'p6_tgl_p6',
        'p7_tgl_p7',
        'p7_takah_p7',
        'p7_harga_pekerjaan',
        DB::raw("case
        when p7_skema_bayar = 'otc' then 'One Time Charge (OTC)'
        when p7_skema_bayar = 'recurring' then 'Bulanan'
        when p7_skema_bayar = 'termin' then 'Termin'
        when p7_skema_bayar = 'campuran' then 'Campuran'
        else ''
        end as skema_bayar")
      )
      ->where('form_obl.id',$var_obl_id)->first();
      $docs_year = new Carbon($docs->created_at);
      $docs_year = $docs_year->translatedFormat('Y');

      $p1_tgl_kontrak_mulai = new Carbon($docs->p1_tgl_kontrak_mulai);
      $p1_tgl_kontrak_mulai = $p1_tgl_kontrak_mulai->translatedFormat('d F Y');
      $p1_tgl_kontrak_akhir = new Carbon($docs->p1_tgl_kontrak_akhir);
      $p1_tgl_kontrak_akhir = $p1_tgl_kontrak_akhir->translatedFormat('d F Y');
      $p4_tgl_p4 = new Carbon($docs->p4_tgl_p4);
      $p4_tgl_p4 = $p4_tgl_p4->translatedFormat('d F Y');
      $p4_waktu_layanan = new Carbon($docs->p4_waktu_layanan);
      $p4_waktu_layanan = $p4_waktu_layanan->translatedFormat('d F Y');
      $p5_tgl_p5 = new Carbon($docs->p5_tgl_p5);
      $p5_tgl_p5 = $p5_tgl_p5->translatedFormat('d F Y');
      $p6_tgl_p6 = new Carbon($docs->p6_tgl_p6);
      $p6_tgl_p6 = $p6_tgl_p6->translatedFormat('d F Y');
      $p7_tgl_p7 = new Carbon($docs->p7_tgl_p7);
      $p7_tgl_p7 = $p7_tgl_p7->translatedFormat('d F Y');
      $p3_tgl_p3 = new Carbon($docs->p3_tgl_p3);
      $p3_tgl_p3 = $p3_tgl_p3->translatedFormat('d F Y');

      $templateProcessor = new TemplateProcessor(public_path() . '/basic_documents/basic_p7_doc.docx');
      $templateProcessor->setValues([
          'f1_nama_plggn' => $docs->f1_nama_plggn,
          'f1_judul_projek' => $docs->f1_judul_projek,
          'f1_mitra_id' => $docs->nama_mitra,
          'f1_segmen' => $docs->f1_segmen,
          'f1_folder' => $docs->f1_folder,
          'f1_witel' => $docs->witel,
          'p1_tgl_kontrak_mulai' => $p1_tgl_kontrak_mulai,
          'p1_tgl_kontrak_akhir' => $p1_tgl_kontrak_akhir,
          'singkatan_p1_pemeriksa' => $docs->singkatan_p1_pemeriksa,
          'p3_takah_p3' => $docs->p3_takah_p3,
          'p3_tgl_p3' => $p3_tgl_p3,
          'p3_pejabat_mitra_alamat' => $docs->p3_pejabat_mitra_alamat,
          'p4_tgl_p4' => $p4_tgl_p4,
          'p4_waktu_layanan' => $p4_waktu_layanan,
          'p4_slg' => $docs->p4_slg,
          'p4_skema_bisnis' => $docs->skema_bisnis,
          'p4_mekanisme_pembayaran' => $docs->mekanisme_pembayaran,
          'p5_tgl_p5' => $p5_tgl_p5,
          'p6_tgl_p6' => $p6_tgl_p6,
          'p7_tgl_p7' => $p7_tgl_p7,
          'p7_takah_p7' => $docs->p7_takah_p7,
          'p7_harga_pekerjaan' => $docs->p7_harga_pekerjaan,
          'string_p7_harga_pekerjaan' => RupiahFormat::terbilang( (int)str_replace('.','',str_replace('Rp. ','',(strtok( $docs->p7_harga_pekerjaan,',')))) ),
          'p7_skema_bayar' => $docs->skema_bayar
      ]);
      $filename = Auth::id() . '_' . (string) Str::uuid();
      $file_path = public_path().'/temp_saved_docs';
      $templateProcessor->saveAs($file_path.'/'.$filename.'.docx');
      $headers = array(
          'Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document',
      );
      return response()->download( $file_path . '/'.$filename.'.docx', $docs->f1_segmen . '_' . $docs->f1_folder . '_'. $docs_year . '_Form_P7.docx', $headers)->deleteFileAfterSend(true);
    }

    public function generateDocP8($var_obl_id){
      $docs = DB::connection('pgsql')->table('form_obl')->leftJoin('mitras','mitras.id','=','f1_mitra_id')
      ->select(
        'form_obl.id',
        'f1_nama_plggn',
        'f1_judul_projek',
        'f1_segmen',
        'f1_folder',
        'created_at',
        'mitras.nama_mitra',
        DB::raw("case
        when p1_pemeriksa = 'business_service' then 'BS'
        when p1_pemeriksa = 'government_service' then 'GS'
        when p1_pemeriksa = 'enterprise_service' then 'ES'
        else ''
        end as singkatan_p1_pemeriksa"),
        DB::raw("case
        when f1_witel = 'BALIKPAPAN' then 'Balikpapan'
        when f1_witel = 'KALBAR' then 'Kalimantan Barat'
        when f1_witel = 'KALTENG' then 'Kalimantan Tengah'
        when f1_witel = 'KALSEL' then 'Kalimantan Selatan'
        when f1_witel = 'KALTARA' then 'Kalimantan Utara'
        when f1_witel = 'SAMARINDA' then 'Samarinda'
        else ''
        end as witel"),
        DB::raw("
        case
        when p4_skema_bisnis = 'sewa_murni' then 'Sewa Murni'
        when p4_skema_bisnis = 'sewa_beli' then 'Sewa Beli'
        when p4_skema_bisnis = 'beli_putus' then 'Pengadaan Beli Putus'
        else ''
        end as skema_bisnis"),
        DB::raw("case
        when p4_mekanisme_pembayaran = 'back_to_back' then 'Back To Back'
        when p4_mekanisme_pembayaran = 'non_back_to_back' then 'Non Back To Back'
        else ''
        end as mekanisme_pembayaran"),
        'p4_waktu_layanan',
        'p4_slg',
        'p1_tgl_kontrak_mulai',
        'p1_tgl_kontrak_akhir',
        'p3_pejabat_mitra_alamat',
        'p6_tgl_p6',
        'p8_tgl_p8',
        'p8_takah_p8',
        'p7_tgl_p7',
        'p7_takah_p7',
        'p7_harga_pekerjaan',
        DB::raw("case
        when p7_skema_bayar = 'otc' then 'One Time Charge (OTC)'
        when p7_skema_bayar = 'recurring' then 'Bulanan'
        when p7_skema_bayar = 'termin' then 'Termin'
        when p7_skema_bayar = 'campuran' then 'Campuran'
        else ''
        end as skema_bayar")
      )
      ->where('form_obl.id',$var_obl_id)->first();
      $docs_year = new Carbon($docs->created_at);
      $docs_year = $docs_year->translatedFormat('Y');

      $p1_tgl_kontrak_mulai = new Carbon($docs->p1_tgl_kontrak_mulai);
      $p1_tgl_kontrak_mulai = $p1_tgl_kontrak_mulai->translatedFormat('d F Y');
      $p1_tgl_kontrak_akhir = new Carbon($docs->p1_tgl_kontrak_akhir);
      $p1_tgl_kontrak_akhir = $p1_tgl_kontrak_akhir->translatedFormat('d F Y');
      $p4_waktu_layanan = new Carbon($docs->p4_waktu_layanan);
      $p4_waktu_layanan = $p4_waktu_layanan->translatedFormat('d F Y');
      $p6_tgl_p6 = new Carbon($docs->p6_tgl_p6);
      $p6_tgl_p6 = $p6_tgl_p6->translatedFormat('d F Y');
      $p7_tgl_p7 = new Carbon($docs->p7_tgl_p7);
      $p7_tgl_p7 = $p7_tgl_p7->translatedFormat('d F Y');
      $p8_tgl_p8 = new Carbon($docs->p8_tgl_p8);
      $p8_tgl_p8 = $p8_tgl_p8->translatedFormat('d F Y');

      $templateProcessor = new TemplateProcessor(public_path() . '/basic_documents/basic_p8_doc.docx');
      $templateProcessor->setValues([
          'f1_nama_plggn' => $docs->f1_nama_plggn,
          'f1_judul_projek' => $docs->f1_judul_projek,
          'f1_mitra_id' => $docs->nama_mitra,
          'f1_segmen' => $docs->f1_segmen,
          'f1_folder' => $docs->f1_folder,
          'f1_witel' => $docs->witel,
          'p1_tgl_kontrak_mulai' => $p1_tgl_kontrak_mulai,
          'p1_tgl_kontrak_akhir' => $p1_tgl_kontrak_akhir,
          'singkatan_p1_pemeriksa' => $docs->singkatan_p1_pemeriksa,
          'p3_pejabat_mitra_alamat' => $docs->p3_pejabat_mitra_alamat,
          'p4_waktu_layanan' => $p4_waktu_layanan,
          'p4_slg' => $docs->p4_slg,
          'p4_skema_bisnis' => $docs->skema_bisnis,
          'p4_mekanisme_pembayaran' => $docs->mekanisme_pembayaran,
          'p6_tgl_p6' => $p6_tgl_p6,
          'p7_tgl_p7' => $p7_tgl_p7,
          'p7_takah_p7' => $docs->p7_takah_p7,
          'p8_tgl_p8' => $p8_tgl_p8,
          'p8_takah_p8' => $docs->p8_takah_p8,
          'p7_harga_pekerjaan' => $docs->p7_harga_pekerjaan,
          'string_p7_harga_pekerjaan' => RupiahFormat::terbilang( (int)str_replace('.','',str_replace('Rp. ','',(strtok( $docs->p7_harga_pekerjaan,',')))) ),
          'p7_skema_bayar' => $docs->skema_bayar
      ]);
      $filename = Auth::id() . '_' . (string) Str::uuid();
      $file_path = public_path().'/temp_saved_docs';
      $templateProcessor->saveAs($file_path.'/'.$filename.'.docx');
      $headers = array(
          'Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document',
      );
      return response()->download( $file_path . '/'.$filename.'.docx', $docs->f1_segmen . '_' . $docs->f1_folder . '_'. $docs_year . '_Form_P8.docx', $headers)->deleteFileAfterSend(true);
    }

    public function generateDocWO($var_obl_id){
      $docs = DB::connection('pgsql')->table('form_obl')->leftJoin('mitras','mitras.id','=','f1_mitra_id')
      ->select(
        'form_obl.id',
        'f1_nama_plggn',
        'f1_judul_projek',
        'f1_segmen',
        'f1_folder',
        'created_at',
        'mitras.nama_mitra',
        DB::raw("case
        when p1_pemeriksa = 'business_service' then 'Business Service'
        when p1_pemeriksa = 'government_service' then 'Government Service'
        when p1_pemeriksa = 'enterprise_service' then 'Enterprise Service'
        else ''
        end as pemeriksa"),
        'p1_tgl_p1',
        'f1_masa_layanan_hari',
        'f1_masa_layanan_bulan',
        'f1_masa_layanan_tahun',
        DB::raw("case
        when f1_witel = 'BALIKPAPAN' then 'Balikpapan'
        when f1_witel = 'KALBAR' then 'Kalimantan Barat'
        when f1_witel = 'KALTENG' then 'Kalimantan Tengah'
        when f1_witel = 'KALSEL' then 'Kalimantan Selatan'
        when f1_witel = 'KALTARA' then 'Kalimantan Utara'
        when f1_witel = 'SAMARINDA' then 'Samarinda'
        else ''
        end as witel"),
        DB::raw("case
        when f1_jenis_kontrak = 'perpanjangan' then 'Amandemen'
        when f1_jenis_kontrak = 'baru' then 'Pasang Baru'
        else ''
        end as jenis_kontrak"),
        'f1_no_kfs_spk',
        'p3_pejabat_mitra_alamat',
        DB::raw("case
        when f1_skema_bayar = 'otc' then 'One Time Charge (OTC)'
        when f1_skema_bayar = 'recurring' then 'Bulanan'
        when f1_skema_bayar = 'termin' then 'Termin'
        when f1_skema_bayar = 'otc_recurring' then 'Campuran'
        else ''
        end as skema_bayar"),
        'wo_tgl_wo',
        'wo_tgl_fo',
        'wo_takah_wo',
        'wo_jumlah_layanan',
        'wo_harga_ke_plggn',
        'wo_onetime_charge_plggn',
        'wo_monthly_plggn',
        'wo_onetime_charge_telkom',
        'wo_monthly_telkom',
        'wo_onetime_charge_mitra',
        'wo_monthly_mitra',
      )
      ->where('form_obl.id',$var_obl_id)->first();
      $docs_year = new Carbon($docs->created_at);
      $docs_year = $docs_year->translatedFormat('Y');
      $p1_tgl_p1 = new Carbon($docs->p1_tgl_p1);
      $p1_tgl_p1 = $p1_tgl_p1->translatedFormat('d F Y');
      $wo_tgl_wo = new Carbon($docs->wo_tgl_wo);
      $wo_tgl_wo = $wo_tgl_wo->translatedFormat('d F Y');
      $tahun = new Carbon($docs->wo_tgl_wo);
      $tahun = $tahun->translatedFormat('Y');
      $wo_tgl_fo = new Carbon($docs->wo_tgl_fo);
      $wo_tgl_fo = $wo_tgl_fo->translatedFormat('d F Y');
      $masa_layanan = '';
      if($docs->f1_masa_layanan_tahun){ $masa_layanan = $masa_layanan . $docs->f1_masa_layanan_tahun .' Tahun '; }
      if($docs->f1_masa_layanan_bulan){ $masa_layanan = $masa_layanan . $docs->f1_masa_layanan_bulan .' Bulan '; }
      if($docs->f1_masa_layanan_hari){ $masa_layanan = $masa_layanan . $docs->f1_masa_layanan_hari .' Hari '; }

      $templateProcessor = new TemplateProcessor(public_path() . '/basic_documents/basic_wo_doc.docx');
      $templateProcessor->setValues([
          'f1_nama_plggn' => $docs->f1_nama_plggn,
          'f1_judul_projek' => $docs->f1_judul_projek,
          'f1_mitra_id' => $docs->nama_mitra,
          'f1_segmen' => $docs->f1_segmen,
          'f1_folder' => $docs->f1_folder,
          'p1_pemeriksa' => $docs->pemeriksa,
          'p1_tgl_p1' => $p1_tgl_p1,
          'masa_layanan' => $masa_layanan,
          'f1_witel' => $docs->witel,
          'f1_jenis_kontrak' => $docs->jenis_kontrak,
          'f1_no_kfs_spk' => $docs->f1_no_kfs_spk,
          'f1_skema_bayar' => $docs->skema_bayar,
          'p3_pejabat_mitra_alamat' => $docs->p3_pejabat_mitra_alamat,
          'wo_tgl_wo' => $wo_tgl_wo,
          'tahun' => $tahun,
          'wo_tgl_fo' => $wo_tgl_fo,
          'wo_takah_wo' => $docs->wo_takah_wo,
          'wo_jumlah_layanan' => $docs->wo_jumlah_layanan,
          'wo_harga_ke_plggn' => $docs->wo_harga_ke_plggn,
          'wo_onetime_charge_plggn' => $docs->wo_onetime_charge_plggn,
          'wo_monthly_plggn' => $docs->wo_monthly_plggn,
          'wo_onetime_charge_telkom' => $docs->wo_onetime_charge_telkom,
          'wo_monthly_telkom' => $docs->wo_monthly_telkom,
          'wo_onetime_charge_mitra' => $docs->wo_onetime_charge_mitra,
          'wo_monthly_mitra' => $docs->wo_monthly_mitra,
          'total_hak_telkom' => RupiahFormat::currency( ( (int)str_replace('.','',str_replace('Rp. ','',(strtok( $docs->wo_onetime_charge_telkom,',')))) ) + ( (int)str_replace('.','',str_replace('Rp. ','',(strtok( $docs->wo_monthly_telkom,',')))) ) ),
          'total_hak_mitra' => RupiahFormat::currency( ( (int)str_replace('.','',str_replace('Rp. ','',(strtok( $docs->wo_onetime_charge_mitra,',')))) ) + ( (int)str_replace('.','',str_replace('Rp. ','',(strtok( $docs->wo_monthly_mitra,',')))) ) ),
      ]);
      $filename = Auth::id() . '_' . (string) Str::uuid();
      $file_path = public_path().'/temp_saved_docs';
      $templateProcessor->saveAs($file_path.'/'.$filename.'.docx');
      $headers = array(
          'Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document',
      );
      return response()->download( $file_path . '/'.$filename.'.docx', $docs->f1_segmen . '_' . $docs->f1_folder . '_'. $docs_year . '_Kontrak_WO.docx', $headers)->deleteFileAfterSend(true);
    }


    public function generateDocSP($var_obl_id){
      $docs = DB::connection('pgsql')->table('form_obl')->leftJoin('mitras','mitras.id','=','f1_mitra_id')
      ->select(
        'form_obl.id',
        'f1_nama_plggn',
        'f1_judul_projek',
        'f1_segmen',
        'f1_folder',
        'created_at',
        'mitras.nama_mitra',
        DB::raw("case
        when f1_witel = 'BALIKPAPAN' then 'Balikpapan'
        when f1_witel = 'KALBAR' then 'Kalimantan Barat'
        when f1_witel = 'KALTENG' then 'Kalimantan Tengah'
        when f1_witel = 'KALSEL' then 'Kalimantan Selatan'
        when f1_witel = 'KALTARA' then 'Kalimantan Utara'
        when f1_witel = 'SAMARINDA' then 'Samarinda'
        else ''
        end as witel"),
        'f1_no_kfs_spk',
        'f2_tgl_p1',
        DB::raw("case
        when f1_skema_bayar = 'otc' then 'One Time Charge (OTC)'
        when f1_skema_bayar = 'recurring' then 'Bulanan'
        when f1_skema_bayar = 'termin' then 'Termin'
        when f1_skema_bayar = 'otc_recurring' then 'Campuran'
        else ''
        end as skema_bayar"),
        DB::raw("case
        when p1_pemeriksa = 'business_service' then 'Business'
        when p1_pemeriksa = 'government_service' then 'Government'
        when p1_pemeriksa = 'enterprise_service' then 'Enterprise'
        else ''
        end as pemeriksa"),
        DB::raw("case
        when p1_pemeriksa = 'business_service' then 'BS'
        when p1_pemeriksa = 'government_service' then 'GS'
        when p1_pemeriksa = 'enterprise_service' then 'ES'
        else ''
        end as singkatan_p1_pemeriksa"),
        DB::raw("
        case
        when p4_skema_bisnis = 'sewa_murni' then 'Sewa Murni'
        when p4_skema_bisnis = 'sewa_beli' then 'Sewa Beli'
        when p4_skema_bisnis = 'beli_putus' then 'Pengadaan Beli Putus'
        else ''
        end as skema_bisnis"),
        DB::raw("case
        when p4_mekanisme_pembayaran = 'back_to_back' then 'Back To Back'
        when p4_mekanisme_pembayaran = 'non_back_to_back' then 'Non Back To Back'
        else ''
        end as mekanisme_pembayaran"),
        DB::raw("case
        when p7_skema_bayar = 'otc' then 'One Time Charge (OTC)'
        when p7_skema_bayar = 'recurring' then 'Bulanan'
        when p7_skema_bayar = 'termin' then 'Termin'
        when p7_skema_bayar = 'campuran' then 'OTC Recurring'
        else ''
        end as skema_byr"),
        'p1_tgl_kontrak_mulai',
        'p1_tgl_kontrak_akhir',
        'p3_pejabat_mitra_alamat',
        'p3_pejabat_mitra_telepon',
        'p4_waktu_layanan',
        'p4_slg',
        'p7_takah_p7',
        'p7_tgl_p7',
        'p7_harga_pekerjaan',
        'sp_takah_sp',
        'sp_tgl_sp'
      )
      ->where('form_obl.id',$var_obl_id)->first();
      $docs_year = new Carbon($docs->created_at);
      $docs_year = $docs_year->translatedFormat('Y');

      $f2_tgl_p1 = new Carbon($docs->f2_tgl_p1);
      $f2_tgl_p1 = $f2_tgl_p1->translatedFormat('d F Y');
      $p1_tgl_kontrak_mulai = new Carbon($docs->p1_tgl_kontrak_mulai);
      $p1_tgl_kontrak_mulai = $p1_tgl_kontrak_mulai->translatedFormat('d F Y');
      $p1_tgl_kontrak_akhir = new Carbon($docs->p1_tgl_kontrak_akhir);
      $p1_tgl_kontrak_akhir = $p1_tgl_kontrak_akhir->translatedFormat('d F Y');
      $p4_waktu_layanan = new Carbon($docs->p4_waktu_layanan);
      $p4_waktu_layanan = $p4_waktu_layanan->translatedFormat('d F Y');
      $p7_tgl_p7 = new Carbon($docs->p7_tgl_p7);
      $p7_tgl_p7 = $p7_tgl_p7->translatedFormat('d F Y');
      $sp_tgl_sp = new Carbon($docs->sp_tgl_sp);
      $sp_tgl_sp = $sp_tgl_sp->translatedFormat('d F Y');

      $templateProcessor = new TemplateProcessor(public_path() . '/basic_documents/basic_sp_doc.docx');
      $templateProcessor->setValues([
          'f1_nama_plggn' => $docs->f1_nama_plggn,
          'f1_judul_projek' => $docs->f1_judul_projek,
          'f1_mitra_id' => $docs->nama_mitra,
          'f1_segmen' => $docs->f1_segmen,
          'f1_folder' => $docs->f1_folder,
          'f1_no_kfs_spk' => $docs->f1_no_kfs_spk,
          'f2_tgl_p1' => $f2_tgl_p1,
          'f1_skema_bayar' => $docs->skema_bayar,
          'f1_witel' => $docs->witel,
          'singkatan_p1_pemeriksa' => $docs->singkatan_p1_pemeriksa,
          'p1_pemeriksa' => $docs->pemeriksa,
          'p1_tgl_kontrak_mulai' => $p1_tgl_kontrak_mulai,
          'p1_tgl_kontrak_akhir' => $p1_tgl_kontrak_akhir,
          'p3_pejabat_mitra_alamat' => $docs->p3_pejabat_mitra_alamat,
          'p3_pejabat_mitra_telepon' => $docs->p3_pejabat_mitra_telepon,
          'p4_waktu_layanan' => $p4_waktu_layanan,
          'p4_slg' => $docs->p4_slg,
          'p4_skema_bisnis' => $docs->skema_bisnis,
          'p4_mekanisme_pembayaran' => $docs->mekanisme_pembayaran,
          'p7_takah_p7' =>$docs-> p7_takah_p7,
          'p7_tgl_p7' => $p7_tgl_p7,
          'p7_harga_pekerjaan' => $docs->p7_harga_pekerjaan,
          'string_p7_harga_pekerjaan' => RupiahFormat::terbilang( (int)str_replace('.','',str_replace('Rp. ','',(strtok( $docs->p7_harga_pekerjaan,',')))) ),
          'p7_skema_bayar' => $docs->skema_byr,
          'sp_takah_sp' => $docs->sp_takah_sp,
          'sp_tgl_sp' => $sp_tgl_sp
      ]);
      $filename = Auth::id() . '_' . (string) Str::uuid();
      $file_path = public_path().'/temp_saved_docs';
      $templateProcessor->saveAs($file_path.'/'.$filename.'.docx');
      $headers = array(
          'Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document',
      );
      return response()->download( $file_path . '/'.$filename.'.docx', $docs->f1_segmen . '_' . $docs->f1_folder . '_'. $docs_year . '_Kontrak_SP.docx', $headers)->deleteFileAfterSend(true);
    }

    public function generateDocKL($var_obl_id){
      $docs = DB::connection('pgsql')->table('form_obl')->leftJoin('mitras','mitras.id','=','f1_mitra_id')
      ->select(
        'form_obl.id',
        'f1_nama_plggn',
        'f1_judul_projek',
        'f1_segmen',
        'f1_folder',
        'created_at',
        'mitras.nama_mitra',
        'p1_tgl_kontrak_mulai',
        'p1_tgl_kontrak_akhir',
        'f1_masa_layanan_hari',
        'f1_masa_layanan_bulan',
        'f1_masa_layanan_tahun',
        DB::raw("
        case
        when p4_skema_bisnis = 'sewa_murni' then 'Sewa Murni'
        when p4_skema_bisnis = 'sewa_beli' then 'Sewa Beli'
        when p4_skema_bisnis = 'beli_putus' then 'Pengadaan Beli Putus'
        else ''
        end as skema_bisnis"),
        'p4_slg',
        'p6_tgl_p6',
        'p7_takah_p7',
        'p7_tgl_p7',
        'p7_harga_pekerjaan',
        'p8_takah_p8',
        'p8_tgl_p8',
        'kl_takah_kl',
        'kl_tgl_kl',
        'kl_notaris',
        'kl_akta_notaris',
        'kl_tgl_akta_notaris',
        'kl_nama_pejabat_telkom',
        'kl_jabatan_pejabat_telkom',
        'kl_nama_pejabat_mitra',
        'kl_jabatan_pejabat_mitra',
        'kl_no_skm',
        'kl_tgl_skm',
        'kl_perihal_skm',
        'kl_tempat_ttd_kl',
        'kl_no_anggaran_mitra',
        'kl_tgl_anggaran_mitra',
        'kl_npwp_mitra',
        'kl_rek_bank_mitra',
        'kl_cabang_bank_mitra',
        'kl_nama_bank_mitra'
      )
      ->where('form_obl.id',$var_obl_id)->first();
      $docs_year = new Carbon($docs->created_at);
      $docs_year = $docs_year->translatedFormat('Y');

      $p1_tgl_kontrak_mulai = new Carbon($docs->p1_tgl_kontrak_mulai);
      $p1_tgl_kontrak_mulai = $p1_tgl_kontrak_mulai->translatedFormat('d F Y');
      $p1_tgl_kontrak_akhir = new Carbon($docs->p1_tgl_kontrak_akhir);
      $p1_tgl_kontrak_akhir = $p1_tgl_kontrak_akhir->translatedFormat('d F Y');
      $p6_tgl_p6 = new Carbon($docs->p6_tgl_p6);
      $p6_tgl_p6 = $p6_tgl_p6->translatedFormat('d F Y');
      $p7_tgl_p7 = new Carbon($docs->p7_tgl_p7);
      $p7_tgl_p7 = $p7_tgl_p7->translatedFormat('d F Y');
      $p8_tgl_p8 = new Carbon($docs->p8_tgl_p8);
      $p8_tgl_p8 = $p8_tgl_p8->translatedFormat('d F Y');
      $kl_tgl_kl = new Carbon($docs->kl_tgl_kl);
      $kl_tgl_kl = $kl_tgl_kl->translatedFormat('d F Y');
      $hari = new Carbon($docs->kl_tgl_kl);
      $hari = $hari->translatedFormat('l');
      $tanggal = new Carbon($docs->kl_tgl_kl);
      $tanggal = $tanggal->translatedFormat('d');
      $tanggal = NumberToWords::transformNumber('id',(int)$tanggal);
      $bulan = new Carbon($docs->kl_tgl_kl);
      $bulan = $bulan->translatedFormat('F');
      $tahun = new Carbon($docs->kl_tgl_kl);
      $tahun = $tahun->translatedFormat('Y');
      $tahun = NumberToWords::transformNumber('id',(int)$tahun);
      $kl_tgl_akta_notaris = new Carbon($docs->kl_tgl_akta_notaris);
      $kl_tgl_akta_notaris = $kl_tgl_akta_notaris->translatedFormat('d F Y');
      $kl_tgl_skm = new Carbon($docs->kl_tgl_skm);
      $kl_tgl_skm = $kl_tgl_skm->translatedFormat('d F Y');
      $kl_tgl_anggaran_mitra = new Carbon($docs->kl_tgl_anggaran_mitra);
      $kl_tgl_anggaran_mitra = $kl_tgl_anggaran_mitra->translatedFormat('d F Y');

      $string_masa_layanan = '';
      $masa_layanan = '';
      if($docs->f1_masa_layanan_tahun){
        $string_masa_layanan = $string_masa_layanan . NumberToWords::transformNumber('id',(int)$docs->f1_masa_layanan_tahun) . ' Tahun ';
        $masa_layanan = $masa_layanan . $docs->f1_masa_layanan_tahun .' Tahun ';
      }
      if($docs->f1_masa_layanan_bulan){
        $string_masa_layanan = $string_masa_layanan . NumberToWords::transformNumber('id',(int)$docs->f1_masa_layanan_bulan) . ' Bulan ';
        $masa_layanan = $masa_layanan . $docs->f1_masa_layanan_bulan .' Bulan ';
      }
      if($docs->f1_masa_layanan_hari){
        $string_masa_layanan = $string_masa_layanan . NumberToWords::transformNumber('id',(int)$docs->f1_masa_layanan_hari) . ' Hari ';
        $masa_layanan = $masa_layanan . $docs->f1_masa_layanan_hari .' Hari ';
      }


      $templateProcessor = new TemplateProcessor(public_path() . '/basic_documents/basic_kl_doc.docx');
      $templateProcessor->setValues([
          'f1_nama_plggn' => $docs->f1_nama_plggn,
          'f1_judul_projek' => $docs->f1_judul_projek,
          'f1_mitra_id' => $docs->nama_mitra,
          'p1_tgl_kontrak_mulai' => $p1_tgl_kontrak_mulai,
          'p1_tgl_kontrak_akhir' => $p1_tgl_kontrak_akhir,
          'masa_layanan' => $masa_layanan,
          'string_masa_layanan' => $string_masa_layanan,
          'p4_skema_bisnis' => $docs->skema_bisnis,
          'p4_slg' => $docs->p4_slg,
          'string_p4_slg' => NumberToWords::transformNumber('id',(int)$docs->p4_slg),
          'p6_tgl_p6' => $p6_tgl_p6,
          'p7_takah_p7' => $docs->p7_takah_p7,
          'p7_tgl_p7' => $p7_tgl_p7,
          'p7_harga_pekerjaan' => $docs->p7_harga_pekerjaan,
          'string_p7_harga_pekerjaan' => RupiahFormat::terbilang( (int)str_replace('.','',str_replace('Rp. ','',(strtok( $docs->p7_harga_pekerjaan,',')))) ),
          'p8_takah_p8' => $docs->p8_takah_p8,
          'p8_tgl_p8' => $p8_tgl_p8,
          'kl_takah_kl' => $docs->kl_takah_kl,
          'kl_tgl_kl' => $kl_tgl_kl,
          'hari' => $hari,
          'tanggal' => $tanggal,
          'bulan' => $bulan,
          'tahun' => $tahun,
          'kl_notaris' => $docs->kl_notaris,
          'kl_akta_notaris' => $docs->kl_akta_notaris,
          'kl_tgl_akta_notaris' => $kl_tgl_akta_notaris,
          'kl_nama_pejabat_telkom' => $docs->kl_nama_pejabat_telkom,
          'kl_jabatan_pejabat_telkom' => $docs->kl_jabatan_pejabat_telkom,
          'kl_nama_pejabat_mitra' => $docs->kl_nama_pejabat_mitra,
          'kl_jabatan_pejabat_mitra' => $docs->kl_jabatan_pejabat_mitra,
          'kl_no_skm' => $docs->kl_no_skm,
          'kl_tgl_skm' => $kl_tgl_skm,
          'kl_perihal_skm' => $docs->kl_perihal_skm,
          'kl_tempat_ttd_kl' => $docs->kl_tempat_ttd_kl,
          'kl_no_anggaran_mitra' => $docs->kl_no_anggaran_mitra,
          'kl_tgl_anggaran_mitra' => $kl_tgl_anggaran_mitra,
          'kl_npwp_mitra' => $docs->kl_npwp_mitra,
          'kl_rek_bank_mitra' => $docs->kl_rek_bank_mitra,
          'kl_cabang_bank_mitra' => $docs->kl_cabang_bank_mitra,
          'kl_nama_bank_mitra' => $docs->kl_nama_bank_mitra
      ]);
      $filename = Auth::id() . '_' . (string) Str::uuid();
      $file_path = public_path().'/temp_saved_docs';
      $templateProcessor->saveAs($file_path.'/'.$filename.'.docx');
      $headers = array(
          'Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document',
      );
      return response()->download( $file_path . '/'.$filename.'.docx', $docs->f1_segmen . '_' . $docs->f1_folder . '_'. $docs_year . '_Kontrak_KL.docx', $headers)->deleteFileAfterSend(true);
    }



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
