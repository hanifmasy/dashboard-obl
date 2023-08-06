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
        $created_by = Auth::id();
        $created_at = Carbon::now()->translatedFormat('Y-m-d H:i:s');

        // PENAMAAN FOLDER & SUBFOLDER
        $nama_folder = '';
        if($request->f1_segmen){
            $hari = Carbon::now();
            $hari_ini = $hari->dayOfYear;
            $tahun_ini = $hari->year;
            $tahun_ini = strval($tahun_ini);
            $hari_ini = ($hari_ini*40);
            if($request->f1_quote_kontrak){
              try{
                $cek_quote_kontrak = DB::connection('pgsql')->table('form_obl')->select('id','f1_quote_kontrak')->where('f1_quote_kontrak',$request->f1_quote_kontrak)->orderBy('created_at','ASC')->get()->toArray();
                $nama_subfolder = '';
                if( count($cek_quote_kontrak) > 0 ){
                    $tambah_subfolder = 'A';
                    $digits_subfolder = strlen(strval(count($cek_quote_kontrak)));
                    for($i = 0; $i < $digits_subfolder; $i++){ $nama_subfolder = $nama_subfolder . $tambah_subfolder; }
                    $skip_subfolder = null;
                    $string_hari_ini = sprintf("%04d", $hari_ini);
                    do{
                      $nama_folder = $request->f1_segmen . '_' . $string_hari_ini . $nama_subfolder;
                      $cek_nama_folder = DB::connection('pgsql')->table('form_obl')->select('id','f1_folder')->where(DB::raw("to_char(created_at,'yyyy')"),'=',$tahun_ini)->where('f1_folder',$nama_folder)->get()->toArray();
                      if( count($cek_nama_folder) > 0 ){ $skip_subfolder = true; $nama_subfolder++; }
                      else{ $skip_subfolder = false; }
                    }while($skip_subfolder==true);
                }
                else{
                  $skip_folder = null;
                  do{
                    $string_hari_ini = sprintf("%04d", $hari_ini);
                    $nama_folder = $request->f1_segmen . '_' . $string_hari_ini;
                    $cek_nama_folder = DB::connection('pgsql')->table('obl_form')->select('id','f1_folder')->where(DB::raw("to_char(created_at,'yyyy')"),'=',$tahun_ini)->where('f1_folder',$nama_folder)->get()->toArray();
                    if( count($cek_nama_folder) > 0 ){ $skip_folder = true; $hari_ini++; }
                    else{ $skip_folder = false; }
                  }while($skip_folder==true);
                }
              }
              catch(Throwable $e){ return back()->withInput()->with('status','Oops! Gagal Check Quote Kontrak.'); }
            }
            else{
              $skip_folder = null;
              do{
                $string_hari_ini = sprintf("%04d", $hari_ini);
                $nama_folder = $request->f1_segmen . '_' . $string_hari_ini;
                $cek_nama_folder = DB::connection('pgsql')->table('form_obl')->select('id','f1_folder')->where(DB::raw("to_char(created_at,'yyyy')"),'=',$tahun_ini)->where('f1_folder',$nama_folder)->get()->toArray();
                if( count($cek_nama_folder) > 0 ){ $skip_folder = true; $hari_ini++; }
                else{ $skip_folder = false; }
              }while($skip_folder==true);
            }
        }

        // PENAMAAN MITRA BARU
        $f1_mitra_id = null;
        if($request->f1_nama_mitra_lain){
          if($request->f1_nama_mitra_lain !== ''){
            try{
              $cek_nama_mitra = DB::connection('pgsql')->table('mitras')->select('*')->where('nama_mitra',$request->f1_nama_mitra_lain)->get()->toArray();
              if( count($cek_nama_mitra) > 0 ){ return back()->withInput()->with('status','Oops! Nama Mitra Sudah Digunakan.'); }
              else{
                $f1_mitra_id = DB::connection('pgsql')->table('mitras')->insertGetId([
                  'nama_mitra' => $request->f1_nama_mitra_lain
                ]);
              }
            }
            catch(Throwable $e){ return back()->withInput()->with('status','Oops! Gagal Check Nama Mitra.'); }
          }
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
                'f1_mitra_id',
                'f1_nama_mitra_lain'
            ]);
            $filtered_draf->put('created_by',$created_by);
            $filtered_draf->put('created_at',$created_at);
            if($request->keterangan && $request->keterangan !== ''){ $filtered_draf->put('f1_tgl_keterangan',$created_at); }
            $filtered_draf->put('is_draf',1);
            $filtered_draf->put('f1_jenis_spk',$request->global_jenis_spk);
            $filtered_draf->put('f1_folder',$nama_folder);
            $filtered_draf->put('f1_mitra_id',$f1_mitra_id);
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
                  'f1_mitra_id',
                  'f1_nama_mitra_lain'
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
              $filtered->put('f1_tgl_keterangan',$created_at);
              $filtered->put('is_draf',0);
              $filtered->put('f1_jenis_spk',$request->global_jenis_spk);
              $filtered->put('f1_folder',$nama_folder);
              $filtered->put('f1_mitra_id',$f1_mitra_id);
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
