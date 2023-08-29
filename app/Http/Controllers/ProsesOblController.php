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
   public function ubahProsesDoc($var_obl_id,$var_nama_proses){
     try{
       $cek_dulu = DB::connection('pgsql')->table('form_obl')->select('*')->where('id',$var_obl_id)->first();
       DB::connection('pgsql')->table('form_obl_histori')
       ->insert([
         'obl_id' => $cek_dulu->id,
         'submit' => $cek_dulu->submit,
         'revisi_witel' => $cek_dulu->revisi_witel,
         'revisi_witel_count' => $cek_dulu->revisi_witel_count,
         'is_draf' => $cek_dulu->is_draf,
         'updated_at' => $cek_dulu->updated_at,
         'updated_by' => $cek_dulu->updated_by,
         'f1_nama_plggn' => $cek_dulu->f1_nama_plggn,
         'f1_alamat_plggn' => $cek_dulu->f1_alamat_plggn,
         'f1_witel' => $cek_dulu->f1_witel,
         'f1_judul_projek' => $cek_dulu->f1_judul_projek,
         'f1_segmen' => $cek_dulu->f1_segmen,
         'f1_proses' => $cek_dulu->f1_proses,
         'f1_folder' => $cek_dulu->f1_folder,
         'f1_nilai_kb' => $cek_dulu->f1_nilai_kb,
         'f1_no_kfs_spk' => $cek_dulu->f1_no_kfs_spk,
         'f1_quote_kontrak' => $cek_dulu->f1_quote_kontrak,
         'f1_nomor_akun' => $cek_dulu->f1_nomor_akun,
         'f1_jenis_kontrak' => $cek_dulu->f1_jenis_kontrak,
         'f1_skema_bayar' => $cek_dulu->f1_skema_bayar,
         'f1_status_order' => $cek_dulu->f1_status_order,
         'f1_status_sm' => $cek_dulu->f1_status_sm,
         'f1_tgl_keterangan' => $cek_dulu->f1_tgl_keterangan,
         'f1_keterangan' => $cek_dulu->f1_keterangan,
         'f1_mitra_id' => $cek_dulu->f1_mitra_id,
         'f1_pic_mitra' => $cek_dulu->f1_pic_mitra,
         'f1_jenis_spk' => $cek_dulu->f1_jenis_spk,
         'f1_masa_layanan_tahun' => $cek_dulu->f1_masa_layanan_tahun,
         'f1_masa_layanan_bulan' => $cek_dulu->f1_masa_layanan_bulan,
         'f1_masa_layanan_hari' => $cek_dulu->f1_masa_layanan_hari,
         'f1_pic_plggn' => $cek_dulu->f1_pic_plggn,
         'f2_nilai_kontrak' => $cek_dulu->f2_nilai_kontrak,
         'f2_tgl_p1' => $cek_dulu->f2_tgl_p1,
         'p2_tgl_p2' => $cek_dulu->p2_tgl_p2,
         'p2_tgl_justifikasi' => $cek_dulu->p2_tgl_justifikasi,
         'p2_dievaluasi_oleh' => $cek_dulu->p2_dievaluasi_oleh,
         'p2_disetujui_oleh' => $cek_dulu->p2_disetujui_oleh,
         'p2_pilihan_catatan' => $cek_dulu->p2_pilihan_catatan,
         'p2_catatan' => $cek_dulu->p2_catatan,
         'p3_tgl_p3' => $cek_dulu->p3_tgl_p3,
         'p3_takah_p3' => $cek_dulu->p3_takah_p3,
         'p3_pejabat_mitra_nama' => $cek_dulu->p3_pejabat_mitra_nama,
         'p3_pejabat_mitra_alamat' => $cek_dulu->p3_pejabat_mitra_alamat,
         'p3_pejabat_mitra_telepon' => $cek_dulu->p3_pejabat_mitra_telepon,
         'p3_status_rapat_pengadaan' => $cek_dulu->p3_status_rapat_pengadaan,
         'p3_tgl_rapat_pengadaan' => $cek_dulu->p3_tgl_rapat_pengadaan,
         'p3_tmpt_rapat_pengadaan' => $cek_dulu->p3_tmpt_rapat_pengadaan,
         'p3_tgl_terima_sp' => $cek_dulu->p3_tgl_terima_sp,
         'p3_alamat_terima_sp' => $cek_dulu->p3_alamat_terima_sp,
         'p3_manager_obl' => $cek_dulu->p3_manager_obl,
         'p4_tgl_p4' => $cek_dulu->p4_tgl_p4,
         'p4_waktu_layanan' => $cek_dulu->p4_waktu_layanan,
         'p4_skema_bisnis' => $cek_dulu->p4_skema_bisnis,
         'p4_mekanisme_pembayaran' => $cek_dulu->p4_mekanisme_pembayaran,
         'p4_slg' => $cek_dulu->p4_slg,
         'p4_fasilitator' => $cek_dulu->p4_fasilitator,
         'p4_pengesahan' => $cek_dulu->p4_pengesahan,
         'p5_tgl_p5' => $cek_dulu->p5_tgl_p5,
         'p5_harga_penawaran' => $cek_dulu->p5_harga_penawaran,
         'p5_ttd_evaluator' => $cek_dulu->p5_ttd_evaluator,
         'p6_tgl_p6' => $cek_dulu->p6_tgl_p6,
         'p6_ttd_bast_telkom' => $cek_dulu->p6_ttd_bast_telkom,
         'p6_ttd_bast_mitra' => $cek_dulu->p6_ttd_bast_mitra,
         'p6_harga_negosiasi' => $cek_dulu->p6_harga_negosiasi,
         'p6_nama_peserta_mitra' => $cek_dulu->p6_nama_peserta_mitra,
         'p6_jabatan_peserta_mitra' => $cek_dulu->p6_jabatan_peserta_mitra,
         'p6_peserta_rapat_telkom' => $cek_dulu->p6_peserta_rapat_telkom,
         'p6_pengesahan' => $cek_dulu->p6_pengesahan,
         'p7_tgl_p7' => $cek_dulu->p7_tgl_p7,
         'p7_takah_p7' => $cek_dulu->p7_takah_p7,
         'p7_lampiran_berkas' => $cek_dulu->p7_lampiran_berkas,
         'p7_harga_pekerjaan' => $cek_dulu->p7_harga_pekerjaan,
         'p7_skema_bayar' => $cek_dulu->p7_skema_bayar,
         'p7_pemeriksa' => $cek_dulu->p7_pemeriksa,
         'p7_tembusan' => $cek_dulu->p7_tembusan,
         'sp_tgl_sp' => $cek_dulu->sp_tgl_sp,
         'sp_takah_sp' => $cek_dulu->sp_takah_sp,
         'sp_nomor_kb' => $cek_dulu->sp_nomor_kb,
         'p8_tgl_p8' => $cek_dulu->p8_tgl_p8,
         'p8_takah_p8' => $cek_dulu->p8_takah_p8,
         'wo_tgl_wo' => $cek_dulu->wo_tgl_wo,
         'wo_takah_wo' => $cek_dulu->wo_takah_wo,
         'wo_tgl_fo' => $cek_dulu->wo_tgl_fo,
         'wo_nomor_kb' => $cek_dulu->wo_nomor_kb,
         'wo_jenis_layanan' => $cek_dulu->wo_jenis_layanan,
         'wo_jumlah_layanan' => $cek_dulu->wo_jumlah_layanan,
         'wo_harga_ke_plggn' => $cek_dulu->wo_harga_ke_plggn,
         'wo_onetime_charge_plggn' => $cek_dulu->wo_onetime_charge_plggn,
         'wo_monthly_plggn' => $cek_dulu->wo_monthly_plggn,
         'wo_onetime_charge_telkom' => $cek_dulu->wo_onetime_charge_telkom,
         'wo_persen_telkom' => $cek_dulu->wo_persen_telkom,
         'wo_monthly_telkom' => $cek_dulu->wo_monthly_telkom,
         'wo_onetime_charge_mitra' => $cek_dulu->wo_onetime_charge_mitra,
         'wo_persen_mitra' => $cek_dulu->wo_persen_mitra,
         'wo_monthly_mitra' => $cek_dulu->wo_monthly_mitra,
         'kl_tgl_kl' => $cek_dulu->kl_tgl_kl,
         'kl_takah_kl' => $cek_dulu->kl_takah_kl,
         'kl_nomor_kb' => $cek_dulu->kl_nomor_kb,
         'kl_no_kl_mitra' => $cek_dulu->kl_no_kl_mitra,
         'kl_tempat_ttd_kl' => $cek_dulu->kl_tempat_ttd_kl,
         'kl_notaris' => $cek_dulu->kl_notaris,
         'kl_akta_notaris' => $cek_dulu->kl_akta_notaris,
         'kl_tgl_akta_notaris' => $cek_dulu->kl_tgl_akta_notaris,
         'kl_nama_pejabat_telkom' => $cek_dulu->kl_nama_pejabat_telkom,
         'kl_jabatan_pejabat_telkom' => $cek_dulu->kl_jabatan_pejabat_telkom,
         'kl_npwp_mitra' => $cek_dulu->kl_npwp_mitra,
         'kl_no_anggaran_mitra' => $cek_dulu->kl_no_anggaran_mitra,
         'kl_tgl_anggaran_mitra' => $cek_dulu->kl_tgl_anggaran_mitra,
         'kl_nama_pejabat_mitra' => $cek_dulu->kl_nama_pejabat_mitra,
         'kl_jabatan_pejabat_mitra' => $cek_dulu->kl_jabatan_pejabat_mitra,
         'kl_no_skm' => $cek_dulu->kl_no_skm,
         'kl_tgl_skm' => $cek_dulu->kl_tgl_skm,
         'kl_perihal_skm' => $cek_dulu->kl_perihal_skm,
         'kl_tgl_akhir_kl' => $cek_dulu->kl_tgl_akhir_kl,
         'kl_bayar_dp' => $cek_dulu->kl_bayar_dp,
         'kl_nama_bank_mitra' => $cek_dulu->kl_nama_bank_mitra,
         'kl_cabang_bank_mitra' => $cek_dulu->kl_cabang_bank_mitra,
         'kl_rek_bank_mitra' => $cek_dulu->kl_rek_bank_mitra,
         'kl_an_bank_mitra' => $cek_dulu->kl_an_bank_mitra,
         'file_p2' => $cek_dulu->file_p2,
         'file_p3' => $cek_dulu->file_p3,
         'file_p4' => $cek_dulu->file_p4,
         'file_p5' => $cek_dulu->file_p5,
         'file_p6' => $cek_dulu->file_p6,
         'file_p7' => $cek_dulu->file_p7,
         'file_p8' => $cek_dulu->file_p8,
         'file_sp' => $cek_dulu->file_sp,
         'file_wo' => $cek_dulu->file_wo,
         'file_kl' => $cek_dulu->file_kl,
         'p0_nomor_p0' => $cek_dulu->p0_nomor_p0,
         'p0_nik_am' => $cek_dulu->p0_nik_am,
         'p0_nik_manager' => $cek_dulu->p0_nik_manager,
         'p0_tgl_submit' => $cek_dulu->p0_tgl_submit,
         'p0_pemeriksa' => $cek_dulu->p0_pemeriksa,
         'p0_nik_gm' => $cek_dulu->p0_nik_gm,
         'p1_nomor_p1' => $cek_dulu->p1_nomor_p1,
         'p1_tgl_p1' => $cek_dulu->p1_tgl_p1,
         'p1_pemeriksa' => $cek_dulu->p1_pemeriksa,
         'p1_tgl_delivery' => $cek_dulu->p1_tgl_delivery,
         'p1_lokasi_instal' => $cek_dulu->p1_lokasi_instal,
         'p1_skema_bisnis' => $cek_dulu->p1_skema_bisnis,
         'p1_skema_bayar' => $cek_dulu->p1_skema_bayar,
         'p1_mekanisme_bayar' => $cek_dulu->p1_mekanisme_bayar,
         'p1_tgl_kontrak_mulai' => $cek_dulu->p1_tgl_kontrak_mulai,
         'p1_tgl_kontrak_akhir' => $cek_dulu->p1_tgl_kontrak_akhir,
         'p1_tgl_doc_plggn' => $cek_dulu->p1_tgl_doc_plggn,
         'p1_estimasi_harga' => $cek_dulu->p1_estimasi_harga,
         'p1_disetujui_gm' => $cek_dulu->p1_disetujui_gm,
         'p1_dibuat_am' => $cek_dulu->p1_dibuat_am,
         'p1_diperiksa_manager' => $cek_dulu->p1_diperiksa_manager,
         'file_p0' => $cek_dulu->file_p0,
         'file_p1' => $cek_dulu->file_p1
       ]);
       DB::connection('pgsql')->table('form_obl')->where('id',$var_obl_id)
       ->update([
         'updated_by' => Auth::id(),
         'updated_at' => Carbon::now()->translatedFormat('Y-m-d H:i:s'),
         'f1_proses' => $var_nama_proses,
         'f1_tgl_keterangan' => Carbon::now()->translatedFormat('Y-m-d H:i:s'),
         'f1_keterangan' => 'OBL UPDATED PROSES: ' . strtoupper($var_nama_proses)
       ]);
     }
     catch(Throwable $e){ return redirect()->route('obl.tables')->with('status', 'Oops! Gagal Ubah Proses Dokumen.'); }
     return redirect()->route('obl.tables')->with('status', 'Sukses Ubah Proses Dokumen: '. strtoupper($var_nama_proses) .'.');
   }

   public function prosesWitel(Request $request){
     if($request->proses_witel_obl_id){
       $this->ubahProsesDoc($request->proses_witel_obl_id,'witel');
     }
     else{ return redirect()->route('obl.tables')->with('status', 'Oops! Gagal Cek ID Dokumen OBL.'); }
   }

   public function prosesObl(Request $request){
     if($request->proses_obl_id){
       $this->ubahProsesDoc($request->proses_obl_id,'obl');
     }
     else{ return redirect()->route('obl.tables')->with('status', 'Oops! Gagal Cek ID Dokumen OBL.'); }
   }

   public function legalObl(Request $request){
     if($request->legal_obl_id){
       $this->ubahProsesDoc($request->legal_obl_id,'legal');
     }
     else{ return redirect()->route('obl.tables')->with('status', 'Oops! Gagal Cek ID Dokumen OBL.'); }
   }

   public function mitraObl(Request $request){
     if($request->mitra_obl_id){
       $this->ubahProsesDoc($request->mitra_obl_id,'mitra_obl');
     }
     else{ return redirect()->route('obl.tables')->with('status', 'Oops! Gagal Cek ID Dokumen OBL.'); }
   }

   public function closesmObl(Request $request){
     if($request->closesm_obl_id){
       $this->ubahProsesDoc($request->closesm_obl_id,'close_sm');
     }
     else{ return redirect()->route('obl.tables')->with('status', 'Oops! Gagal Cek ID Dokumen OBL.'); }
   }

   public function doneObl(Request $request){
     if($request->done_obl_id){
       $this->ubahProsesDoc($request->done_obl_id,'done');
     }
     else{ return redirect()->route('obl.tables')->with('status', 'Oops! Gagal Cek ID Dokumen OBL.'); }
   }

   public function cancelObl(Request $request){
     if($request->cancel_obl_id){
       $this->ubahProsesDoc($request->cancel_obl_id,'cancel');
     }
     else{ return redirect()->route('obl.tables')->with('status', 'Oops! Gagal Cek ID Dokumen OBL.'); }
   }

}
