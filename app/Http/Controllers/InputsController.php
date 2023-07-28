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

class InputsController extends Controller
{
    public function create(Request $request){
        $user_id = Auth::id();
        // dd($user,$request->all());
        // dd($request->all());
        // dd( Carbon::now()->translatedFormat('Y-m-d') );

        try {
            $collection = collect($request->all());
            $filtered = $collection->except([
                '_token',
                'p4_attendees'
            ]);


            // nomor surat keluar obl (p3, p7, p8, wo, sp, kl)
            // submit draf: tanggal dokumen dan takah tidak terbit
            // submit kl,sp, dan wo : tanggal dokumen dan takah terbit
            // obl hari efektif : 9 hari kerja
            $hari_efektif = 9;
            $cek_per_tanggal = null;

            // kondisi ketika skema OBL : KL atau SP
            $tgl_p1 = null;
            if($request->f2_tgl_p1){ $tgl_p1 = new Carbon($request->f2_tgl_p1); }
            // kondisi ketika skema OBL : WO
            // tanggal (AM) FO -> P1
            $tgl_fo = null;
            if($request->wo_tgl_fo){ $tgl_fo = new Carbon($request->wo_tgl_fo); }

            $d = $tgl_p1->day;
            $m = $tgl_p1->month;
            $Y = $tgl_p1->year;
            $tgl_p2 = Carbon::create($Y,$m,$d,0)->addDay(1);

            $arr_tanggal_final = [];
            $cek = null;
            $tanggal_cek = null;
            $tanggal_sebelum = $tgl_p2;
            for($i = 0; $i < 8; $i++){
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
                ")
                ->first();
                if($query_takah){
                  $cek = true;
                  //array_push($arr_tanggal_final,[$string_tgl,$query_takah->id,$query_takah->takah_1]);
                  array_push($arr_tanggal_final,[$string_tgl,$query_takah->takah_1]);
                  $tanggal_sebelum = $tanggal_cek->addDay(1);
                }
                else{
                  $cek = false;
                  $tanggal_sebelum = $tanggal_cek->addDay(1);
                }
              }while($cek == false);
            }
            // dd( $arr_tanggal_final );

            // append filtered array data
            // append user id
            $filtered->put('user_id',$user_id);
            // append tanggal dokumen
            $filtered->put('p2_tgl_p2',$arr_tanggal_final[0][0]);
            $filtered->put('p3_tgl_p3',$arr_tanggal_final[1][0]);
            $filtered->put('p4_tgl_p4',$arr_tanggal_final[2][0]);
            $filtered->put('p5_tgl_p5',$arr_tanggal_final[3][0]);
            $filtered->put('p6_tgl_p6',$arr_tanggal_final[4][0]);
            $filtered->put('p7_tgl_p7',$arr_tanggal_final[5][0]);
            if($request->submit){
              if($request->submit === 'submit_wo'){ $filtered->put('wo_tgl_wo',$arr_tanggal_final[6][0]); }
              if($request->submit === 'submit_sp'){ $filtered->put('sp_tgl_sp',$arr_tanggal_final[6][0]); }
              if($request->submit === 'submit_kl'){
                $filtered->put('p8_tgl_p8',$arr_tanggal_final[6][0]);
                $filtered->put('kl_tgl_kl',$arr_tanggal_final[7][0]);
              }
            }
            // append takah p3,p7,p8,wo,sp,kl
            $arr_tanggal_final[1][0] = new Carbon( $arr_tanggal_final[1][0] );
            $arr_tanggal_final[1][0] = $arr_tanggal_final[1][0]->year;
            $filtered->put('p3_takah_p3', 'TEL.' . $arr_tanggal_final[1][1] . '/LG.220/TR6-603/' . $arr_tanggal_final[1][0]);

            $arr_tanggal_final[5][0] = new Carbon( $arr_tanggal_final[5][0] );
            $arr_tanggal_final[5][0] = $arr_tanggal_final[5][0]->year;
            $filtered->put('p7_takah_p7', 'TEL.' . $arr_tanggal_final[5][1] . '/LG.270/TR6-603/' . $arr_tanggal_final[5][0]);

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
              if($nilai_kb_filter < 1000000000 ){ $kode_pimpinan = 'TR6-600'; }
              if($nilai_kb_filter >= 1000000000 ){ $kode_pimpinan = 'TR6-001'; }
            }

            if($request->submit){
              if($request->submit === 'submit_wo'){
                $arr_tanggal_final[6][0] = new Carbon( $arr_tanggal_final[6][0] );
                $arr_tanggal_final[6][0] = $arr_tanggal_final[6][0]->year;
                $filtered->put('wo_takah_wo', 'K.TEL.' . $arr_tanggal_final[6][1] . '/' . $jenis_kontrak . '/' . $kode_pimpinan . '/' . $arr_tanggal_final[6][0]);
              }
              if($request->submit === 'submit_sp'){
                $arr_tanggal_final[6][0] = new Carbon( $arr_tanggal_final[6][0] );
                $arr_tanggal_final[6][0] = $arr_tanggal_final[6][0]->year;
                $filtered->put('sp_takah_sp', 'K.TEL.' . $arr_tanggal_final[6][1] . '/' . $jenis_kontrak . '/' . $kode_pimpinan . '/' . $arr_tanggal_final[6][0]);
              }
              if($request->submit === 'submit_kl'){
                $arr_tanggal_final[6][0] = new Carbon( $arr_tanggal_final[6][0] );
                $arr_tanggal_final[6][0] = $arr_tanggal_final[6][0]->year;
                $filtered->put('p8_takah_p8', 'TEL.' . $arr_tanggal_final[6][1] . '/LG.270/' . $kode_pimpinan . '/' . $arr_tanggal_final[6][0]);

                $arr_tanggal_final[7][0] = new Carbon( $arr_tanggal_final[7][0] );
                $arr_tanggal_final[7][0] = $arr_tanggal_final[7][0]->year;
                $filtered->put('kl_takah_kl', 'K.TEL.' . $arr_tanggal_final[7][1] . '/' . $jenis_kontrak . '/' . $kode_pimpinan . '/' . $arr_tanggal_final[7][0]);
              }
            }

            // insert data to obl database
            $id = DB::connection('pgsql')->table('form_obl')
            ->insertGetId(
                $filtered->all()
            );

            // INPUT P4 ATTENDEES
            if($request->p4_attendees){
                $array_insert = [];
                foreach($request->p4_attendees as $key => $value){
                    array_push(
                        $array_insert,
                        [
                            'obl_id' => $id,
                            'p4_attendees' => $value
                        ]
                    );
                }

                // foreach($request->lampiran_spesifikasi as $key => $value){
                //     $array_insert[$key]['lampiran_spesifikasi'] = $value;
                // }

                DB::connection('pgsql')->table('form_p4_attendees')
                ->insert(
                    $array_insert
                );
            }

            return redirect('inputs')->with('status', 'Data Inserted: Success!');
        }
        catch(Throwable $e){
            // report($e);
            // return false;
            return redirect()->back()->with('error',$e);
        }

    }
}
