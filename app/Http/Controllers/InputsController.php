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
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class InputsController extends Controller
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

        // KONDISI JENIS KONTRAK AMANDEMEN
        $cari_nomor_kb = '';
        if($request->cari_nomor_kb){
          if($request->cari_nomor_kb !== ''){
              $cari_nomor_kb = $request->cari_nomor_kb;
          }
        }

        // PENAMAAN FOLDER & SUBFOLDER
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
            $cek_quote_kontrak_alphabet++;
            $nama_folder = $cek_quote_kontrak_numeric . $cek_quote_kontrak_alphabet;
          }
          else if( $cek_quote_kontrak_alphabet === "" ){
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
        if($temp_folder_old_name && $temp_folder_old_id){
          $temp_folder_old = DB::connection('pgsql')->table('form_obl')->select('*')->where('id',$temp_folder_old_id)->first();
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
            'file_kl' => $temp_folder_old->file_kl,
            'p0_nomor_p0' => $temp_folder_old->p0_nomor_p0,
            'p0_nik_am' => $temp_folder_old->p0_nik_am,
            'p0_nik_manager' => $temp_folder_old->p0_nik_manager,
            'p0_tgl_submit' => $temp_folder_old->p0_tgl_submit,
            'p0_pemeriksa' => $temp_folder_old->p0_pemeriksa,
            'p0_nik_gm' => $temp_folder_old->p0_nik_gm,
            'p1_nomor_p1' => $temp_folder_old->p1_nomor_p1,
            'p1_tgl_p1' => $temp_folder_old->p1_tgl_p1,
            'p1_pemeriksa' => $temp_folder_old->p1_pemeriksa,
            'p1_tgl_delivery' => $temp_folder_old->p1_tgl_delivery,
            'p1_lokasi_instal' => $temp_folder_old->p1_lokasi_instal,
            'p1_skema_bisnis' => $temp_folder_old->p1_skema_bisnis,
            'p1_skema_bayar' => $temp_folder_old->p1_skema_bayar,
            'p1_mekanisme_bayar' => $temp_folder_old->p1_mekanisme_bayar,
            'p1_tgl_kontrak_mulai' => $temp_folder_old->p1_tgl_kontrak_mulai,
            'p1_tgl_kontrak_akhir' => $temp_folder_old->p1_tgl_kontrak_akhir,
            'p1_tgl_doc_plggn' => $temp_folder_old->p1_tgl_doc_plggn,
            'p1_estimasi_harga' => $temp_folder_old->p1_estimasi_harga,
            'p1_disetujui_gm' => $temp_folder_old->p1_disetujui_gm,
            'p1_dibuat_am' => $temp_folder_old->p1_dibuat_am,
            'p1_diperiksa_manager' => $temp_folder_old->p1_diperiksa_manager,
            'file_p0' => $temp_folder_old->file_p0,
            'file_p1' => $temp_folder_old->file_p1
          ]);
          DB::connection('pgsql')->table('form_obl')->where('id',$temp_folder_old_id)
          ->update([
            'f1_folder' => $temp_folder_old_name,
            'updated_at' => Carbon::now()->translatedFormat('Y-m-d H:i:s'),
            'updated_by' => Auth::id()
          ]);
        }

        // PENAMAAN P7 TEMBUSAN GM WITEL
        $gm_witel = '';
        if($request->f1_witel){
          try{
            $cek_gm_witel = DB::connection('pgsql')->table('witels')->select('gm_witel')->where('nama_witel',$request->f1_witel)->first();
            if($cek_gm_witel){ $gm_witel = $cek_gm_witel->gm_witel; }
            else{ $gm_witel = '[ GM WITEL ]'; }
          }
          catch(Throwable $e){ return back()->withInput()->with('status','Oops! Gagal Check Witel dan Relasinya.'); }
        }

        // P6 HARGA NEGO = P7 HARGA PEKERJAAN
        $p7_harga_pekerjaan = '';
        if($request->p6_harga_negosiasi){
          try{
            if($request->p6_harga_negosiasi !== ''){ $p7_harga_pekerjaan = $request->p6_harga_negosiasi; }
            else{ $p7_harga_pekerjaan = null; }
          }
          catch(Throwable $e){ return back()->withInput()->with('status','Oops! Gagal Check P6 HARGA NEGO.'); }
        }

        if($request->submit && str_contains($request->submit,'draf')){
          try{
            // SUBMIT DRAF (VALIDASI: JUDUL PROJEK)
            $inputan_masuk_draf = [];
            $inputan_masuk_draf['f1_judul_projek'] = 'required';
            $inputan_masuk_draf['f1_nama_plggn'] = 'required';
            $inputan_masuk_draf['f1_segmen'] = 'required';
            $validasi_draf = $request->all();
            $validator_draf = Validator::make($validasi_draf,$inputan_masuk_draf);
            if($validator_draf->fails()){ return back()->withErrors($validator_draf)->withInput(); }

            $collection_draf = collect($request->all());
            $filtered_draf = $collection_draf->except([
                '_token',
                'p4_attendees',
                'global_jenis_spk',
                'cari_nomor_kb'
            ]);
            $filtered_draf->put('created_by',$created_by);
            $filtered_draf->put('created_at',$created_at);
            $filtered_draf->put('updated_by',$created_by);
            $filtered_draf->put('updated_at',$created_at);
            if($user_in_is->role_id===2 || $user_in_is->role_id===9){ $filtered_draf->put('submit','obl_submit'); }
            if($user_in_is->role_id===8){ $filtered_draf->put('submit','solution_submit'); }
            $filtered_draf->put('is_draf',1);
            $filtered_draf->put('revisi_witel',false);
            $filtered_draf->put('revisi_witel_count',0);
            $filtered_draf->put('f1_jenis_spk',$request->global_jenis_spk);
            $filtered_draf->put('f1_folder',$nama_folder);
            if($request->f1_witel){ $filtered_draf->put('p7_tembusan',$gm_witel); }
            if($request->p6_harga_negosiasi){ $filtered_draf->put('p7_harga_pekerjaan',$p7_harga_pekerjaan); }
            if($request->f1_keterangan){ $filtered_draf->put('f1_tgl_keterangan',$created_at); }
            if($request->cari_nomor_kb){
              if($request->f1_jenis_spk){
                if($request->f1_jenis_spk === 'SP'){ $filtered_draf->put('sp_nomor_kb',$cari_nomor_kb); }
                if($request->f1_jenis_spk === 'WO'){ $filtered_draf->put('wo_nomor_kb',$cari_nomor_kb); }
                if($request->f1_jenis_spk === 'KL'){ $filtered_draf->put('kl_nomor_kb',$cari_nomor_kb); }
              }
            }
            $obl_id_draf = DB::connection('pgsql')->table('form_obl')
            ->insertGetId(
                $filtered_draf->all()
            );
            if($request->p4_attendees){
                $arr_attendees_draf = [];
                foreach($request->p4_attendees as $key => $value){
                    array_push(
                        $arr_attendees_draf,
                        [
                            'obl_id' => $obl_id_draf,
                            'p4_attendees' => $value
                        ]
                    );
                }

                DB::connection('pgsql')->table('form_p4_attendees')
                ->insert(
                    $arr_attendees_draf
                );
            }
            return redirect('inputs')->with('status', 'Sukses Simpan Draf!');
          }
          catch(Throwable $e){
            return back()->with('status','Gagal Simpan Draf!');
          }
        }
        else{
          // SUBMIT WO,SP,KL (DENGAN VALIDASI)
          $inputan_masuk = [];
          if($request->submit){
            if($request->submit=='submit_wo'){ $inputan_masuk['wo_tgl_fo'] = 'required'; }
            if($request->submit=='submit_sp' || $request->submit=='submit_kl'){ $inputan_masuk['f2_tgl_p1'] = 'required'; }
          }
          $inputan_masuk['f1_nilai_kb'] = 'required';
          $inputan_masuk['f1_jenis_kontrak'] = 'required';
          $inputan_masuk['f1_judul_projek'] = 'required';
          $inputan_masuk['f1_nama_plggn'] = 'required';
          $inputan_masuk['f1_segmen'] = 'required';
          $validasi = $request->all();
          $validator = Validator::make($validasi,$inputan_masuk);
          if($validator->fails()){ return back()->withInput()->withErrors($validator); }
          // $validated = $validator->validated();
          // dd($validated);

          try {
              $collection = collect($request->all());
              $filtered = $collection->except([
                  '_token',
                  'p4_attendees',
                  'global_jenis_spk',
                  'cari_nomor_kb'
              ]);
              // dd($filtered);

              // nomor surat keluar obl (p3, p7, p8, wo, sp, kl)
              // submit draf: tanggal dokumen dan takah tidak terbit
              // submit kl,sp, dan wo : tanggal dokumen dan takah terbit
              // obl hari efektif : 9 hari kerja ( P1 s.d. WO/SP/KL )
              $hari_efektif = 9;
              $hari_efektif = $hari_efektif - 1; // pengecualian form P1
              $cek_per_tanggal = null;

              // tanggal (AM) FO / P1
              $tanggal_mulai = null;
              if($request->submit){
                if($request->submit === 'submit_wo'){
                  if($request->wo_tgl_fo){ $tanggal_mulai = new Carbon($request->wo_tgl_fo); }
                }
                if($request->submit === 'submit_sp' || $request->submit === 'submit_kl'){
                  if($request->f2_tgl_p1){ $tanggal_mulai = new Carbon($request->f2_tgl_p1); }
                }
              }

              $d = $tanggal_mulai->day;
              $m = $tanggal_mulai->month;
              $Y = $tanggal_mulai->year;
              $tgl_p1 = Carbon::create($Y,$m,$d,0);

              $tahun = $tgl_p1->translatedFormat('Y');
              $is_december = $tgl_p1->translatedFormat('m');
              $libur_nasional_res1 = null;
              $libur_nasional_res2 = null;
              $cuti_bersama_res3 = null;
              $cuti_bersama_res4 = null;
              $weekend = ['Sabtu','Minggu'];
              $hari_kerja = ['Senin','Selasa','Rabu','Kamis','Jumat'];

              $client1 = new Client();
              $client2 = new Client();
              $client3 = new Client();
              $client4 = new Client();

              try {
                $res1 = $client1->request('GET', 'https://api-harilibur.vercel.app/api?year='.$tahun);
                $libur_nasional_res1 = json_decode($res1->getBody()->getContents());
              }catch(ClientException $e){
                    $res1 = $e->getResponse();
                    if($res1->getStatusCode() !== 200){ $libur_nasional_res1 = []; }
              }
              try {
                $res3 = $client3->request('GET', 'https://dayoffapi.vercel.app/api?year='.$tahun);
                $cuti_bersama_res3 = json_decode($res3->getBody()->getContents());
              }catch(ClientException $e){
                    $res3 = $e->getResponse();
                    if($res3->getStatusCode() !== 200){ $cuti_bersama_res3 = []; }
              }

              if( $is_december == '12'){
                try {
                  $res2 = $client2->request('GET', 'https://api-harilibur.vercel.app/api?year='.((int)$tahun + 1));
                  $libur_nasional_res2 = json_decode($res2->getBody()->getContents());
                }catch(ClientException $e){
                      $res2 = $e->getResponse();
                      if($res2->getStatusCode() !== 200){ $libur_nasional_res2 = []; }
                }
                try {
                  $res4 = $client4->request('GET', 'https://dayoffapi.vercel.app/api?year='.((int)$tahun + 1));
                  $cuti_bersama_res4 = json_decode($res4->getBody()->getContents());
                }catch(ClientException $e){
                      $res4 = $e->getResponse();
                      if($res4->getStatusCode() !== 200){ $cuti_bersama_res4 = []; }
                }
              }

              $libur_nasional = [];
              $cuti_bersama = [];
              if($libur_nasional_res1){
                foreach($libur_nasional_res1 as $key => $value){
                  if($value->is_national_holiday == true){ array_push($libur_nasional,$value->holiday_date); }
                }
              }
              if($libur_nasional_res2){
                foreach($libur_nasional_res2 as $key => $value){
                  if($value->is_national_holiday == true){ array_push($libur_nasional,$value->holiday_date); }
                }
              }
              if($cuti_bersama_res3){
                foreach($cuti_bersama_res3 as $key => $value){
                  if($value->is_cuti == true){ array_push($cuti_bersama,$value->tanggal); }
                }
              }
              if($cuti_bersama_res4){
                foreach($cuti_bersama_res4 as $key => $value){
                  if($value->is_cuti == true){ array_push($cuti_bersama,$value->tanggal); }
                }
              }

              $tgl_p2 = $tgl_p1->addDay(1);
              $docs = 40; // 1 hari = 40 dokumen
              $cek = null;
              $arr_tanggal = [];
              $arr_insert_form_takah = [];
              $tanggal_cek = null;
              $tanggal_sebelum = $tgl_p2;
              for($i = 0; $i < $hari_efektif; $i++){
                do{
                  $tanggal_cek = $tanggal_sebelum;
                  $dayOfYear = $tanggal_cek->dayOfYear;
                  $string_tgl = $tanggal_cek->translatedFormat('Y-m-d');
                  $string_hari = $tanggal_cek->translatedFormat('l');
                  if( in_array($string_tgl,$cuti_bersama) ){
                    $cek = false;
                    $tanggal_sebelum = $tanggal_cek->addDay(1);
                  }
                  if( in_array($string_tgl,$libur_nasional) ){
                    $cek = false;
                    $tanggal_sebelum = $tanggal_cek->addDay(1);
                  }
                  else if( in_array($string_hari,$weekend) ){
                    $cek = false;
                    $tanggal_sebelum = $tanggal_cek->addDay(1);
                  }
                  else if( in_array($string_hari,$hari_kerja) ){
                    $cek = true;
                    $skip = null;
                    $takah_1 = null;
                    if($i==1||$i==5||$i==6||$i==7){
                      $takah_1 = ((($dayOfYear-1)*$docs)+1);
                      $takah_1 = sprintf("%04d", $takah_1);
                      do{
                        $cek_form_takah = DB::connection('pgsql')->table('form_takah')->select('*')->where(DB::raw("to_char(tanggal::date,'yyyy')"),'=',DB::raw("to_char('$string_tgl_submit'::date,'yyyy')"))->where('takah_1',$takah_1)->get()->toArray();
                        if( count($cek_form_takah) > 0 ){ $skip = true; $takah_1++; }
                        else{ $skip = false; array_push($arr_tanggal,[$string_tgl,$takah_1]); array_push($arr_insert_form_takah,['obl_id'=> 0,'tanggal'=>$string_tgl,'takah_1'=>$takah_1]); }
                      }while($skip==true);
                    }
                    else{
                      array_push($arr_tanggal,[$string_tgl,$takah_1]);
                    }
                    $tanggal_sebelum = $tanggal_cek->addDay(1);
                  }
                }while($cek==false);
              }
              // dd($arr_tanggal);

              // append filtered array data
              // append user id
              $filtered->put('created_by',$created_by);
              $filtered->put('created_at',$created_at);
              $filtered->put('updated_by',$created_by);
              $filtered->put('updated_at',$created_at);
              if($user_in_is->role_id===2 || $user_in_is->role_id===9){ $filtered->put('submit','obl_submit'); }
              if($user_in_is->role_id===8){ $filtered->put('submit','solution_submit'); }
              $filtered->put('is_draf',0);
              $filtered->put('revisi_witel',false);
              $filtered->put('revisi_witel_count',0);
              $filtered->put('f1_jenis_spk',$request->global_jenis_spk);
              $filtered->put('f1_folder',$nama_folder);
              if($request->f1_witel){ $filtered->put('p7_tembusan',$gm_witel); }
              if($request->p6_harga_negosiasi){ $filtered->put('p7_harga_pekerjaan',$p7_harga_pekerjaan); }
              if($request->f1_keterangan){ $filtered->put('f1_tgl_keterangan',$created_at); }
              if($request->cari_nomor_kb){
                if($request->f1_jenis_spk){
                  if($request->f1_jenis_spk === 'SP'){ $filtered->put('sp_nomor_kb',$cari_nomor_kb); }
                  if($request->f1_jenis_spk === 'WO'){ $filtered->put('wo_nomor_kb',$cari_nomor_kb); }
                  if($request->f1_jenis_spk === 'KL'){ $filtered->put('kl_nomor_kb',$cari_nomor_kb); }
                }
              }
              // append tanggal dokumen
              $filtered->put('p2_tgl_p2',$arr_tanggal[0][0]);
              $filtered->put('p3_tgl_p3',$arr_tanggal[1][0]);
              $filtered->put('p4_tgl_p4',$arr_tanggal[2][0]);
              $filtered->put('p5_tgl_p5',$arr_tanggal[3][0]);
              $filtered->put('p6_tgl_p6',$arr_tanggal[4][0]);
              $filtered->put('p7_tgl_p7',$arr_tanggal[5][0]);
              if($request->submit){
                if($request->submit === 'submit_wo'){ $filtered->put('wo_tgl_wo',$arr_tanggal[6][0]); }
                if($request->submit === 'submit_sp'){ $filtered->put('sp_tgl_sp',$arr_tanggal[6][0]); }
                if($request->submit === 'submit_kl'){
                  $filtered->put('p8_tgl_p8',$arr_tanggal[6][0]);
                  $filtered->put('kl_tgl_kl',$arr_tanggal[7][0]);
                }
              }
              // append takah p3,p7,p8,wo,sp,kl
              $arr_tanggal[1][0] = new Carbon( $arr_tanggal[1][0] );
              $arr_tanggal[1][0] = $arr_tanggal[1][0]->year;
              $filtered->put('p3_takah_p3', 'TEL.' . $arr_tanggal[1][1] . '/LG.220/TR6-603/' . $arr_tanggal[1][0]);

              $arr_tanggal[5][0] = new Carbon( $arr_tanggal[5][0] );
              $arr_tanggal[5][0] = $arr_tanggal[5][0]->year;
              $filtered->put('p7_takah_p7', 'TEL.' . $arr_tanggal[5][1] . '/LG.270/TR6-603/' . $arr_tanggal[5][0]);

              // Kontrak Baru / Perpanjangan
              $jenis_kontrak = '';
              if($request->f1_jenis_kontrak){
                if($request->f1_jenis_kontrak == 'perpanjangan'){ $jenis_kontrak = 'HK.820'; }
                if($request->f1_jenis_kontrak == 'baru'){ $jenis_kontrak = 'HK.810'; }
              }
              // Kode Pimpinan : Nilai KB < 1M / > 1M
              $kode_pimpinan = '';
              if($request->f1_nilai_kb){
                $nilai_kb = $request->f1_nilai_kb;
                $nilai_kb_filter = str_replace( ',','.',str_replace('Rp','',str_replace('.','',$nilai_kb) ) );
                if($nilai_kb_filter < 1000000000.00 ){ $kode_pimpinan = 'TR6-600'; }
                if($nilai_kb_filter >= 1000000000.00 ){ $kode_pimpinan = 'TR6-001'; }
              }

              if($request->submit){
                if($request->submit === 'submit_wo'){
                  $arr_tanggal[6][0] = new Carbon( $arr_tanggal[6][0] );
                  $arr_tanggal[6][0] = $arr_tanggal[6][0]->year;
                  $filtered->put('wo_takah_wo', 'K.TEL.' . $arr_tanggal[6][1] . '/' . $jenis_kontrak . '/' . $kode_pimpinan . '/' . $arr_tanggal[6][0]);
                  array_splice($arr_insert_form_takah,3);
                }
                if($request->submit === 'submit_sp'){
                  $arr_tanggal[6][0] = new Carbon( $arr_tanggal[6][0] );
                  $arr_tanggal[6][0] = $arr_tanggal[6][0]->year;
                  $filtered->put('sp_takah_sp', 'K.TEL.' . $arr_tanggal[6][1] . '/' . $jenis_kontrak . '/' . $kode_pimpinan . '/' . $arr_tanggal[6][0]);
                  array_splice($arr_insert_form_takah,3);
                }
                if($request->submit === 'submit_kl'){
                  $arr_tanggal[6][0] = new Carbon( $arr_tanggal[6][0] );
                  $arr_tanggal[6][0] = $arr_tanggal[6][0]->year;
                  $filtered->put('p8_takah_p8', 'TEL.' . $arr_tanggal[6][1] . '/LG.270/' . $kode_pimpinan . '/' . $arr_tanggal[6][0]);
                  $arr_tanggal[7][0] = new Carbon( $arr_tanggal[7][0] );
                  $arr_tanggal[7][0] = $arr_tanggal[7][0]->year;
                  $filtered->put('kl_takah_kl', 'K.TEL.' . $arr_tanggal[7][1] . '/' . $jenis_kontrak . '/' . $kode_pimpinan . '/' . $arr_tanggal[7][0]);
                }
              }


              // INSERT DATA TO OBL DATABASE
              $obl_id = DB::connection('pgsql')->table('form_obl')
              ->insertGetId(
                  $filtered->all()
              );
              // INSERT TAKAH
              $insert_takah_1 = [];
              foreach($arr_insert_form_takah as $value){
                  array_push($insert_takah_1,
                    [
                      'obl_id' => $obl_id,
                      'tanggal' => $value['tanggal'],
                      'takah_1' => $value['takah_1']
                    ]
                  );
              }
              DB::connection('pgsql')->table('form_takah')
              ->insert(
                  $insert_takah_1
              );

              // INSERT P4 ATTENDEES
              if($request->p4_attendees){
                  $arr_attendees = [];
                  foreach($request->p4_attendees as $key => $value){
                      array_push(
                          $arr_attendees,
                          [
                              'obl_id' => $obl_id,
                              'p4_attendees' => $value
                          ]
                      );
                  }

                  // foreach($request->lampiran_spesifikasi as $key => $value){
                  //     $array_insert[$key]['lampiran_spesifikasi'] = $value;
                  // }

                  DB::connection('pgsql')->table('form_p4_attendees')
                  ->insert(
                      $arr_attendees
                  );
              }

              $dok_obl = '';
              if($request->submit){
                if($request->submit === 'submit_wo'){ $dok_obl = 'WO'; }
                if($request->submit === 'submit_sp'){ $dok_obl = 'SP'; }
                if($request->submit === 'submit_kl'){ $dok_obl = 'KL'; }
              }

              return redirect('inputs')->with('status', 'Sukses Simpan OBL : ' . $dok_obl);
          }
          catch(Throwable $e){
              // report($e);
              // return false;
              // return redirect()->back()->with('status',$e);
              // return redirect()->back()->with('status','Gagal Simpan OBL!');
              return back()->with('status','Gagal Simpan OBL!');
          }
        }
    }

    public function createLegacy(Request $request){
      // dd($request->all());

      try{
        $inputan_masuk = [];
        if($request->submit){
          if($request->submit=='submit_wo'){
            $inputan_masuk['p6_tgl_p6'] = 'required';
            $inputan_masuk['wo_tgl_fo'] = 'required';
            $inputan_masuk['wo_tgl_wo'] = 'required';
            $inputan_masuk['wo_nomor_kb'] = 'required';
          }
          if($request->submit=='submit_sp' ){
            $inputan_masuk['f2_tgl_p1'] = 'required';
            $inputan_masuk['p2_tgl_p2'] = 'required';
            $inputan_masuk['p3_tgl_p3'] = 'required';
            $inputan_masuk['p3_takah_p3'] = 'required';
            $inputan_masuk['p4_tgl_p4'] = 'required';
            $inputan_masuk['p5_tgl_p5'] = 'required';
            $inputan_masuk['p6_tgl_p6'] = 'required';
            $inputan_masuk['p7_tgl_p7'] = 'required';
            $inputan_masuk['p7_takah_p7'] = 'required';
            $inputan_masuk['sp_tgl_sp'] = 'required';
            $inputan_masuk['sp_takah_sp'] = 'required';
            $inputan_masuk['sp_nomor_kb'] = 'required';
          }
          if($request->submit=='submit_sp' ){
            $inputan_masuk['f2_tgl_p1'] = 'required';
            $inputan_masuk['p2_tgl_p2'] = 'required';
            $inputan_masuk['p3_tgl_p3'] = 'required';
            $inputan_masuk['p3_takah_p3'] = 'required';
            $inputan_masuk['p4_tgl_p4'] = 'required';
            $inputan_masuk['p5_tgl_p5'] = 'required';
            $inputan_masuk['p6_tgl_p6'] = 'required';
            $inputan_masuk['p7_tgl_p7'] = 'required';
            $inputan_masuk['p7_takah_p7'] = 'required';
            $inputan_masuk['p8_tgl_p8'] = 'required';
            $inputan_masuk['p8_takah_p8'] = 'required';
            $inputan_masuk['kl_tgl_kl'] = 'required';
            $inputan_masuk['kl_takah_kl'] = 'required';
            $inputan_masuk['kl_nomor_kb'] = 'required';
          }
        }
        $inputan_masuk['f1_nilai_kb'] = 'required';
        $inputan_masuk['f1_jenis_kontrak'] = 'required';
        $inputan_masuk['f1_judul_projek'] = 'required';
        $inputan_masuk['f1_nama_plggn'] = 'required';
        $inputan_masuk['f1_segmen'] = 'required';
        $inputan_masuk['f1_folder'] = 'required';
        $inputan_masuk['f1_witel'] = 'required';
        $validasi = $request->all();
        $validator = Validator::make($validasi,$inputan_masuk);
        if($validator->fails()){ return back()->withInput()->withErrors($validator); }
        // $validated = $validator->validated();
        // dd($validated);

        $collection = collect($request->all());
        $filtered = $collection->except([
            '_token',
            'p4_attendees',
            'global_jenis_spk',
            'cari_nomor_kb'
        ]);
        // dd($filtered);
        $created_by = Auth::id();
        $created_at = Carbon::now()->translatedFormat('Y-m-d H:i:s');

        $filtered->put('created_by',$created_by);
        $filtered->put('created_at',$created_at);
        $filtered->put('is_draf',9);
        $filtered->put('revisi_witel',false);
        $filtered->put('revisi_witel_count',0);
        $filtered->put('f1_jenis_spk',$request->global_jenis_spk);
        if($request->f1_keterangan){ $filtered->put('f1_tgl_keterangan',$created_at); }
        $obl_id = DB::connection('pgsql')->table('form_obl')
        ->insertGetId(
            $filtered->all()
        );
        // INSERT P4 ATTENDEES
        if($request->p4_attendees){
            $arr_attendees = [];
            foreach($request->p4_attendees as $key => $value){
                array_push(
                    $arr_attendees,
                    [
                        'obl_id' => $obl_id,
                        'p4_attendees' => $value
                    ]
                );
            }

            DB::connection('pgsql')->table('form_p4_attendees')
            ->insert(
                $arr_attendees
            );
        }

        return redirect()->route('inputs_legacy')->with('status', 'Sukses Simpan Rekap Data Lama.');
      }
      catch(Throwable $e){
          return back()->with('status','Gagal Simpan Rekap Data Lama.');
      }

    }
}
