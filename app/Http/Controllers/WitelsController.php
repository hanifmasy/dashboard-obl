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
      $user_in_is = User::leftJoin('user_role','user_role.user_id','=','users.id')
      ->leftJoin('witels','witels.id','=','users.witel_id')
      ->leftJoin('user_mitra','user_mitra.user_id','=','users.id')
      ->leftJoin('mitras','mitras.id','=','user_mitra.mitra_id')
      ->select('users.id','user_role.role_id','users.witel_id','witels.nama_witel','mitras.nama_mitra','mitras.id as mitra_id')->where('users.id',Auth::id())->first();
      $created_by = Auth::id();
      $created_at = Carbon::now()->translatedFormat('Y-m-d H:i:s');

      if($request->submit){
        if($request->submit == 'submit_witel'){
          $inputan_masuk = [];
          $inputan_masuk['lop_judul_projek'] = 'required';
          $inputan_masuk['lop_nama_plggn'] = 'required';
          $validasi = $request->all();
          $validator_draf = Validator::make($validasi,$inputan_masuk);
          if($validator_draf->fails()){ return back()->withErrors($validator_draf)->withInput(); }

          try{
            // GET ALL INPUTS
            $collection = collect($request->all());
            $filtered = $collection->except([
                '_token',
                'submit',
                'f1_judul_projek'
            ]);
            $filtered->put('created_by',$created_by);
            $filtered->put('created_at',$created_at);
            $filtered->put('updated_by',$created_by);
            $filtered->put('updated_at',$created_at);
            $filtered->put('lop_witel',$user_in_is->nama_witel);
            $filtered->put('on_view',true);
            $filtered->put('lop_review_kb',false);
            $filtered->put('on_handling','witel');
            $filtered->put('lop_count_revisi',0);

            $f1_id_form_pralop = DB::connection('pgsql')->table('form_pralop')
            ->insertGetId(
                $filtered->all()
            );

            // check f1_judul_projek ( layanan )
            if( $request->f1_judul_projek && count($request->f1_judul_projek) > 0 ){
              $nama_folder = '';
              $temp_folder_old_name = '';
              $temp_folder_old_id = '';
              $hari = Carbon::now();
              $hari_ini = $hari->dayOfYear;
              $tahun_ini = $hari->year;
              $tahun_ini = strval($tahun_ini);
              $hari_ini = ($hari_ini*40);
              $skip_folder = null;
              do{
                $string_hari_ini = sprintf("%04d", $hari_ini);
                $nama_folder = $string_hari_ini;
                $cek_nama_folder = DB::connection('pgsql')->table('form_obl')->select('id','f1_folder')
                ->where(DB::raw("to_char(created_at,'yyyy')"),'=',$tahun_ini)
                ->where(DB::raw("NULLIF(regexp_replace(f1_folder, '\D','','g'), '')"),'=',$nama_folder)->first();
                if( $cek_nama_folder ){ $skip_folder = true; $hari_ini++; }
                else{ $skip_folder = false; }
              }while($skip_folder==true);

              $alpabet = 'A';
              $arr_f1_judul_projek = [];
              if( count($request->f1_judul_projek) > 1 ){
                foreach($request->f1_judul_projek as $key => $value){
                  array_push($arr_f1_judul_projek,[
                      'f1_judul_projek' => $request->lop_judul_projek . ' Layanan ' . $value,
                      'f1_id_form_pralop' => $f1_id_form_pralop,
                      'f1_nama_plggn' => $request->lop_nama_plggn,
                      'f1_alamat_plggn' => $request->lop_alamat_plggn,
                      'f1_pic_plggn' => $request->lop_pic_plggn,
                      'f1_lop_id_mytens' => $request->lop_id_mytens,
                      'f1_nomor_akun' => $request->lop_nomor_akun,
                      'f1_nilai_kb' => $request->lop_nilai_kb,
                      'f1_segmen' => $request->lop_segmen,
                      'f1_skema_bayar' => $request->lop_skema_bayar,
                      'f1_status_order' => $request->lop_status_order,
                      'created_at' => $created_at,
                      'created_by' => $created_by,
                      'updated_at' => $created_at,
                      'updated_by' => $created_by,
                      'is_draf' => 8,
                      'f1_folder' => $nama_folder . $alpabet
                  ] );
                  $alpabet++;
                }
              }
              if( count($request->f1_judul_projek) === 1 ){
                foreach($request->f1_judul_projek as $key => $value){
                  array_push($arr_f1_judul_projek,[
                      'f1_judul_projek' => $request->lop_judul_projek . ' Layanan ' . $value,
                      'f1_id_form_pralop' => $f1_id_form_pralop,
                      'f1_nama_plggn' => $request->lop_nama_plggn,
                      'f1_alamat_plggn' => $request->lop_alamat_plggn,
                      'f1_pic_plggn' => $request->lop_pic_plggn,
                      'f1_lop_id_mytens' => $request->lop_id_mytens,
                      'f1_nomor_akun' => $request->lop_nomor_akun,
                      'f1_nilai_kb' => $request->lop_nilai_kb,
                      'f1_segmen' => $request->lop_segmen,
                      'f1_skema_bayar' => $request->lop_skema_bayar,
                      'f1_status_order' => $request->lop_status_order,
                      'created_at' => $created_at,
                      'created_by' => $created_by,
                      'updated_at' => $created_at,
                      'updated_by' => $created_by,
                      'is_draf' => 8,
                      'f1_folder' => $nama_folder
                  ] );
                }
              }

              DB::connection('pgsql')->table('form_obl')->insert( $arr_f1_judul_projek );
            }
            // end check f1_judul_projek

            return redirect('witels')->with('status', 'Sukses Submit PRA LOP');
          }
          catch(Throwable $e){ return back()->withInput()->with('status','Oops! Gagal Simpan PRA LOP.'); }

        }
        else{ return back()->withInput()->with('status','Oops! Gagal Proses Submit PRA LOP.'); }
      }
      else{
        return back()->withInput()->with('status','Oops! Gagal Routing.');
      }
    }

    public function forms(Request $request){
      // dd($request->all());
      $user_in_is = User::leftJoin('user_role','user_role.user_id','=','users.id')
      ->leftJoin('witels','witels.id','=','users.witel_id')
      ->leftJoin('user_mitra','user_mitra.user_id','=','users.id')
      ->leftJoin('mitras','mitras.id','=','user_mitra.mitra_id')
      ->select('users.id','user_role.role_id','users.witel_id','witels.nama_witel','mitras.nama_mitra','mitras.id as mitra_id')->where('users.id',Auth::id())->first();

      $obl_id = '';
      if( $request->forms_obl_id ){ $obl_id = $request->forms_obl_id; }
      $encrypted = '';
      if( $request->encrypted ){ $encrypted = $request->encrypted[0]; }
      $witel_form = DB::connection('pgsql')->table('form_obl')
      ->select(
        '*',
        DB::raw("to_char(p1_tgl_p1,'yyyy-mm-dd') as tgl_p1"),
        DB::raw("to_char(p1_tgl_delivery,'yyyy-mm-dd') as tgl_delivery_p1"),
        DB::raw("to_char(p0_tgl_submit,'yyyy-mm-dd') as tgl_submit_p0"),
        DB::raw("to_char(p1_tgl_kontrak_mulai,'yyyy-mm-dd') as tgl_kontrak_mulai_p1"),
        DB::raw("to_char(p1_tgl_kontrak_akhir,'yyyy-mm-dd') as tgl_kontrak_akhir_p1"),
        DB::raw("to_char(p1_tgl_doc_plggn,'yyyy-mm-dd') as tgl_doc_plggn_p1")
      )->where('id',$obl_id)->first();

      return view('pages.witel_forms',compact('obl_id','encrypted','witel_form','user_in_is'));
    }

    public function updateOblHistori($var_obl_id){
      $temp_histori = DB::connection('pgsql')->table('form_obl')
      ->select('*')
      ->where('id',$var_obl_id)
      ->first();
      DB::connection('pgsql')->table('form_obl_histori')
      ->insert([
        'obl_id' => $temp_histori->id,
        'submit' => $temp_histori->submit,
        'revisi_witel' => $temp_histori->revisi_witel,
        'revisi_witel_count' => $temp_histori->revisi_witel_count,
        'is_draf' => $temp_histori->is_draf,
        'updated_at' => $temp_histori->updated_at,
        'updated_by' => $temp_histori->updated_by,
        'f1_nama_plggn' => $temp_histori->f1_nama_plggn,
        'f1_alamat_plggn' => $temp_histori->f1_alamat_plggn,
        'f1_witel' => $temp_histori->f1_witel,
        'f1_judul_projek' => $temp_histori->f1_judul_projek,
        'f1_segmen' => $temp_histori->f1_segmen,
        'f1_proses' => $temp_histori->f1_proses,
        'f1_folder' => $temp_histori->f1_folder,
        'f1_nilai_kb' => $temp_histori->f1_nilai_kb,
        'f1_no_kfs_spk' => $temp_histori->f1_no_kfs_spk,
        'f1_quote_kontrak' => $temp_histori->f1_quote_kontrak,
        'f1_nomor_akun' => $temp_histori->f1_nomor_akun,
        'f1_jenis_kontrak' => $temp_histori->f1_jenis_kontrak,
        'f1_skema_bayar' => $temp_histori->f1_skema_bayar,
        'f1_status_order' => $temp_histori->f1_status_order,
        'f1_status_sm' => $temp_histori->f1_status_sm,
        'f1_tgl_keterangan' => $temp_histori->f1_tgl_keterangan,
        'f1_keterangan' => $temp_histori->f1_keterangan,
        'f1_mitra_id' => $temp_histori->f1_mitra_id,
        'f1_pic_mitra' => $temp_histori->f1_pic_mitra,
        'f1_jenis_spk' => $temp_histori->f1_jenis_spk,
        'f1_masa_layanan_tahun' => $temp_histori->f1_masa_layanan_tahun,
        'f1_masa_layanan_bulan' => $temp_histori->f1_masa_layanan_bulan,
        'f1_masa_layanan_hari' => $temp_histori->f1_masa_layanan_hari,
        'f1_pic_plggn' => $temp_histori->f1_pic_plggn,
        'f2_nilai_kontrak' => $temp_histori->f2_nilai_kontrak,
        'f2_tgl_p1' => $temp_histori->f2_tgl_p1,
        'p2_tgl_p2' => $temp_histori->p2_tgl_p2,
        'p2_tgl_justifikasi' => $temp_histori->p2_tgl_justifikasi,
        'p2_dievaluasi_oleh' => $temp_histori->p2_dievaluasi_oleh,
        'p2_disetujui_oleh' => $temp_histori->p2_disetujui_oleh,
        'p2_pilihan_catatan' => $temp_histori->p2_pilihan_catatan,
        'p2_catatan' => $temp_histori->p2_catatan,
        'p3_tgl_p3' => $temp_histori->p3_tgl_p3,
        'p3_takah_p3' => $temp_histori->p3_takah_p3,
        'p3_pejabat_mitra_nama' => $temp_histori->p3_pejabat_mitra_nama,
        'p3_pejabat_mitra_alamat' => $temp_histori->p3_pejabat_mitra_alamat,
        'p3_pejabat_mitra_telepon' => $temp_histori->p3_pejabat_mitra_telepon,
        'p3_status_rapat_pengadaan' => $temp_histori->p3_status_rapat_pengadaan,
        'p3_tgl_rapat_pengadaan' => $temp_histori->p3_tgl_rapat_pengadaan,
        'p3_tmpt_rapat_pengadaan' => $temp_histori->p3_tmpt_rapat_pengadaan,
        'p3_tgl_terima_sp' => $temp_histori->p3_tgl_terima_sp,
        'p3_alamat_terima_sp' => $temp_histori->p3_alamat_terima_sp,
        'p3_manager_obl' => $temp_histori->p3_manager_obl,
        'p4_tgl_p4' => $temp_histori->p4_tgl_p4,
        'p4_waktu_layanan' => $temp_histori->p4_waktu_layanan,
        'p4_skema_bisnis' => $temp_histori->p4_skema_bisnis,
        'p4_mekanisme_pembayaran' => $temp_histori->p4_mekanisme_pembayaran,
        'p4_slg' => $temp_histori->p4_slg,
        'p4_fasilitator' => $temp_histori->p4_fasilitator,
        'p4_pengesahan' => $temp_histori->p4_pengesahan,
        'p5_tgl_p5' => $temp_histori->p5_tgl_p5,
        'p5_harga_penawaran' => $temp_histori->p5_harga_penawaran,
        'p5_ttd_evaluator' => $temp_histori->p5_ttd_evaluator,
        'p6_tgl_p6' => $temp_histori->p6_tgl_p6,
        'p6_ttd_bast_telkom' => $temp_histori->p6_ttd_bast_telkom,
        'p6_ttd_bast_mitra' => $temp_histori->p6_ttd_bast_mitra,
        'p6_harga_negosiasi' => $temp_histori->p6_harga_negosiasi,
        'p6_nama_peserta_mitra' => $temp_histori->p6_nama_peserta_mitra,
        'p6_jabatan_peserta_mitra' => $temp_histori->p6_jabatan_peserta_mitra,
        'p6_peserta_rapat_telkom' => $temp_histori->p6_peserta_rapat_telkom,
        'p6_pengesahan' => $temp_histori->p6_pengesahan,
        'p7_tgl_p7' => $temp_histori->p7_tgl_p7,
        'p7_takah_p7' => $temp_histori->p7_takah_p7,
        'p7_lampiran_berkas' => $temp_histori->p7_lampiran_berkas,
        'p7_harga_pekerjaan' => $temp_histori->p7_harga_pekerjaan,
        'p7_skema_bayar' => $temp_histori->p7_skema_bayar,
        'p7_pemeriksa' => $temp_histori->p7_pemeriksa,
        'p7_tembusan' => $temp_histori->p7_tembusan,
        'sp_tgl_sp' => $temp_histori->sp_tgl_sp,
        'sp_takah_sp' => $temp_histori->sp_takah_sp,
        'sp_nomor_kb' => $temp_histori->sp_nomor_kb,
        'p8_tgl_p8' => $temp_histori->p8_tgl_p8,
        'p8_takah_p8' => $temp_histori->p8_takah_p8,
        'wo_tgl_wo' => $temp_histori->wo_tgl_wo,
        'wo_takah_wo' => $temp_histori->wo_takah_wo,
        'wo_tgl_fo' => $temp_histori->wo_tgl_fo,
        'wo_nomor_kb' => $temp_histori->wo_nomor_kb,
        'wo_jenis_layanan' => $temp_histori->wo_jenis_layanan,
        'wo_jumlah_layanan' => $temp_histori->wo_jumlah_layanan,
        'wo_harga_ke_plggn' => $temp_histori->wo_harga_ke_plggn,
        'wo_onetime_charge_plggn' => $temp_histori->wo_onetime_charge_plggn,
        'wo_monthly_plggn' => $temp_histori->wo_monthly_plggn,
        'wo_onetime_charge_telkom' => $temp_histori->wo_onetime_charge_telkom,
        'wo_persen_telkom' => $temp_histori->wo_persen_telkom,
        'wo_monthly_telkom' => $temp_histori->wo_monthly_telkom,
        'wo_onetime_charge_mitra' => $temp_histori->wo_onetime_charge_mitra,
        'wo_persen_mitra' => $temp_histori->wo_persen_mitra,
        'wo_monthly_mitra' => $temp_histori->wo_monthly_mitra,
        'kl_tgl_kl' => $temp_histori->kl_tgl_kl,
        'kl_takah_kl' => $temp_histori->kl_takah_kl,
        'kl_nomor_kb' => $temp_histori->kl_nomor_kb,
        'kl_no_kl_mitra' => $temp_histori->kl_no_kl_mitra,
        'kl_tempat_ttd_kl' => $temp_histori->kl_tempat_ttd_kl,
        'kl_notaris' => $temp_histori->kl_notaris,
        'kl_akta_notaris' => $temp_histori->kl_akta_notaris,
        'kl_tgl_akta_notaris' => $temp_histori->kl_tgl_akta_notaris,
        'kl_nama_pejabat_telkom' => $temp_histori->kl_nama_pejabat_telkom,
        'kl_jabatan_pejabat_telkom' => $temp_histori->kl_jabatan_pejabat_telkom,
        'kl_npwp_mitra' => $temp_histori->kl_npwp_mitra,
        'kl_no_anggaran_mitra' => $temp_histori->kl_no_anggaran_mitra,
        'kl_tgl_anggaran_mitra' => $temp_histori->kl_tgl_anggaran_mitra,
        'kl_nama_pejabat_mitra' => $temp_histori->kl_nama_pejabat_mitra,
        'kl_jabatan_pejabat_mitra' => $temp_histori->kl_jabatan_pejabat_mitra,
        'kl_no_skm' => $temp_histori->kl_no_skm,
        'kl_tgl_skm' => $temp_histori->kl_tgl_skm,
        'kl_perihal_skm' => $temp_histori->kl_perihal_skm,
        'kl_tgl_akhir_kl' => $temp_histori->kl_tgl_akhir_kl,
        'kl_bayar_dp' => $temp_histori->kl_bayar_dp,
        'kl_nama_bank_mitra' => $temp_histori->kl_nama_bank_mitra,
        'kl_cabang_bank_mitra' => $temp_histori->kl_cabang_bank_mitra,
        'kl_rek_bank_mitra' => $temp_histori->kl_rek_bank_mitra,
        'kl_an_bank_mitra' => $temp_histori->kl_an_bank_mitra,
        'file_p2' => $temp_histori->file_p2,
        'file_p3' => $temp_histori->file_p3,
        'file_p4' => $temp_histori->file_p4,
        'file_p5' => $temp_histori->file_p5,
        'file_p6' => $temp_histori->file_p6,
        'file_p7' => $temp_histori->file_p7,
        'file_p8' => $temp_histori->file_p8,
        'file_sp' => $temp_histori->file_sp,
        'file_wo' => $temp_histori->file_wo,
        'file_kl' => $temp_histori->file_kl,
       'p0_nomor_p0' => $temp_histori->p0_nomor_p0,
       'p0_nik_am' => $temp_histori->p0_nik_am,
       'p0_nik_manager' => $temp_histori->p0_nik_manager,
       'p0_tgl_submit' => $temp_histori->p0_tgl_submit,
       'p0_pemeriksa' => $temp_histori->p0_pemeriksa,
       'p0_nik_gm' => $temp_histori->p0_nik_gm,
       'p1_nomor_p1' => $temp_histori->p1_nomor_p1,
       'p1_tgl_p1' => $temp_histori->p1_tgl_p1,
       'p1_pemeriksa' => $temp_histori->p1_pemeriksa,
       'p1_tgl_delivery' => $temp_histori->p1_tgl_delivery,
       'p1_lokasi_instal' => $temp_histori->p1_lokasi_instal,
       'p1_skema_bisnis' => $temp_histori->p1_skema_bisnis,
       'p1_skema_bayar' => $temp_histori->p1_skema_bayar,
       'p1_mekanisme_bayar' => $temp_histori->p1_mekanisme_bayar,
       'p1_tgl_kontrak_mulai' => $temp_histori->p1_tgl_kontrak_mulai,
       'p1_tgl_kontrak_akhir' => $temp_histori->p1_tgl_kontrak_akhir,
       'p1_tgl_doc_plggn' => $temp_histori->p1_tgl_doc_plggn,
       'p1_estimasi_harga' => $temp_histori->p1_estimasi_harga,
       'p1_disetujui_gm' => $temp_histori->p1_disetujui_gm,
       'p1_dibuat_am' => $temp_histori->p1_dibuat_am,
       'p1_diperiksa_manager' => $temp_histori->p1_diperiksa_manager,
       'file_p0' => $temp_histori->file_p0,
       'file_p1' => $temp_histori->file_p1,
       'f1_lop_id_mytens' => $temp_histori->f1_lop_id_mytens,
       'f1_id_form_pralop' => $temp_histori->f1_id_form_pralop,
       'p1_paragraf' => $temp_histori->p1_paragraf,
       'p0_paragraf' => $temp_histori->p0_paragraf
      ]);
      return $temp_histori;
    }

    public function formsCreate(Request $request){
      // dd($request->all());
      $user_in_is = User::leftJoin('user_role','user_role.user_id','=','users.id')
      ->leftJoin('witels','witels.id','=','users.witel_id')
      ->leftJoin('user_mitra','user_mitra.user_id','=','users.id')
      ->leftJoin('mitras','mitras.id','=','user_mitra.mitra_id')
      ->select('users.id','user_role.role_id','users.witel_id','witels.nama_witel','mitras.nama_mitra','mitras.id as mitra_id')
      ->where('users.id',Auth::id())->first();

       if($request->obl_id){
         $inputan_masuk = [];
         $inputan_masuk['f1_judul_projek'] = 'required';
         $validasi = $request->all();
         $validator_draf = Validator::make($validasi,$inputan_masuk);
         if($validator_draf->fails()){ return redirect()->route('witels.pralop.detail',['edit_pralop_id'=>$request->encrypted])->with('status','Gagal Simpan Form P1.'); }

         try{
           $collection = collect($request->all());
           $filtered = $collection->except([
               '_token',
               'obl_id',
               'encrypted',
               'tambah_p0'
           ]);

           $tambah_p0 = false;
           if($request->tambah_p0){ $tambah_p0 = $request->tambah_p0; }
           $filtered->put('updated_by',Auth::id());
           $filtered->put('updated_at',Carbon::now()->translatedFormat('Y-m-d H:i:s'));
           if($tambah_p0){ $filtered->put('f1_keterangan','[SISTEM] Update Form P1 & P0 Layanan: ' . $request->f1_judul_projek); }
           else{ $filtered->put('f1_keterangan','[SISTEM] Update Form P1 Layanan: ' . $request->f1_judul_projek); }
           $filtered->put('f1_tgl_keterangan',Carbon::now()->translatedFormat('Y-m-d H:i:s'));
           if( $request->p1_tgl_p1 ){
             $filtered->put('f2_tgl_p1',Carbon::parse($request->p1_tgl_p1)->translatedFormat('Y-m-d H:i:s'));
             $filtered->put('wo_tgl_fo',Carbon::parse($request->p1_tgl_p1)->translatedFormat('Y-m-d H:i:s'));
           }
           // $filtered->put('p0_tgl_submit',Carbon::now()->translatedFormat('Y-m-d H:i:s'));
           // $filtered->put('p1_tgl_p1',Carbon::now()->translatedFormat('Y-m-d H:i:s'));
           // $filtered->put('f1_nilai_kb', $request->p1_estimasi_harga);
           // $filtered->put('p1_pemeriksa', $request->p0_pemeriksa);
           // $filtered->put('p1_disetujui_gm', $request->p0_nik_gm);
           // $filtered->put('p1_dibuat_am', $request->p0_nik_am);
           // $filtered->put('p1_diperiksa_manager', $request->p0_nik_manager);

           $temp_histori = $this->updateOblHistori($request->obl_id);
           DB::connection('pgsql')->table('form_obl')->where('id',$request->obl_id)->update( $filtered->all() );

           $cek_dulu = DB::connection('pgsql')->table('form_obl')
           ->select('id','p0_tgl_submit','p0_nomor_p0','p1_nomor_p1','p1_tgl_p1','file_p0','file_p1')
           ->where('id',$request->obl_id)
           ->first();
           // revisi_witel is false when DOC & FORMS & FILES exist
           if(
             $cek_dulu->id &&
             $cek_dulu->p0_tgl_submit && $cek_dulu->p0_nomor_p0 &&
             $cek_dulu->p1_tgl_p1 && $cek_dulu->p1_nomor_p1 &&
             $cek_dulu->file_p0 && $cek_dulu->file_p1
           ){
             if($user_in_is->role_id === 8 || $user_in_is->role_id === 9){
               DB::connection('pgsql')->table('form_obl')
               ->where('id',$request->obl_id)
               ->update( [ 'submit' => 'solution_form_p1' ] );
             }
             if($user_in_is->role_id === 4){
               DB::connection('pgsql')->table('form_obl')
               ->where('id',$request->obl_id)
               ->update( [ 'revisi_witel' => false, 'submit' => 'witel_form_p1' ] );
             }
           }else{
             if($user_in_is->role_id === 8 || $user_in_is->role_id === 9){
               DB::connection('pgsql')->table('form_obl')
               ->where('id',$request->obl_id)
               ->update( [ 'submit' => 'solution_form_p1' ] );
             }
             if($user_in_is->role_id === 4){
               DB::connection('pgsql')->table('form_obl')
               ->where('id',$request->obl_id)
               ->update( [ 'revisi_witel' => true, 'submit' => 'witel_form_p1' ] );
             }
           }


           return redirect()->route('witels.pralop.detail',['edit_pralop_id'=>$request->encrypted])->with('status','Sukses Simpan Form P1.');
         }
         catch(Throwable $e){
           return redirect()->route('witels.pralop.detail',['edit_pralop_id'=>$request->encrypted])->with('status','Gagal Simpan Form P1.');
         }
       }
      else{ return redirect()->route('witels.pralop.detail',['edit_pralop_id'=>$request->encrypted])->with('status','Oops! Salah Routing.'); }
    }

    public function files(Request $request){
      dd($request->all());
    }

    public function upload(Request $request){
      dd($request->all());
    }
}
