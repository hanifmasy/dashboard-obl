<?php

namespace App\Http\Middleware;

use Closure;
Use Str;
Use Hash;
use Illuminate\Http\Request;
use App\Exceptions\Handler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;

class SubmitWitel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
          $created_by = Auth::id();
          $created_by_witel = User::leftJoin('witels','witels.id','=','users.witel_id')->select('users.id','users.witel_id','witels.nama_witel','witels.gm_witel')->where('users.id',Auth::id())->first();
          $created_at = Carbon::now()->translatedFormat('Y-m-d H:i:s');

          if($request->submit){
            if($request->submit == 'submit_witel'){
              $inputan_masuk = [];
              $inputan_masuk['f1_quote_kontrak'] = 'required';
              $inputan_masuk['f1_segmen'] = 'required';
              $inputan_masuk['f1_judul_projek'] = 'required';
              $inputan_masuk['f1_nama_plggn'] = 'required';
              $inputan_masuk['f1_mitra_id'] = 'required';
              $validasi = $request->all();
              $validator_draf = Validator::make($validasi,$inputan_masuk);
              if($validator_draf->fails()){ return back()->withErrors($validator_draf)->withInput(); }

              try{
                $nama_folder = '';
                $temp_folder_old_name = '';
                $temp_folder_old_id = '';
                // CEK QUOTE KONTRAK UNTUK NAMA FOLDER
                $hari = Carbon::now();
                $hari_ini = $hari->dayOfYear;
                $tahun_ini = $hari->year;
                $tahun_ini = strval($tahun_ini);
                $hari_ini = ($hari_ini*40);
                $cek_quote_kontrak = DB::connection('pgsql')->table('form_obl')->select('id','f1_folder')->where('f1_quote_kontrak',$request->f1_quote_kontrak)->orderBy('created_at','DESC')->first();
                if( $cek_quote_kontrak ){ // JIKA QUOTE ADA
                  $cek_quote_kontrak_numeric = preg_replace("/ *[A-Za-z].*/s", "",$cek_quote_kontrak->f1_folder);
                  $cek_quote_kontrak_alphabet = preg_replace("/[^a-zA-Z]+/", "", $cek_quote_kontrak->f1_folder);
                  if( $cek_quote_kontrak_alphabet !== "" ){
                    $cek_quote_kontrak_alphabet++; $nama_folder = $cek_quote_kontrak_numeric . $cek_quote_kontrak_alphabet;
                  }
                  else if($cek_quote_kontrak_alphabet===""){
                    $temp_folder_old_id = $cek_quote_kontrak->id;
                    $temp_alphabet = 'A';
                    $temp_folder_old_name = $cek_quote_kontrak->f1_folder . $temp_alphabet;
                    $temp_alphabet++;
                    $nama_folder = $cek_quote_kontrak_numeric . $temp_alphabet;
                  }
                }
                else{ // JIKA QUOTE TIDAK ADA
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
                }

                // PENAMAAN P7 TEMBUSAN GM WITEL
                $gm_witel = '';
                if($created_by_witel->nama_witel){
                    $cek_gm_witel = DB::connection('pgsql')->table('witels')->select('gm_witel')->where('nama_witel',$created_by_witel->nama_witel)->first();
                    if($cek_gm_witel){ $gm_witel = $cek_gm_witel->gm_witel; }
                    else{ $gm_witel = '[ GM WITEL ]'; }
                }

                // GET ALL INPUTS
                $collection = collect($request->all());
                $filtered = $collection->except([
                    '_token'
                ]);
                $filtered->put('created_by',$created_by);
                $filtered->put('created_at',$created_at);
                $filtered->put('updated_by',$created_by);
                $filtered->put('updated_at',$created_at);
                $filtered->put('revisi_witel',false);
                $filtered->put('revisi_witel_count',0);
                $filtered->put('f1_proses','witel');
                $filtered->put('f1_witel',$created_by_witel->nama_witel);
                $filtered->put('f1_folder',$nama_folder);
                if($created_by_witel->nama_witel){ $filtered->put('p7_tembusan',$gm_witel); }

                if($temp_folder_old_name && $temp_folder_old_id){
                  $temp_folder_old = DB::connection('pgsql')->table('form_obl')
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
                    'file_kl'
                    )
                  ->where('id',$temp_folder_old_id)
                  ->first();
                  DB::connection('pgsql')->table('form_obl_histori')
                  ->insert([
                    'obl_id' => $temp_folder_old->id,
                    'submit' => $temp_folder_old->submit,
                    'revisi_witel' => $temp_folder_old->revisi_witel,
                    'revisi_witel_count' => $temp_folder_old->revisi_witel_count,
                    'is_draf' => $temp_folder_old->is_draf,
                    'updated_at' => $temp_folder_old->updated_at,
                    'updated_by' => $temp_folder_old->updated_by,
                    'f1_nama_plggn' => $temp_folder_old->f1_nama_plggn,
                    'f1_alamat_plggn' => $temp_folder_old->f1_alamat_plggn,
                    'f1_witel' => $temp_folder_old->f1_witel,
                    'f1_judul_projek' => $temp_folder_old->f1_judul_projek,
                    'f1_segmen' => $temp_folder_old->f1_segmen,
                    'f1_proses' => $temp_folder_old->f1_proses,
                    'f1_folder' => $temp_folder_old->f1_folder,
                    'f1_nilai_kb' => $temp_folder_old->f1_nilai_kb,
                    'f1_no_kfs_spk' => $temp_folder_old->f1_no_kfs_spk,
                    'f1_quote_kontrak' => $temp_folder_old->f1_quote_kontrak,
                    'f1_nomor_akun' => $temp_folder_old->f1_nomor_akun,
                    'f1_jenis_kontrak' => $temp_folder_old->f1_jenis_kontrak,
                    'f1_skema_bayar' => $temp_folder_old->f1_skema_bayar,
                    'f1_status_order' => $temp_folder_old->f1_status_order,
                    'f1_status_sm' => $temp_folder_old->f1_status_sm,
                    'f1_tgl_keterangan' => $temp_folder_old->f1_tgl_keterangan,
                    'f1_keterangan' => $temp_folder_old->f1_keterangan,
                    'f1_mitra_id' => $temp_folder_old->f1_mitra_id,
                    'f1_pic_mitra' => $temp_folder_old->f1_pic_mitra,
                    'f1_jenis_spk' => $temp_folder_old->f1_jenis_spk,
                    'f1_masa_layanan_tahun' => $temp_folder_old->f1_masa_layanan_tahun,
                    'f1_masa_layanan_bulan' => $temp_folder_old->f1_masa_layanan_bulan,
                    'f1_masa_layanan_hari' => $temp_folder_old->f1_masa_layanan_hari,
                    'f1_pic_plggn' => $temp_folder_old->f1_pic_plggn,
                    'f2_nilai_kontrak' => $temp_folder_old->f2_nilai_kontrak,
                    'f2_tgl_p1' => $temp_folder_old->f2_tgl_p1,
                    'p2_tgl_p2' => $temp_folder_old->p2_tgl_p2,
                    'p2_tgl_justifikasi' => $temp_folder_old->p2_tgl_justifikasi,
                    'p2_dievaluasi_oleh' => $temp_folder_old->p2_dievaluasi_oleh,
                    'p2_disetujui_oleh' => $temp_folder_old->p2_disetujui_oleh,
                    'p2_pilihan_catatan' => $temp_folder_old->p2_pilihan_catatan,
                    'p2_catatan' => $temp_folder_old->p2_catatan,
                    'p3_tgl_p3' => $temp_folder_old->p3_tgl_p3,
                    'p3_takah_p3' => $temp_folder_old->p3_takah_p3,
                    'p3_pejabat_mitra_nama' => $temp_folder_old->p3_pejabat_mitra_nama,
                    'p3_pejabat_mitra_alamat' => $temp_folder_old->p3_pejabat_mitra_alamat,
                    'p3_pejabat_mitra_telepon' => $temp_folder_old->p3_pejabat_mitra_telepon,
                    'p3_status_rapat_pengadaan' => $temp_folder_old->p3_status_rapat_pengadaan,
                    'p3_tgl_rapat_pengadaan' => $temp_folder_old->p3_tgl_rapat_pengadaan,
                    'p3_tmpt_rapat_pengadaan' => $temp_folder_old->p3_tmpt_rapat_pengadaan,
                    'p3_tgl_terima_sp' => $temp_folder_old->p3_tgl_terima_sp,
                    'p3_alamat_terima_sp' => $temp_folder_old->p3_alamat_terima_sp,
                    'p3_manager_obl' => $temp_folder_old->p3_manager_obl,
                    'p4_tgl_p4' => $temp_folder_old->p4_tgl_p4,
                    'p4_waktu_layanan' => $temp_folder_old->p4_waktu_layanan,
                    'p4_skema_bisnis' => $temp_folder_old->p4_skema_bisnis,
                    'p4_mekanisme_pembayaran' => $temp_folder_old->p4_mekanisme_pembayaran,
                    'p4_slg' => $temp_folder_old->p4_slg,
                    'p4_fasilitator' => $temp_folder_old->p4_fasilitator,
                    'p4_pengesahan' => $temp_folder_old->p4_pengesahan,
                    'p5_tgl_p5' => $temp_folder_old->p5_tgl_p5,
                    'p5_harga_penawaran' => $temp_folder_old->p5_harga_penawaran,
                    'p5_ttd_evaluator' => $temp_folder_old->p5_ttd_evaluator,
                    'p6_tgl_p6' => $temp_folder_old->p6_tgl_p6,
                    'p6_ttd_bast_telkom' => $temp_folder_old->p6_ttd_bast_telkom,
                    'p6_ttd_bast_mitra' => $temp_folder_old->p6_ttd_bast_mitra,
                    'p6_harga_negosiasi' => $temp_folder_old->p6_harga_negosiasi,
                    'p6_nama_peserta_mitra' => $temp_folder_old->p6_nama_peserta_mitra,
                    'p6_jabatan_peserta_mitra' => $temp_folder_old->p6_jabatan_peserta_mitra,
                    'p6_peserta_rapat_telkom' => $temp_folder_old->p6_peserta_rapat_telkom,
                    'p6_pengesahan' => $temp_folder_old->p6_pengesahan,
                    'p7_tgl_p7' => $temp_folder_old->p7_tgl_p7,
                    'p7_takah_p7' => $temp_folder_old->p7_takah_p7,
                    'p7_lampiran_berkas' => $temp_folder_old->p7_lampiran_berkas,
                    'p7_harga_pekerjaan' => $temp_folder_old->p7_harga_pekerjaan,
                    'p7_skema_bayar' => $temp_folder_old->p7_skema_bayar,
                    'p7_pemeriksa' => $temp_folder_old->p7_pemeriksa,
                    'p7_tembusan' => $temp_folder_old->p7_tembusan,
                    'sp_tgl_sp' => $temp_folder_old->sp_tgl_sp,
                    'sp_takah_sp' => $temp_folder_old->sp_takah_sp,
                    'sp_nomor_kb' => $temp_folder_old->sp_nomor_kb,
                    'p8_tgl_p8' => $temp_folder_old->p8_tgl_p8,
                    'p8_takah_p8' => $temp_folder_old->p8_takah_p8,
                    'wo_tgl_wo' => $temp_folder_old->wo_tgl_wo,
                    'wo_takah_wo' => $temp_folder_old->wo_takah_wo,
                    'wo_tgl_fo' => $temp_folder_old->wo_tgl_fo,
                    'wo_nomor_kb' => $temp_folder_old->wo_nomor_kb,
                    'wo_jenis_layanan' => $temp_folder_old->wo_jenis_layanan,
                    'wo_jumlah_layanan' => $temp_folder_old->wo_jumlah_layanan,
                    'wo_harga_ke_plggn' => $temp_folder_old->wo_harga_ke_plggn,
                    'wo_onetime_charge_plggn' => $temp_folder_old->wo_onetime_charge_plggn,
                    'wo_monthly_plggn' => $temp_folder_old->wo_monthly_plggn,
                    'wo_onetime_charge_telkom' => $temp_folder_old->wo_onetime_charge_telkom,
                    'wo_persen_telkom' => $temp_folder_old->wo_persen_telkom,
                    'wo_monthly_telkom' => $temp_folder_old->wo_monthly_telkom,
                    'wo_onetime_charge_mitra' => $temp_folder_old->wo_onetime_charge_mitra,
                    'wo_persen_mitra' => $temp_folder_old->wo_persen_mitra,
                    'wo_monthly_mitra' => $temp_folder_old->wo_monthly_mitra,
                    'kl_tgl_kl' => $temp_folder_old->kl_tgl_kl,
                    'kl_takah_kl' => $temp_folder_old->kl_takah_kl,
                    'kl_nomor_kb' => $temp_folder_old->kl_nomor_kb,
                    'kl_no_kl_mitra' => $temp_folder_old->kl_no_kl_mitra,
                    'kl_tempat_ttd_kl' => $temp_folder_old->kl_tempat_ttd_kl,
                    'kl_notaris' => $temp_folder_old->kl_notaris,
                    'kl_akta_notaris' => $temp_folder_old->kl_akta_notaris,
                    'kl_tgl_akta_notaris' => $temp_folder_old->kl_tgl_akta_notaris,
                    'kl_nama_pejabat_telkom' => $temp_folder_old->kl_nama_pejabat_telkom,
                    'kl_jabatan_pejabat_telkom' => $temp_folder_old->kl_jabatan_pejabat_telkom,
                    'kl_npwp_mitra' => $temp_folder_old->kl_npwp_mitra,
                    'kl_no_anggaran_mitra' => $temp_folder_old->kl_no_anggaran_mitra,
                    'kl_tgl_anggaran_mitra' => $temp_folder_old->kl_tgl_anggaran_mitra,
                    'kl_nama_pejabat_mitra' => $temp_folder_old->kl_nama_pejabat_mitra,
                    'kl_jabatan_pejabat_mitra' => $temp_folder_old->kl_jabatan_pejabat_mitra,
                    'kl_no_skm' => $temp_folder_old->kl_no_skm,
                    'kl_tgl_skm' => $temp_folder_old->kl_tgl_skm,
                    'kl_perihal_skm' => $temp_folder_old->kl_perihal_skm,
                    'kl_tgl_akhir_kl' => $temp_folder_old->kl_tgl_akhir_kl,
                    'kl_bayar_dp' => $temp_folder_old->kl_bayar_dp,
                    'kl_nama_bank_mitra' => $temp_folder_old->kl_nama_bank_mitra,
                    'kl_cabang_bank_mitra' => $temp_folder_old->kl_cabang_bank_mitra,
                    'kl_rek_bank_mitra' => $temp_folder_old->kl_rek_bank_mitra,
                    'kl_an_bank_mitra' => $temp_folder_old->kl_an_bank_mitra,
                    'file_p2' => $temp_folder_old->file_p2,
                    'file_p3' => $temp_folder_old->file_p3,
                    'file_p4' => $temp_folder_old->file_p4,
                    'file_p5' => $temp_folder_old->file_p5,
                    'file_p6' => $temp_folder_old->file_p6,
                    'file_p7' => $temp_folder_old->file_p7,
                    'file_p8' => $temp_folder_old->file_p8,
                    'file_sp' => $temp_folder_old->file_sp,
                    'file_wo' => $temp_folder_old->file_wo,
                    'file_kl' => $temp_folder_old->file_kl
                  ]);
                  DB::connection('pgsql')->table('form_obl')->where('id',$temp_folder_old_id)
                  ->update([
                    'f1_folder' => $temp_folder_old_name,
                    'updated_at' => Carbon::now()->translatedFormat('Y-m-d H:i:s'),
                    'updated_by' => Auth::id()
                  ]);
                }

                $obl_id = DB::connection('pgsql')->table('form_obl')
                ->insertGetId(
                    $filtered->all()
                );

                $request->session()->put('obl_id',$obl_id);
                return $next($request);
              }
              catch(Throwable $e){ return back()->withInput()->with('status','Oops! Gagal Simpan Form Witel.'); }

            }
            else{ return back()->withInput()->with('status','Oops! Gagal Proses Submit Form Witel.'); }
          }
          else{
            return back()->withInput()->with('status','Oops! Gagal Routing.');
          }

    }
}
