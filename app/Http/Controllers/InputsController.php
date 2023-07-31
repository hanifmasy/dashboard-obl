<?php

namespace App\Http\Controllers;

Use Str;
Use Hash;
use App\Exceptions\Handler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;

class InputsController extends Controller
{
    public function create(Request $request): RedirectResponse
    {
        // dd($request->all());
        $user_id = Auth::id();
        $submit_sekarang = Carbon::now()->translatedFormat('Y-m-d H:i:s');

        if($request->submit && str_contains($request->submit,'draf')){
          try{
            // SUBMIT DRAF (VALIDASI: JUDUL PROJEK)
            $inputan_masuk_draf = [];
            $inputan_masuk_draf['f1_judul_projek'] = 'required';
            $inputan_masuk_draf['f1_nama_plggn'] = 'required';
            $validasi_draf = $request->all();
            $validator_draf = Validator::make($validasi_draf,$inputan_masuk_draf);
            if($validator_draf->fails()){ return back()->withErrors($validator_draf)->withInput(); }

            $collection_draf = collect($request->all());
            $filtered_draf = $collection_draf->except([
                '_token',
                'p4_attendees',
                'global_jenis_spk'
            ]);
            $filtered_draf->put('user_id',$user_id);
            $filtered_draf->put('created_at',$submit_sekarang);
            $filtered_draf->put('f1_tgl_keterangan',$submit_sekarang);
            $filtered_draf->put('is_draf',1);
            $filtered_draf->put('f1_jenis_spk',$request->global_jenis_spk);
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
            if($request->submit=='submit_wo'){ $inputan_masuk = ['wo_tgl_fo' => 'required']; }
            if($request->submit=='submit_sp' || $request->submit=='submit_kl'){ $inputan_masuk = ['f2_tgl_p1' => 'required']; }
          }
          $inputan_masuk['f1_nilai_kb'] = 'required';
          $inputan_masuk['f1_jenis_kontrak'] = 'required';
          $validasi = $request->all();
          $validator = Validator::make($validasi,$inputan_masuk);
          if($validator->fails()){ return back()->withErrors($validator)->withInput(); }
          // $validated = $validator->validated();
          // dd($validated);

          try {
              $collection = collect($request->all());
              $filtered = $collection->except([
                  '_token',
                  'p4_attendees',
                  'global_jenis_spk'
              ]);
              // dd($filtered);

              // nomor surat keluar obl (p3, p7, p8, wo, sp, kl)
              // submit draf: tanggal dokumen dan takah tidak terbit
              // submit kl,sp, dan wo : tanggal dokumen dan takah terbit
              // obl hari efektif : 9 hari kerja ( P1 s.d. WO/SP/KL )
              $hari_efektif = 9;
              $hari_efektif = $hari_efektif - 1; // pengecualian tanggal P1
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
              $tgl_p2 = Carbon::create($Y,$m,$d,0)->addDay(1);

              $arr_tanggal_final = [];
              $cek = null;
              $tanggal_cek = null;
              $tanggal_sebelum = $tgl_p2;
              for($i = 0; $i < $hari_efektif; $i++){
                do{
                  $tanggal_cek = $tanggal_sebelum;
                  $string_tgl = $tanggal_cek->translatedFormat('Y-m-d');
                  $query_takah = DB::connection('pgsql')->table('form_takah')->select('id','takah_1')
                  ->whereRaw("
                  TO_CHAR(tanggal,'yyyy-mm-dd') = '$string_tgl'
                  AND ket_tgl NOT IN ('weekend','libur_nasional','cuti_bersama')
                  AND status_taken IS FALSE
                  AND obl_id IS NULL
                  AND tipe_form IS NULL
                  ")->first();
                  if($query_takah){
                    $cek = true;
                    //array_push($arr_tanggal_final,[$string_tgl,$query_takah->id,$query_takah->takah_1]);
                    array_push($arr_tanggal_final,[$query_takah->id,$string_tgl,$query_takah->takah_1]);
                    $tanggal_sebelum = $tanggal_cek->addDay(1);
                  }
                  else{
                    $cek = false;
                    $tanggal_sebelum = $tanggal_cek->addDay(1);
                  }
                }while($cek == false);
              }
              // dd( $arr_tanggal_final );

              $arr_tanggal_taken = $arr_tanggal_final;
              // append filtered array data
              // append user id
              $filtered->put('user_id',$user_id);
              $filtered->put('created_at',$submit_sekarang);
              $filtered->put('f1_tgl_keterangan',$submit_sekarang);
              $filtered->put('is_draf',0);
              $filtered->put('f1_jenis_spk',$request->global_jenis_spk);
              // append tanggal dokumen
              $filtered->put('p2_tgl_p2',$arr_tanggal_final[0][1]);
              $filtered->put('p3_tgl_p3',$arr_tanggal_final[1][1]);
              $filtered->put('p4_tgl_p4',$arr_tanggal_final[2][1]);
              $filtered->put('p5_tgl_p5',$arr_tanggal_final[3][1]);
              $filtered->put('p6_tgl_p6',$arr_tanggal_final[4][1]);
              $filtered->put('p7_tgl_p7',$arr_tanggal_final[5][1]);
              if($request->submit){
                if($request->submit === 'submit_wo'){ $filtered->put('wo_tgl_wo',$arr_tanggal_final[6][1]); }
                if($request->submit === 'submit_sp'){ $filtered->put('sp_tgl_sp',$arr_tanggal_final[6][1]); }
                if($request->submit === 'submit_kl'){
                  $filtered->put('p8_tgl_p8',$arr_tanggal_final[6][1]);
                  $filtered->put('kl_tgl_kl',$arr_tanggal_final[7][1]);
                }
              }
              // append takah p3,p7,p8,wo,sp,kl
              $arr_tanggal_final[1][1] = new Carbon( $arr_tanggal_final[1][1] );
              $arr_tanggal_final[1][1] = $arr_tanggal_final[1][1]->year;
              $filtered->put('p3_takah_p3', 'TEL.' . $arr_tanggal_final[1][2] . '/LG.220/TR6-603/' . $arr_tanggal_final[1][1]);

              $arr_tanggal_final[5][1] = new Carbon( $arr_tanggal_final[5][1] );
              $arr_tanggal_final[5][1] = $arr_tanggal_final[5][1]->year;
              $filtered->put('p7_takah_p7', 'TEL.' . $arr_tanggal_final[5][2] . '/LG.270/TR6-603/' . $arr_tanggal_final[5][1]);

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
                  $arr_tanggal_final[6][1] = new Carbon( $arr_tanggal_final[6][1] );
                  $arr_tanggal_final[6][1] = $arr_tanggal_final[6][1]->year;
                  $filtered->put('wo_takah_wo', 'K.TEL.' . $arr_tanggal_final[6][2] . '/' . $jenis_kontrak . '/' . $kode_pimpinan . '/' . $arr_tanggal_final[6][1]);
                }
                if($request->submit === 'submit_sp'){
                  $arr_tanggal_final[6][1] = new Carbon( $arr_tanggal_final[6][1] );
                  $arr_tanggal_final[6][1] = $arr_tanggal_final[6][1]->year;
                  $filtered->put('sp_takah_sp', 'K.TEL.' . $arr_tanggal_final[6][2] . '/' . $jenis_kontrak . '/' . $kode_pimpinan . '/' . $arr_tanggal_final[6][1]);
                }
                if($request->submit === 'submit_kl'){
                  $arr_tanggal_final[6][1] = new Carbon( $arr_tanggal_final[6][1] );
                  $arr_tanggal_final[6][1] = $arr_tanggal_final[6][1]->year;
                  $filtered->put('p8_takah_p8', 'TEL.' . $arr_tanggal_final[6][2] . '/LG.270/' . $kode_pimpinan . '/' . $arr_tanggal_final[6][1]);

                  $arr_tanggal_final[7][1] = new Carbon( $arr_tanggal_final[7][1] );
                  $arr_tanggal_final[7][1] = $arr_tanggal_final[7][1]->year;
                  $filtered->put('kl_takah_kl', 'K.TEL.' . $arr_tanggal_final[7][2] . '/' . $jenis_kontrak . '/' . $kode_pimpinan . '/' . $arr_tanggal_final[7][1]);
                }
              }


              // INSERT DATA TO OBL DATABASE
              $obl_id = DB::connection('pgsql')->table('form_obl')
              ->insertGetId(
                  $filtered->all()
              );
              // CHECK TABEL TAKAH
              $arr_tanggal_checked = [];
              foreach($arr_tanggal_taken as $value){
                array_push($value,$obl_id);
                array_push($value,'');
                array_push( $arr_tanggal_checked, $value );
              }
              for($i = 0; $i < ($hari_efektif - 2); $i++){
                $arr_tanggal_checked[$i][4] = 'P' . ($i + 2);
              }
              if($request->submit){
                if($request->submit === 'submit_wo'){
                  $arr_tanggal_checked[6][4] = 'WO';
                  array_splice($arr_tanggal_checked,7);
                }
                if($request->submit === 'submit_sp'){
                  $arr_tanggal_checked[6][4] = 'SP';
                  array_splice($arr_tanggal_checked,7);
                }
                if($request->submit === 'submit_kl'){
                  $arr_tanggal_checked[6][4] = 'P8';
                  $arr_tanggal_checked[7][4] = 'KL';
                }
              }
              foreach($arr_tanggal_checked as $value){
                DB::connection('pgsql')->table('form_takah')
                ->where('id',$value[0])
                ->update(
                    [
                      'status_taken' => true,
                      'obl_id' => $value[3],
                      'tipe_form' => $value[4]
                    ]
                );
              }

              // INPUT P4 ATTENDEES
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
}
