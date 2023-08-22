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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Models\User;
use App\Models\DocObl;
use App\Models\DocOblHistori;
use Carbon\Carbon;


class UploadController extends Controller
{
    public function index(Request $request){
      // dd($request->all());
      $user_in_is = User::leftJoin('user_role','user_role.user_id','=','users.id')
      ->leftJoin('witels','witels.id','=','users.witel_id')
      ->leftJoin('user_mitra','user_mitra.user_id','=','users.id')
      ->leftJoin('mitras','mitras.id','=','user_mitra.mitra_id')
      ->select('users.id','user_role.role_id','users.witel_id','witels.nama_witel','mitras.nama_mitra','mitras.id as mitra_id')
      ->where('users.id',Auth::id())->first();
      return view('pages.obls.upload',compact('user_in_is'));
    }

    public function cari(Request $request){
      // dd($request->all());
      $user_in_is = User::leftJoin('user_role','user_role.user_id','=','users.id')
      ->leftJoin('witels','witels.id','=','users.witel_id')
      ->leftJoin('user_mitra','user_mitra.user_id','=','users.id')
      ->leftJoin('mitras','mitras.id','=','user_mitra.mitra_id')
      ->select('users.id','user_role.role_id','users.witel_id','witels.nama_witel','mitras.nama_mitra','mitras.id as mitra_id')
      ->where('users.id',Auth::id())->first();

      $is_segmen_ok = null;
      $is_folder_ok = null;
      $is_tahun_ok = null;
      if($request->f1_segmen){
        if($request->f1_segmen === 'DES' || $request->f1_segmen === 'DGS' || $request->f1_segmen === 'DBS'){ $is_segmen_ok = true; }
        else{ $is_segmen_ok = false; }
      }
      if($request->folder){
        if( preg_match('/[^a-z_\-0-9]/i',$request->folder) ){ $is_folder_ok = false; }
        else{ $is_folder_ok = true; }
      }
      if($request->tahun){
        if( preg_match('/^[0-9]+$/',$request->tahun) ){ $is_tahun_ok = true; } else{ $is_tahun_ok = false; }
      }

      if($is_segmen_ok == false || $is_folder_ok == false || $is_tahun_ok == false){
        $temp_status = '';
        if($is_segmen_ok == false){ $temp_status = 'Salah Input Segmen'; }
        if($is_folder_ok == false){ $temp_status = 'Salah Input Nama Folder'; }
        if($is_tahun_ok == false){ $temp_status = 'Salah Input Tahun'; }
        return response()->json(['status_id'=>'3','status'=>$temp_status,'is_segmen_ok'=>$is_segmen_ok,'is_folder_ok'=>$is_folder_ok,'is_tahun_ok'=>$is_tahun_ok]);
      }

      try{
        $upload_doc = DocObl::leftJoin('mitras','mitras.id','=','obl.f1_mitra_id')
        ->select(
          'obl.id',
          'f1_proses',
          'revisi_witel',
          'revisi_witel_count',
          'f1_jenis_spk',
          'f1_judul_projek',
          'f1_nama_plggn',
          'mitras.nama_mitra',
        DB::raw("substring(f1_folder, 5, length(f1_folder)-4 ) as folder"),'f1_segmen',
        DB::raw("to_char(created_at,'yyyy') as tahun"),
        DB::raw("case when file_p0 is null or file_p0 = '' then '' else file_p2 end as nama_p0"),
        DB::raw("case when file_p1 is null or file_p1 = '' then '' else file_p2 end as nama_p1"),
        DB::raw("case when file_p2 is null or file_p2 = '' then '' else file_p2 end as nama_p2"),
        DB::raw("case when file_p3 is null or file_p3 = '' then '' else file_p3 end as nama_p3"),
        DB::raw("case when file_p4 is null or file_p4 = '' then '' else file_p4 end as nama_p4"),
        DB::raw("case when file_p5 is null or file_p5 = '' then '' else file_p5 end as nama_p5"),
        DB::raw("case when file_p6 is null or file_p6 = '' then '' else file_p6 end as nama_p6"),
        DB::raw("case when file_p7 is null or file_p7 = '' then '' else file_p7 end as nama_p7"),
        DB::raw("case when file_p8 is null or file_p8 = '' then '' else file_p8 end as nama_p8"),
        DB::raw("case when file_sp is null or file_sp = '' then '' else file_sp end as nama_sp"),
        DB::raw("case when file_wo is null or file_wo = '' then '' else file_wo end as nama_wo"),
        DB::raw("case when file_kl is null or file_kl = '' then '' else file_kl end as nama_kl")
        )->whereRaw("
        (deleted_at is null and to_char(deleted_at,'yyyy-mm-dd') is null)
        and f1_segmen = '$request->f1_segmen'
        and f1_folder = '$request->folder'
        and to_char(created_at,'yyyy') = '$request->tahun'
        ")
        ->get()->toArray();
        if($upload_doc){ return response()->json(['status_id'=>'1','status'=>' Ditemukan','upload_doc'=>$upload_doc,'user_in_is'=>$user_in_is]); }
        else{ return response()->json(['status_id'=>'2','status'=>' Tidak Ditemukan','upload_doc'=>$upload_doc]); }
      }
      catch(Throwable $e){ return redirect()->route('obl.upload')->with('status', 'Oops! Gagal Ambil Data ID Dokumen OBL'); }
    }

    public function tableUpload(Request $request){
      // dd($request->all());
      $user_in_is = User::leftJoin('user_role','user_role.user_id','=','users.id')
      ->leftJoin('witels','witels.id','=','users.witel_id')
      ->leftJoin('user_mitra','user_mitra.user_id','=','users.id')
      ->leftJoin('mitras','mitras.id','=','user_mitra.mitra_id')
      ->select('users.id','user_role.role_id','users.witel_id','witels.nama_witel','mitras.nama_mitra','mitras.id as mitra_id')
      ->where('users.id',Auth::id())->first();

       if($request->upload_doc_id){
         $upload_doc_id = $request->upload_doc_id;
         try{
           $upload_doc = DocObl::select(
             'id',
             'revisi_witel',
             'f1_proses',
             'f1_judul_projek',
             'f1_segmen',
             'f1_jenis_spk',
             DB::raw("case when f1_folder is null or f1_folder = '' then '' else f1_folder end as folder"),
             DB::raw("to_char(created_at,'yyyy') as tahun"),
             DB::raw("case when file_p0 is null or file_p0 = '' then '' else file_p0 end as nama_p0"),
             DB::raw("case when file_p1 is null or file_p1 = '' then '' else file_p1 end as nama_p1"),
             DB::raw("case when file_p2 is null or file_p2 = '' then '' else file_p2 end as nama_p2"),
             DB::raw("case when file_p3 is null or file_p3 = '' then '' else file_p3 end as nama_p3"),
             DB::raw("case when file_p4 is null or file_p4 = '' then '' else file_p4 end as nama_p4"),
             DB::raw("case when file_p5 is null or file_p5 = '' then '' else file_p5 end as nama_p5"),
             DB::raw("case when file_p6 is null or file_p6 = '' then '' else file_p6 end as nama_p6"),
             DB::raw("case when file_p7 is null or file_p7 = '' then '' else file_p7 end as nama_p7"),
             DB::raw("case when file_p8 is null or file_p8 = '' then '' else file_p8 end as nama_p8"),
             DB::raw("case when file_sp is null or file_sp = '' then '' else file_sp end as nama_sp"),
             DB::raw("case when file_wo is null or file_wo = '' then '' else file_wo end as nama_wo"),
             DB::raw("case when file_kl is null or file_kl = '' then '' else file_kl end as nama_kl")
             )->where('id',$upload_doc_id)->get()->toArray();
           return view('pages.obls.upload',compact('upload_doc','user_in_is'));
         }
         catch(Throwable $e){ return redirect()->route('obl.tables')->with('status', 'Oops! Gagal Cek ID Dokumen OBL'); }
       }
       else{ return redirect()->route('obl.tables')->with('status', 'Oops! Wrong Routing.'); }
    }

    public function generateUniqueId(){
      $hasil = '';
      $is_skip = null;
      do{
          $hasil = Str::uuid()->toString();
          $temp_id = $hasil . '.pdf';
          $cek_uuid_db1 = DocObl::select('id')
          ->whereRaw("
          file_p0 = '$temp_id' or
          file_p1 = '$temp_id' or
          file_p2 = '$temp_id' or
          file_p3 = '$temp_id' or
          file_p4 = '$temp_id' or
          file_p5 = '$temp_id' or
          file_p6 = '$temp_id' or
          file_p7 = '$temp_id' or
          file_p8 = '$temp_id' or
          file_sp = '$temp_id' or
          file_wo = '$temp_id' or
          file_kl = '$temp_id'
          ")
          ->get()->toArray();

          $cek_uuid_db2 = DocOblHistori::select('id')
          ->whereRaw("
          file_p0 = '$temp_id' or
          file_p1 = '$temp_id' or
          file_p2 = '$temp_id' or
          file_p3 = '$temp_id' or
          file_p4 = '$temp_id' or
          file_p5 = '$temp_id' or
          file_p6 = '$temp_id' or
          file_p7 = '$temp_id' or
          file_p8 = '$temp_id' or
          file_sp = '$temp_id' or
          file_wo = '$temp_id' or
          file_kl = '$temp_id'
          ")
          ->get()->toArray();
          if( ($cek_uuid_db1 && count($cek_uuid_db1)>0) || ($cek_uuid_db2 && count($cek_uuid_db2)>0) ){ $is_skip = true; }
          else{ $is_skip = false; }
      }while($is_skip==true);
      return $hasil;
    }

    public function updateNamaFile($var_obl_id,$var_tipe_form,$var_nama_file_baru){
      $user_in_is = User::leftJoin('user_role','user_role.user_id','=','users.id')
      ->leftJoin('witels','witels.id','=','users.witel_id')
      ->leftJoin('user_mitra','user_mitra.user_id','=','users.id')
      ->leftJoin('mitras','mitras.id','=','user_mitra.mitra_id')
      ->select('users.id','user_role.role_id','users.witel_id','witels.nama_witel','mitras.nama_mitra','mitras.id as mitra_id')
      ->where('users.id',Auth::id())->first();

      $hasil_update = null;
      $ada_update_obl = null;
      try{
        if($var_tipe_form==='file_p0'){ $ada_update_obl = 'file_p0'; }
        if($var_tipe_form==='file_p1'){ $ada_update_obl = 'file_p1'; }
        if($var_tipe_form==='file_p2'){ $ada_update_obl = 'file_p2'; }
        if($var_tipe_form==='file_p3'){ $ada_update_obl = 'file_p3'; }
        if($var_tipe_form==='file_p4'){ $ada_update_obl = 'file_p4'; }
        if($var_tipe_form==='file_p5'){ $ada_update_obl = 'file_p5'; }
        if($var_tipe_form==='file_p6'){ $ada_update_obl = 'file_p6'; }
        if($var_tipe_form==='file_p7'){ $ada_update_obl = 'file_p7'; }
        if($var_tipe_form==='file_p8'){ $ada_update_obl = 'file_p8'; }
        if($var_tipe_form==='file_sp'){ $ada_update_obl = 'file_sp'; }
        if($var_tipe_form==='file_wo'){ $ada_update_obl = 'file_wo'; }
        if($var_tipe_form==='file_kl'){ $ada_update_obl = 'file_kl'; }

        if( $ada_update_obl ){
          $doc_to_histori = DB::connection('pgsql')->table('form_obl')
          ->select(
            'id',
            'submit',
            'revisi_witel',
            'revisi_witel_count',
            'is_draf',
            'updated_at',
            'updated_by',
            'f1_nama_plggn',
            'f1_alamat_plggn',
            'f1_witel',
            'f1_judul_projek',
            'f1_segmen',
            'f1_proses',
            'f1_folder',
            'f1_nilai_kb',
            'f1_no_kfs_spk',
            'f1_quote_kontrak',
            'f1_nomor_akun',
            'f1_jenis_kontrak',
            'f1_skema_bayar',
            'f1_status_order',
            'f1_status_sm',
            'f1_tgl_keterangan',
            'f1_keterangan',
            'f1_mitra_id',
            'f1_pic_mitra',
            'f1_jenis_spk',
            'f1_masa_layanan_tahun',
            'f1_masa_layanan_bulan',
            'f1_masa_layanan_hari',
            'f1_pic_plggn',
            'f2_nilai_kontrak',
            'f2_tgl_p1',
            'p2_tgl_p2',
            'p2_tgl_justifikasi',
            'p2_dievaluasi_oleh',
            'p2_disetujui_oleh',
            'p2_pilihan_catatan',
            'p2_catatan',
            'p3_tgl_p3',
            'p3_takah_p3',
            'p3_pejabat_mitra_nama',
            'p3_pejabat_mitra_alamat',
            'p3_pejabat_mitra_telepon',
            'p3_status_rapat_pengadaan',
            'p3_tgl_rapat_pengadaan',
            'p3_tmpt_rapat_pengadaan',
            'p3_tgl_terima_sp',
            'p3_alamat_terima_sp',
            'p3_manager_obl',
            'p4_tgl_p4',
            'p4_waktu_layanan',
            'p4_skema_bisnis',
            'p4_mekanisme_pembayaran',
            'p4_slg',
            'p4_fasilitator',
            'p4_pengesahan',
            'p5_tgl_p5',
            'p5_harga_penawaran',
            'p5_ttd_evaluator',
            'p6_tgl_p6',
            'p6_ttd_bast_telkom',
            'p6_ttd_bast_mitra',
            'p6_harga_negosiasi',
            'p6_nama_peserta_mitra',
            'p6_jabatan_peserta_mitra',
            'p6_peserta_rapat_telkom',
            'p6_pengesahan',
            'p7_tgl_p7',
            'p7_takah_p7',
            'p7_lampiran_berkas',
            'p7_harga_pekerjaan',
            'p7_skema_bayar',
            'p7_pemeriksa',
            'p7_tembusan',
            'sp_tgl_sp',
            'sp_takah_sp',
            'sp_nomor_kb',
            'p8_tgl_p8',
            'p8_takah_p8',
            'wo_tgl_wo',
            'wo_takah_wo',
            'wo_tgl_fo',
            'wo_nomor_kb',
            'wo_jenis_layanan',
            'wo_jumlah_layanan',
            'wo_harga_ke_plggn',
            'wo_onetime_charge_plggn',
            'wo_monthly_plggn',
            'wo_onetime_charge_telkom',
            'wo_persen_telkom',
            'wo_monthly_telkom',
            'wo_onetime_charge_mitra',
            'wo_persen_mitra',
            'wo_monthly_mitra',
            'kl_tgl_kl',
            'kl_takah_kl',
            'kl_nomor_kb',
            'kl_no_kl_mitra',
            'kl_tempat_ttd_kl',
            'kl_notaris',
            'kl_akta_notaris',
            'kl_tgl_akta_notaris',
            'kl_nama_pejabat_telkom',
            'kl_jabatan_pejabat_telkom',
            'kl_npwp_mitra',
            'kl_no_anggaran_mitra',
            'kl_tgl_anggaran_mitra',
            'kl_nama_pejabat_mitra',
            'kl_jabatan_pejabat_mitra',
            'kl_no_skm',
            'kl_tgl_skm',
            'kl_perihal_skm',
            'kl_tgl_akhir_kl',
            'kl_bayar_dp',
            'kl_nama_bank_mitra',
            'kl_cabang_bank_mitra',
            'kl_rek_bank_mitra',
            'kl_an_bank_mitra',
            'file_p2',
            'file_p3',
            'file_p4',
            'file_p5',
            'file_p6',
            'file_p7',
            'file_p8',
            'file_sp',
            'file_wo',
            'file_kl',
            'p0_nomor_p0',
            'p0_nik_am',
            'p0_nik_manager',
            'p0_tgl_submit',
            'p0_pemeriksa',
            'p0_nik_gm',
            'p1_nomor_p1',
            'p1_tgl_p1',
            'p1_pemeriksa',
            'p1_tgl_delivery',
            'p1_lokasi_instal',
            'p1_skema_bisnis',
            'p1_skema_bayar',
            'p1_mekanisme_bayar',
            'p1_tgl_kontrak_mulai',
            'p1_tgl_kontrak_akhir',
            'p1_tgl_doc_plggn',
            'p1_estimasi_harga',
            'p1_disetujui_gm',
            'p1_dibuat_am',
            'p1_diperiksa_manager',
            'file_p0',
            'file_p1'
            )
          ->where('id',$var_obl_id)
          ->first();

          DB::connection('pgsql')->table('form_obl_histori')->insert([
            'obl_id' => $doc_to_histori->id,
            'submit' => $doc_to_histori->submit,
            'revisi_witel' => $doc_to_histori->revisi_witel,
            'revisi_witel_count' => $doc_to_histori->revisi_witel_count,
            'is_draf' => $doc_to_histori->is_draf,
            'updated_at' => $doc_to_histori->updated_at,
            'updated_by' => $doc_to_histori->updated_by,
            'f1_nama_plggn' => $doc_to_histori->f1_nama_plggn,
            'f1_alamat_plggn' => $doc_to_histori->f1_alamat_plggn,
            'f1_witel' => $doc_to_histori->f1_witel,
            'f1_judul_projek' => $doc_to_histori->f1_judul_projek,
            'f1_segmen' => $doc_to_histori->f1_segmen,
            'f1_proses' => $doc_to_histori->f1_proses,
            'f1_folder' => $doc_to_histori->f1_folder,
            'f1_nilai_kb' => $doc_to_histori->f1_nilai_kb,
            'f1_no_kfs_spk' => $doc_to_histori->f1_no_kfs_spk,
            'f1_quote_kontrak' => $doc_to_histori->f1_quote_kontrak,
            'f1_nomor_akun' => $doc_to_histori->f1_nomor_akun,
            'f1_jenis_kontrak' => $doc_to_histori->f1_jenis_kontrak,
            'f1_skema_bayar' => $doc_to_histori->f1_skema_bayar,
            'f1_status_order' => $doc_to_histori->f1_status_order,
            'f1_status_sm' => $doc_to_histori->f1_status_sm,
            'f1_tgl_keterangan' => $doc_to_histori->f1_tgl_keterangan,
            'f1_keterangan' => $doc_to_histori->f1_keterangan,
            'f1_mitra_id' => $doc_to_histori->f1_mitra_id,
            'f1_pic_mitra' => $doc_to_histori->f1_pic_mitra,
            'f1_jenis_spk' => $doc_to_histori->f1_jenis_spk,
            'f1_masa_layanan_tahun' => $doc_to_histori->f1_masa_layanan_tahun,
            'f1_masa_layanan_bulan' => $doc_to_histori->f1_masa_layanan_bulan,
            'f1_masa_layanan_hari' => $doc_to_histori->f1_masa_layanan_hari,
            'f1_pic_plggn' => $doc_to_histori->f1_pic_plggn,
            'f2_nilai_kontrak' => $doc_to_histori->f2_nilai_kontrak,
            'f2_tgl_p1' => $doc_to_histori->f2_tgl_p1,
            'p2_tgl_p2' => $doc_to_histori->p2_tgl_p2,
            'p2_tgl_justifikasi' => $doc_to_histori->p2_tgl_justifikasi,
            'p2_dievaluasi_oleh' => $doc_to_histori->p2_dievaluasi_oleh,
            'p2_disetujui_oleh' => $doc_to_histori->p2_disetujui_oleh,
            'p2_pilihan_catatan' => $doc_to_histori->p2_pilihan_catatan,
            'p2_catatan' => $doc_to_histori->p2_catatan,
            'p3_tgl_p3' => $doc_to_histori->p3_tgl_p3,
            'p3_takah_p3' => $doc_to_histori->p3_takah_p3,
            'p3_pejabat_mitra_nama' => $doc_to_histori->p3_pejabat_mitra_nama,
            'p3_pejabat_mitra_alamat' => $doc_to_histori->p3_pejabat_mitra_alamat,
            'p3_pejabat_mitra_telepon' => $doc_to_histori->p3_pejabat_mitra_telepon,
            'p3_status_rapat_pengadaan' => $doc_to_histori->p3_status_rapat_pengadaan,
            'p3_tgl_rapat_pengadaan' => $doc_to_histori->p3_tgl_rapat_pengadaan,
            'p3_tmpt_rapat_pengadaan' => $doc_to_histori->p3_tmpt_rapat_pengadaan,
            'p3_tgl_terima_sp' => $doc_to_histori->p3_tgl_terima_sp,
            'p3_alamat_terima_sp' => $doc_to_histori->p3_alamat_terima_sp,
            'p3_manager_obl' => $doc_to_histori->p3_manager_obl,
            'p4_tgl_p4' => $doc_to_histori->p4_tgl_p4,
            'p4_waktu_layanan' => $doc_to_histori->p4_waktu_layanan,
            'p4_skema_bisnis' => $doc_to_histori->p4_skema_bisnis,
            'p4_mekanisme_pembayaran' => $doc_to_histori->p4_mekanisme_pembayaran,
            'p4_slg' => $doc_to_histori->p4_slg,
            'p4_fasilitator' => $doc_to_histori->p4_fasilitator,
            'p4_pengesahan' => $doc_to_histori->p4_pengesahan,
            'p5_tgl_p5' => $doc_to_histori->p5_tgl_p5,
            'p5_harga_penawaran' => $doc_to_histori->p5_harga_penawaran,
            'p5_ttd_evaluator' => $doc_to_histori->p5_ttd_evaluator,
            'p6_tgl_p6' => $doc_to_histori->p6_tgl_p6,
            'p6_ttd_bast_telkom' => $doc_to_histori->p6_ttd_bast_telkom,
            'p6_ttd_bast_mitra' => $doc_to_histori->p6_ttd_bast_mitra,
            'p6_harga_negosiasi' => $doc_to_histori->p6_harga_negosiasi,
            'p6_nama_peserta_mitra' => $doc_to_histori->p6_nama_peserta_mitra,
            'p6_jabatan_peserta_mitra' => $doc_to_histori->p6_jabatan_peserta_mitra,
            'p6_peserta_rapat_telkom' => $doc_to_histori->p6_peserta_rapat_telkom,
            'p6_pengesahan' => $doc_to_histori->p6_pengesahan,
            'p7_tgl_p7' => $doc_to_histori->p7_tgl_p7,
            'p7_takah_p7' => $doc_to_histori->p7_takah_p7,
            'p7_lampiran_berkas' => $doc_to_histori->p7_lampiran_berkas,
            'p7_harga_pekerjaan' => $doc_to_histori->p7_harga_pekerjaan,
            'p7_skema_bayar' => $doc_to_histori->p7_skema_bayar,
            'p7_pemeriksa' => $doc_to_histori->p7_pemeriksa,
            'p7_tembusan' => $doc_to_histori->p7_tembusan,
            'sp_tgl_sp' => $doc_to_histori->sp_tgl_sp,
            'sp_takah_sp' => $doc_to_histori->sp_takah_sp,
            'sp_nomor_kb' => $doc_to_histori->sp_nomor_kb,
            'p8_tgl_p8' => $doc_to_histori->p8_tgl_p8,
            'p8_takah_p8' => $doc_to_histori->p8_takah_p8,
            'wo_tgl_wo' => $doc_to_histori->wo_tgl_wo,
            'wo_takah_wo' => $doc_to_histori->wo_takah_wo,
            'wo_tgl_fo' => $doc_to_histori->wo_tgl_fo,
            'wo_nomor_kb' => $doc_to_histori->wo_nomor_kb,
            'wo_jenis_layanan' => $doc_to_histori->wo_jenis_layanan,
            'wo_jumlah_layanan' => $doc_to_histori->wo_jumlah_layanan,
            'wo_harga_ke_plggn' => $doc_to_histori->wo_harga_ke_plggn,
            'wo_onetime_charge_plggn' => $doc_to_histori->wo_onetime_charge_plggn,
            'wo_monthly_plggn' => $doc_to_histori->wo_monthly_plggn,
            'wo_onetime_charge_telkom' => $doc_to_histori->wo_onetime_charge_telkom,
            'wo_persen_telkom' => $doc_to_histori->wo_persen_telkom,
            'wo_monthly_telkom' => $doc_to_histori->wo_monthly_telkom,
            'wo_onetime_charge_mitra' => $doc_to_histori->wo_onetime_charge_mitra,
            'wo_persen_mitra' => $doc_to_histori->wo_persen_mitra,
            'wo_monthly_mitra' => $doc_to_histori->wo_monthly_mitra,
            'kl_tgl_kl' => $doc_to_histori->kl_tgl_kl,
            'kl_takah_kl' => $doc_to_histori->kl_takah_kl,
            'kl_nomor_kb' => $doc_to_histori->kl_nomor_kb,
            'kl_no_kl_mitra' => $doc_to_histori->kl_no_kl_mitra,
            'kl_tempat_ttd_kl' => $doc_to_histori->kl_tempat_ttd_kl,
            'kl_notaris' => $doc_to_histori->kl_notaris,
            'kl_akta_notaris' => $doc_to_histori->kl_akta_notaris,
            'kl_tgl_akta_notaris' => $doc_to_histori->kl_tgl_akta_notaris,
            'kl_nama_pejabat_telkom' => $doc_to_histori->kl_nama_pejabat_telkom,
            'kl_jabatan_pejabat_telkom' => $doc_to_histori->kl_jabatan_pejabat_telkom,
            'kl_npwp_mitra' => $doc_to_histori->kl_npwp_mitra,
            'kl_no_anggaran_mitra' => $doc_to_histori->kl_no_anggaran_mitra,
            'kl_tgl_anggaran_mitra' => $doc_to_histori->kl_tgl_anggaran_mitra,
            'kl_nama_pejabat_mitra' => $doc_to_histori->kl_nama_pejabat_mitra,
            'kl_jabatan_pejabat_mitra' => $doc_to_histori->kl_jabatan_pejabat_mitra,
            'kl_no_skm' => $doc_to_histori->kl_no_skm,
            'kl_tgl_skm' => $doc_to_histori->kl_tgl_skm,
            'kl_perihal_skm' => $doc_to_histori->kl_perihal_skm,
            'kl_tgl_akhir_kl' => $doc_to_histori->kl_tgl_akhir_kl,
            'kl_bayar_dp' => $doc_to_histori->kl_bayar_dp,
            'kl_nama_bank_mitra' => $doc_to_histori->kl_nama_bank_mitra,
            'kl_cabang_bank_mitra' => $doc_to_histori->kl_cabang_bank_mitra,
            'kl_rek_bank_mitra' => $doc_to_histori->kl_rek_bank_mitra,
            'kl_an_bank_mitra' => $doc_to_histori->kl_an_bank_mitra,
            'file_p2' => $doc_to_histori->file_p2,
            'file_p3' => $doc_to_histori->file_p3,
            'file_p4' => $doc_to_histori->file_p4,
            'file_p5' => $doc_to_histori->file_p5,
            'file_p6' => $doc_to_histori->file_p6,
            'file_p7' => $doc_to_histori->file_p7,
            'file_p8' => $doc_to_histori->file_p8,
            'file_sp' => $doc_to_histori->file_sp,
            'file_wo' => $doc_to_histori->file_wo,
            'file_kl' => $doc_to_histori->file_kl,
            'p0_nomor_p0' => $doc_to_histori->p0_nomor_p0,
            'p0_nik_am' => $doc_to_histori->p0_nik_am,
            'p0_nik_manager' => $doc_to_histori->p0_nik_manager,
            'p0_tgl_submit' => $doc_to_histori->p0_tgl_submit,
            'p0_pemeriksa' => $doc_to_histori->p0_pemeriksa,
            'p0_nik_gm' => $doc_to_histori->p0_nik_gm,
            'p1_nomor_p1' => $doc_to_histori->p1_nomor_p1,
            'p1_tgl_p1' => $doc_to_histori->p1_tgl_p1,
            'p1_pemeriksa' => $doc_to_histori->p1_pemeriksa,
            'p1_tgl_delivery' => $doc_to_histori->p1_tgl_delivery,
            'p1_lokasi_instal' => $doc_to_histori->p1_lokasi_instal,
            'p1_skema_bisnis' => $doc_to_histori->p1_skema_bisnis,
            'p1_skema_bayar' => $doc_to_histori->p1_skema_bayar,
            'p1_mekanisme_bayar' => $doc_to_histori->p1_mekanisme_bayar,
            'p1_tgl_kontrak_mulai' => $doc_to_histori->p1_tgl_kontrak_mulai,
            'p1_tgl_kontrak_akhir' => $doc_to_histori->p1_tgl_kontrak_akhir,
            'p1_tgl_doc_plggn' => $doc_to_histori->p1_tgl_doc_plggn,
            'p1_estimasi_harga' => $doc_to_histori->p1_estimasi_harga,
            'p1_disetujui_gm' => $doc_to_histori->p1_disetujui_gm,
            'p1_dibuat_am' => $doc_to_histori->p1_dibuat_am,
            'p1_diperiksa_manager' => $doc_to_histori->p1_diperiksa_manager,
            'file_p0' => $doc_to_histori->file_p0,
            'file_p1' => $doc_to_histori->file_p1
          ]);

          $doc_to_form_obl = DB::connection('pgsql')->table('form_obl')->where('id',$var_obl_id);
          if( $ada_update_obl==='file_p0' || $ada_update_obl==='file_p1' ){
            if( $ada_update_obl==='file_p0' && $user_in_is->role_id === 4 ){ $hasil_update = $doc_to_form_obl->update(['updated_at'=>Carbon::now()->translatedFormat('Y-m-d H:i:s'),'updated_by'=>Auth::id(),'file_p0'=>$var_nama_file_baru,'submit'=>'am_file_p0']); }
            if( $ada_update_obl==='file_p0' && $user_in_is->role_id === 8 ){ $hasil_update = $doc_to_form_obl->update(['updated_at'=>Carbon::now()->translatedFormat('Y-m-d H:i:s'),'updated_by'=>Auth::id(),'file_p0'=>$var_nama_file_baru,'submit'=>'solution_file_p0']); }
            if( $ada_update_obl==='file_p1' && $user_in_is->role_id === 4 ){ $hasil_update = $doc_to_form_obl->update(['updated_at'=>Carbon::now()->translatedFormat('Y-m-d H:i:s'),'updated_by'=>Auth::id(),'file_p1'=>$var_nama_file_baru,'submit'=>'am_file_p1']); }
            if( $ada_update_obl==='file_p1' && $user_in_is->role_id === 8 ){ $hasil_update = $doc_to_form_obl->update(['updated_at'=>Carbon::now()->translatedFormat('Y-m-d H:i:s'),'updated_by'=>Auth::id(),'file_p1'=>$var_nama_file_baru,'submit'=>'solution_file_p1']); }

            $cek_dulu = DB::connection('pgsql')->table('form_obl')
            ->select('id','p0_tgl_submit','p0_nomor_p0','p1_nomor_p1','p1_tgl_p1','file_p0','file_p1')
            ->where('id',$var_obl_id)
            ->first();
            // revisi_witel is false when DOC & FORMS & FILES exist
            if(
              $cek_dulu->id &&
              $cek_dulu->p0_tgl_submit && $cek_dulu->p0_nomor_p0 &&
              $cek_dulu->p1_tgl_p1 && $cek_dulu->p1_nomor_p1 &&
              $cek_dulu->file_p0 && $cek_dulu->file_p1
            ){
              if($user_in_is->role_id === 4){
                DB::connection('pgsql')->table('form_obl')
                ->where('id',$request->obl_id)
                ->update( [ 'revisi_witel' => false ] );
              }
            }else{
              if($user_in_is->role_id === 4){
                DB::connection('pgsql')->table('form_obl')
                ->where('id',$request->obl_id)
                ->update( [ 'revisi_witel' => true ] );
              }
            }

          }
          if( $ada_update_obl==='file_p2' ){ $hasil_update = $doc_to_form_obl->update(['updated_at'=>Carbon::now()->translatedFormat('Y-m-d H:i:s'),'updated_by'=>Auth::id(),'file_p2'=>$var_nama_file_baru]); }
          if( $ada_update_obl==='file_p3' ){ $hasil_update = $doc_to_form_obl->update(['updated_at'=>Carbon::now()->translatedFormat('Y-m-d H:i:s'),'updated_by'=>Auth::id(),'file_p3'=>$var_nama_file_baru]); }
          if( $ada_update_obl==='file_p4' ){ $hasil_update = $doc_to_form_obl->update(['updated_at'=>Carbon::now()->translatedFormat('Y-m-d H:i:s'),'updated_by'=>Auth::id(),'file_p4'=>$var_nama_file_baru]); }
          if( $ada_update_obl==='file_p5' ){ $hasil_update = $doc_to_form_obl->update(['updated_at'=>Carbon::now()->translatedFormat('Y-m-d H:i:s'),'updated_by'=>Auth::id(),'file_p5'=>$var_nama_file_baru]); }
          if( $ada_update_obl==='file_p6' ){ $hasil_update = $doc_to_form_obl->update(['updated_at'=>Carbon::now()->translatedFormat('Y-m-d H:i:s'),'updated_by'=>Auth::id(),'file_p6'=>$var_nama_file_baru]); }
          if( $ada_update_obl==='file_p7' ){ $hasil_update = $doc_to_form_obl->update(['updated_at'=>Carbon::now()->translatedFormat('Y-m-d H:i:s'),'updated_by'=>Auth::id(),'file_p7'=>$var_nama_file_baru]); }
          if( $ada_update_obl==='file_p8' ){ $hasil_update = $doc_to_form_obl->update(['updated_at'=>Carbon::now()->translatedFormat('Y-m-d H:i:s'),'updated_by'=>Auth::id(),'file_p8'=>$var_nama_file_baru]); }
          if( $ada_update_obl==='file_sp' ){ $hasil_update = $doc_to_form_obl->update(['updated_at'=>Carbon::now()->translatedFormat('Y-m-d H:i:s'),'updated_by'=>Auth::id(),'file_sp'=>$var_nama_file_baru]); }
          if( $ada_update_obl==='file_wo' ){ $hasil_update = $doc_to_form_obl->update(['updated_at'=>Carbon::now()->translatedFormat('Y-m-d H:i:s'),'updated_by'=>Auth::id(),'file_wo'=>$var_nama_file_baru]); }
          if( $ada_update_obl==='file_kl' ){ $hasil_update = $doc_to_form_obl->update(['updated_at'=>Carbon::now()->translatedFormat('Y-m-d H:i:s'),'updated_by'=>Auth::id(),'file_kl'=>$var_nama_file_baru]); }

          if( $hasil_update ){ return $hasil_update; }
          else{ return response()->json(['status'=>'Oops! Gagal Update Form OBL & Histori OBL.']); }
        }
        else{
            return response()->json(['status'=>'Oops! Gagal Cek ID File Upload Untuk Update Form OBL.']);
        }

      }
      catch(Throwable $e){
        return response()->json(['status'=>'Oops! Gagal Proses Update Form OBL @ Database.']);
      }
    }

    public function create(Request $request){
      // DGS-8720-2023
      // dd( $request->all() );
      $user_in_is = User::leftJoin('user_role','user_role.user_id','=','users.id')
      ->leftJoin('witels','witels.id','=','users.witel_id')
      ->leftJoin('user_mitra','user_mitra.user_id','=','users.id')
      ->leftJoin('mitras','mitras.id','=','user_mitra.mitra_id')
      ->select('users.id','user_role.role_id','users.witel_id','witels.nama_witel','mitras.nama_mitra','mitras.id as mitra_id')
      ->where('users.id',Auth::id())->first();

      $tipe_doc_witel1 = 'pdf';
      $tipe_doc_witel2 = 'docx';
      $tipe_doc_upload = 'pdf';
      $pesan_tipe_doc_upload = '';
      if($request->submit_upload_doc_id){
              if($request->hasFile('file_p0')){
                if($request->file('file_p0')->getClientOriginalExtension() !== $tipe_doc_witel1 && $request->file('file_p0')->getClientOriginalExtension() !== $tipe_doc_witel2){ if($pesan_tipe_doc_upload){ $pesan_tipe_doc_upload = $pesan_tipe_doc_upload . '<br> ⊗ File P0 '; }else{ $pesan_tipe_doc_upload = ' ⊗ File P0 '; } }
              }
              if($request->hasFile('file_p1')){
                if($request->file('file_p1')->getClientOriginalExtension() !== $tipe_doc_witel1 && $request->file('file_p1')->getClientOriginalExtension() !== $tipe_doc_witel2){ if($pesan_tipe_doc_upload){ $pesan_tipe_doc_upload = $pesan_tipe_doc_upload . '<br> ⊗ File P1 '; }else{ $pesan_tipe_doc_upload = ' ⊗ File P1 '; } }
              }
              if($request->hasFile('file_p2')){
                if($request->file('file_p2')->getClientOriginalExtension() !== $tipe_doc_upload){ if($pesan_tipe_doc_upload){ $pesan_tipe_doc_upload = $pesan_tipe_doc_upload . '<br> ⊗ File P2 '; }else{ $pesan_tipe_doc_upload = ' ⊗ File P2 '; } }
              }
              if($request->hasFile('file_p3')){
                if($request->file('file_p3')->getClientOriginalExtension() !== $tipe_doc_upload){ if($pesan_tipe_doc_upload){ $pesan_tipe_doc_upload = $pesan_tipe_doc_upload . '<br> ⊗ File P3 '; }else{ $pesan_tipe_doc_upload = ' ⊗ File P3 '; } }
              }
              if($request->hasFile('file_p4')){
                if($request->file('file_p4')->getClientOriginalExtension() !== $tipe_doc_upload){ if($pesan_tipe_doc_upload){ $pesan_tipe_doc_upload = $pesan_tipe_doc_upload . '<br> ⊗ File P4 '; }else{ $pesan_tipe_doc_upload = ' ⊗ File P4 '; } }
              }
              if($request->hasFile('file_p5')){
                if($request->file('file_p5')->getClientOriginalExtension() !== $tipe_doc_upload){ if($pesan_tipe_doc_upload){ $pesan_tipe_doc_upload = $pesan_tipe_doc_upload . '<br> ⊗ File P5 '; }else{ $pesan_tipe_doc_upload = ' ⊗ File P5 '; } }
              }
              if($request->hasFile('file_p6')){
                if($request->file('file_p6')->getClientOriginalExtension() !== $tipe_doc_upload){ if($pesan_tipe_doc_upload){ $pesan_tipe_doc_upload = $pesan_tipe_doc_upload . '<br> ⊗ File P6 '; }else{ $pesan_tipe_doc_upload = ' ⊗ File P6 '; } }
              }
              if($request->hasFile('file_p7')){
                if($request->file('file_p7')->getClientOriginalExtension() !== $tipe_doc_upload){ if($pesan_tipe_doc_upload){ $pesan_tipe_doc_upload = $pesan_tipe_doc_upload . '<br> ⊗ File P7 '; }else{ $pesan_tipe_doc_upload = ' ⊗ File P7 '; } }
              }
              if($request->hasFile('file_p8')){
                if($request->file('file_p8')->getClientOriginalExtension() !== $tipe_doc_upload){ if($pesan_tipe_doc_upload){ $pesan_tipe_doc_upload = $pesan_tipe_doc_upload . '<br> ⊗ File P8 '; }else{ $pesan_tipe_doc_upload = ' ⊗ File P8 '; } }
              }
              if($request->hasFile('file_sp')){
                if($request->file('file_sp')->getClientOriginalExtension() !== $tipe_doc_upload){ if($pesan_tipe_doc_upload){ $pesan_tipe_doc_upload = $pesan_tipe_doc_upload . '<br> ⊗ File SP '; }else{ $pesan_tipe_doc_upload = ' ⊗ File SP '; } }
              }
              if($request->hasFile('file_wo')){
                if($request->file('file_wo')->getClientOriginalExtension() !== $tipe_doc_upload){ if($pesan_tipe_doc_upload){ $pesan_tipe_doc_upload = $pesan_tipe_doc_upload . '<br> ⊗ File WO '; }else{ $pesan_tipe_doc_upload = ' ⊗ File WO '; } }
              }
              if($request->hasFile('file_kl')){
                if($request->file('file_kl')->getClientOriginalExtension() !== $tipe_doc_upload){ if($pesan_tipe_doc_upload){ $pesan_tipe_doc_upload = $pesan_tipe_doc_upload . '<br> ⊗ File KL '; }else{ $pesan_tipe_doc_upload = ' ⊗ File KL '; } }
              }


              if( $pesan_tipe_doc_upload ){
                if( $user_in_is->role_id === 2 || $user_in_is->role_id === 9 ){
                  return response()->json(['status'=>'Oops!<br>'.$pesan_tipe_doc_upload.' <br> Bukan Format '.strtoupper($tipe_doc_upload).' (.'.$tipe_doc_upload.')']);
                }
                if( $user_in_is->role_id === 4 || $user_in_is->role_id === 8 ){
                  return response()->json(['status'=>'Oops!<br>'.$pesan_tipe_doc_upload.' <br> Bukan Format '.strtoupper($tipe_doc_witel1).'/'.strtoupper($tipe_doc_witel2).' (.'.$tipe_doc_witel1.'/'.$tipe_doc_witel2.')']);
                }
              }
              else{
                if( $user_in_is->role_id === 2 || $user_in_is->role_id === 9 ){
                  if( !$request->hasFile('file_p2') && !$request->hasFile('file_p3') && !$request->hasFile('file_p4') && !$request->hasFile('file_p5') && !$request->hasFile('file_p6') && !$request->hasFile('file_p7')
                  && !$request->hasFile('file_p8') && !$request->hasFile('file_sp') && !$request->hasFile('file_wo') && !$request->hasFile('file_kl') )
                  {
                    return response()->json(['status'=>'Tidak Ada File Untuk Proses Upload']);
                  }
                }
                if( $user_in_is->role_id === 4 || $user_in_is->role_id === 8 ){
                  if( !$request->hasFile('file_p0') && !$request->hasFile('file_p1') )
                  {
                    return response()->json(['status'=>'Tidak Ada File Untuk Proses Upload']);
                  }
                }
              }

            try{
              $hasil_proses_upload = null;
              if($request->hasFile('file_p0')) {
                  $filenametostore = $this->generateUniqueId() . '.' . $request->file('file_p0')->getClientOriginalExtension();
                  Storage::disk('sftp')->put( $filenametostore, fopen( $request->file('file_p0'), 'r+') );
                  $hasil_proses_upload = $this->updateNamaFile($request->submit_upload_doc_id,'file_p0',$filenametostore);
              }
              if($request->hasFile('file_p1')) {
                  $filenametostore = $this->generateUniqueId() . '.' . $request->file('file_p1')->getClientOriginalExtension();
                  Storage::disk('sftp')->put( $filenametostore, fopen( $request->file('file_p1'), 'r+') );
                  $hasil_proses_upload = $this->updateNamaFile($request->submit_upload_doc_id,'file_p1',$filenametostore);
              }
              if($request->hasFile('file_p2')) {
                  $filenametostore = $this->generateUniqueId() . '.' . $request->file('file_p2')->getClientOriginalExtension();
                  Storage::disk('sftp')->put( $filenametostore, fopen( $request->file('file_p2'), 'r+') );
                  $hasil_proses_upload = $this->updateNamaFile($request->submit_upload_doc_id,'file_p2',$filenametostore);
              }
              if($request->hasFile('file_p3')) {
                  $filenametostore = $this->generateUniqueId() . '.' . $request->file('file_p3')->getClientOriginalExtension();
                  Storage::disk('sftp')->put( $filenametostore, fopen( $request->file('file_p3'), 'r+') );
                  $hasil_proses_upload = $this->updateNamaFile($request->submit_upload_doc_id,'file_p3',$filenametostore);
              }
              if($request->hasFile('file_p4')) {
                $filenametostore = $this->generateUniqueId() . '.' . $request->file('file_p4')->getClientOriginalExtension();
                Storage::disk('sftp')->put( $filenametostore, fopen( $request->file('file_p4'), 'r+') );
                $hasil_proses_upload = $this->updateNamaFile($request->submit_upload_doc_id,'file_p4',$filenametostore);
              }
              if($request->hasFile('file_p5')) {
                $filenametostore = $this->generateUniqueId() . '.' . $request->file('file_p5')->getClientOriginalExtension();
                Storage::disk('sftp')->put( $filenametostore, fopen( $request->file('file_p5'), 'r+') );
                $hasil_proses_upload = $this->updateNamaFile($request->submit_upload_doc_id,'file_p5',$filenametostore);
              }
              if($request->hasFile('file_p6')) {
                $filenametostore = $this->generateUniqueId() . '.' . $request->file('file_p6')->getClientOriginalExtension();
                Storage::disk('sftp')->put( $filenametostore, fopen( $request->file('file_p6'), 'r+') );
                $hasil_proses_upload = $this->updateNamaFile($request->submit_upload_doc_id,'file_p6',$filenametostore);
              }
              if($request->hasFile('file_p7')) {
                $filenametostore = $this->generateUniqueId() . '.' . $request->file('file_p7')->getClientOriginalExtension();
                Storage::disk('sftp')->put( $filenametostore, fopen( $request->file('file_p7'), 'r+') );
                $hasil_proses_upload = $this->updateNamaFile($request->submit_upload_doc_id,'file_p7',$filenametostore);
              }
              if($request->hasFile('file_p8')) {
                $filenametostore = $this->generateUniqueId() . '.' . $request->file('file_p8')->getClientOriginalExtension();
                Storage::disk('sftp')->put( $filenametostore, fopen( $request->file('file_p8'), 'r+') );
                $hasil_proses_upload = $this->updateNamaFile($request->submit_upload_doc_id,'file_p8',$filenametostore);
              }
              if($request->hasFile('file_sp')) {
                $filenametostore = $this->generateUniqueId() . '.' . $request->file('file_sp')->getClientOriginalExtension();
                Storage::disk('sftp')->put( $filenametostore, fopen( $request->file('file_sp'), 'r+') );
                $hasil_proses_upload = $this->updateNamaFile($request->submit_upload_doc_id,'file_sp',$filenametostore);
              }
              if($request->hasFile('file_wo')) {
                $filenametostore = $this->generateUniqueId() . '.' . $request->file('file_wo')->getClientOriginalExtension();
                Storage::disk('sftp')->put( $filenametostore, fopen( $request->file('file_wo'), 'r+') );
                $hasil_proses_upload = $this->updateNamaFile($request->submit_upload_doc_id,'file_wo',$filenametostore);
              }
              if($request->hasFile('file_kl')) {
                $filenametostore = $this->generateUniqueId() . '.' . $request->file('file_kl')->getClientOriginalExtension();
                Storage::disk('sftp')->put( $filenametostore, fopen( $request->file('file_kl'), 'r+') );
                $hasil_proses_upload = $this->updateNamaFile($request->submit_upload_doc_id,'file_kl',$filenametostore);
              }

              if( $hasil_proses_upload ){ return response()->json(['status'=>'Sukses Upload File.']); }
              else{ return response()->json(['status'=>'Oops! Gagal Proses Upload File.']); }
            }
            catch(Throwable $e){
              return response()->json(['status'=>'Oops! Gagal Upload File.']);
            }

        }
        else{ return response()->json(['status'=>'Oops! Wrong Routing.']); }
    }

}
