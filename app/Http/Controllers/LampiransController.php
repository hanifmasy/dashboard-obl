<?php

namespace App\Http\Controllers;

use App\Exceptions\Handler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\MitraVendor;
use App\Models\DocObl;
use Carbon\Carbon;

class LampiransController extends Controller
{
    public function index(Request $request){
      // dd($request->all());
      if($request->lampiran_doc_id){
        if($request->lampiran_doc_id !== ''){
          try{
            $perihal = DB::connection('pgsql')->table('form_obl')->leftJoin('mitras','mitras.id','=','f1_mitra_id')->select('form_obl.id','f1_judul_projek','f1_nama_plggn','f1_mitra_id','nama_mitra')->where('form_obl.id',intval($request->lampiran_doc_id))->get()->toArray();
            $lampiran_doc = DB::connection('pgsql')->table('form_lampiran')->select('*')->where('obl_id',intval($request->lampiran_doc_id))->get()->toArray();
            if($perihal){ return response()->json(['status_id'=>'1','status'=>'','perihal'=>$perihal, 'lampiran_doc'=>$lampiran_doc]); }
            // if($perihal && $lampiran_doc){ return response()->json(['status_id'=>'1','status'=>'','perihal'=>$perihal, 'lampiran_doc'=>$lampiran_doc]); }
            // else{ return response()->json(['status_id'=>'2','status'=>'Tidak Ada Data Lampiran OBL.','perihal'=>$perihal]); }
          }
            catch(Throwable $e){
              return response()->json(['status_id'=>'3', 'status'=>'Oops! Gagal Mengambil Data Lampiran OBL.']);
            }
        }
      }
      else{ return response()->json(['status_id'=>'4', 'status'=>'Oops! Wrong Routing.']); }
    }

    public function create(Request $request){
      // dd($request->all(),$request->jumlah_p2[0]);
      if($request->submit){
        if($request->submit==='submit_lampiran'){
          if($request->obl_id){
            try{

              $arr_lampiran_sebelum = [];
              $arr_lampiran_baru = [];

              if($request->detail_item_p2 && count($request->detail_item_p2) > 0){
                array_push($arr_lampiran_sebelum,'P2');
                foreach($request->detail_item_p2 as $kunci => $nilai){
                  array_push($arr_lampiran_baru,[
                    'obl_id' => $request->obl_id,
                    'tipe_form' => 'P2',
                    'detail_item' => $nilai,
                    'jumlah' => $request->jumlah_p2[$kunci],
                    'satuan' => $request->satuan_p2[$kunci],
                    'periode_bulan' => $request->periode_bulan_p2[$kunci],
                    'harga_tawar_otc' => (float)$request->harga_tawar_otc_p2[$kunci],
                    'harga_tawar_total' => (float)$request->harga_tawar_total_p2[$kunci],
                    'harga_nego_otc' => (float)$request->harga_nego_otc_p2[$kunci],
                    'harga_nego_total' => (float)$request->harga_nego_total_p2[$kunci],
                    'harga_kerja_otc' => (float)$request->harga_kerja_otc_p2[$kunci],
                    'harga_kerja_total' => (float)$request->harga_kerja_total_p2[$kunci]
                  ]);
                }
              }
              if($request->detail_item_p3 && count($request->detail_item_p3) > 0){
                array_push($arr_lampiran_sebelum,'P3');
                foreach($request->detail_item_p3 as $kunci => $nilai){
                  array_push($arr_lampiran_baru,[
                    'obl_id' => $request->obl_id,
                    'tipe_form' => 'P3',
                    'detail_item' => $nilai,
                    'jumlah' => $request->jumlah_p3[$kunci],
                    'satuan' => $request->satuan_p3[$kunci],
                    'periode_bulan' => $request->periode_bulan_p3[$kunci],
                    'harga_tawar_otc' => (float)$request->harga_tawar_otc_p3[$kunci],
                    'harga_tawar_total' => (float)$request->harga_tawar_total_p3[$kunci],
                    'harga_nego_otc' => (float)$request->harga_nego_otc_p3[$kunci],
                    'harga_nego_total' => (float)$request->harga_nego_total_p3[$kunci],
                    'harga_kerja_otc' => (float)$request->harga_kerja_otc_p3[$kunci],
                    'harga_kerja_total' => (float)$request->harga_kerja_total_p3[$kunci]
                  ]);
                }
              }
              if($request->detail_item_p4 && count($request->detail_item_p4) > 0){
                array_push($arr_lampiran_sebelum,'P4');
                foreach($request->detail_item_p4 as $kunci => $nilai){
                  array_push($arr_lampiran_baru,[
                    'obl_id' => $request->obl_id,
                    'tipe_form' => 'P4',
                    'detail_item' => $nilai,
                    'jumlah' => $request->jumlah_p4[$kunci],
                    'satuan' => $request->satuan_p4[$kunci],
                    'periode_bulan' => $request->periode_bulan_p4[$kunci],
                    'harga_tawar_otc' => (float)$request->harga_tawar_otc_p4[$kunci],
                    'harga_tawar_total' => (float)$request->harga_tawar_total_p4[$kunci],
                    'harga_nego_otc' => (float)$request->harga_nego_otc_p4[$kunci],
                    'harga_nego_total' => (float)$request->harga_nego_total_p4[$kunci],
                    'harga_kerja_otc' => (float)$request->harga_kerja_otc_p4[$kunci],
                    'harga_kerja_total' => (float)$request->harga_kerja_total_p4[$kunci]
                  ]);
                }
              }
              if($request->detail_item_p5 && count($request->detail_item_p5) > 0){
                array_push($arr_lampiran_sebelum,'P5');
                foreach($request->detail_item_p5 as $kunci => $nilai){
                  array_push($arr_lampiran_baru,[
                    'obl_id' => $request->obl_id,
                    'tipe_form' => 'P5',
                    'detail_item' => $nilai,
                    'jumlah' => $request->jumlah_p5[$kunci],
                    'satuan' => $request->satuan_p5[$kunci],
                    'periode_bulan' => $request->periode_bulan_p5[$kunci],
                    'harga_tawar_otc' => (float)$request->harga_tawar_otc_p5[$kunci],
                    'harga_tawar_total' => (float)$request->harga_tawar_total_p5[$kunci],
                    'harga_nego_otc' => (float)$request->harga_nego_otc_p5[$kunci],
                    'harga_nego_total' => (float)$request->harga_nego_total_p5[$kunci],
                    'harga_kerja_otc' => (float)$request->harga_kerja_otc_p5[$kunci],
                    'harga_kerja_total' => (float)$request->harga_kerja_total_p5[$kunci]
                  ]);
                }
              }
              if($request->detail_item_p6 && count($request->detail_item_p6) > 0){
                array_push($arr_lampiran_sebelum,'P6');
                foreach($request->detail_item_p6 as $kunci => $nilai){
                  array_push($arr_lampiran_baru,[
                    'obl_id' => $request->obl_id,
                    'tipe_form' => 'P6',
                    'detail_item' => $nilai,
                    'jumlah' => $request->jumlah_p6[$kunci],
                    'satuan' => $request->satuan_p6[$kunci],
                    'periode_bulan' => $request->periode_bulan_p6[$kunci],
                    'harga_tawar_otc' => (float)$request->harga_tawar_otc_p6[$kunci],
                    'harga_tawar_total' => (float)$request->harga_tawar_total_p6[$kunci],
                    'harga_nego_otc' => (float)$request->harga_nego_otc_p6[$kunci],
                    'harga_nego_total' => (float)$request->harga_nego_total_p6[$kunci],
                    'harga_kerja_otc' => (float)$request->harga_kerja_otc_p6[$kunci],
                    'harga_kerja_total' => (float)$request->harga_kerja_total_p6[$kunci]
                  ]);
                }
              }
              if($request->detail_item_p7 && count($request->detail_item_p7) > 0){
                array_push($arr_lampiran_sebelum,'P7');
                foreach($request->detail_item_p7 as $kunci => $nilai){
                  array_push($arr_lampiran_baru,[
                    'obl_id' => $request->obl_id,
                    'tipe_form' => 'P7',
                    'detail_item' => $nilai,
                    'jumlah' => $request->jumlah_p7[$kunci],
                    'satuan' => $request->satuan_p7[$kunci],
                    'periode_bulan' => $request->periode_bulan_p7[$kunci],
                    'harga_tawar_otc' => (float)$request->harga_tawar_otc_p7[$kunci],
                    'harga_tawar_total' => (float)$request->harga_tawar_total_p7[$kunci],
                    'harga_nego_otc' => (float)$request->harga_nego_otc_p7[$kunci],
                    'harga_nego_total' => (float)$request->harga_nego_total_p7[$kunci],
                    'harga_kerja_otc' => (float)$request->harga_kerja_otc_p7[$kunci],
                    'harga_kerja_total' => (float)$request->harga_kerja_total_p7[$kunci]
                  ]);
                }
              }
              if($request->detail_item_p8 && count($request->detail_item_p8) > 0){
                array_push($arr_lampiran_sebelum,'P8');
                foreach($request->detail_item_p8 as $kunci => $nilai){
                  array_push($arr_lampiran_baru,[
                    'obl_id' => $request->obl_id,
                    'tipe_form' => 'P8',
                    'detail_item' => $nilai,
                    'jumlah' => $request->jumlah_p8[$kunci],
                    'satuan' => $request->satuan_p8[$kunci],
                    'periode_bulan' => $request->periode_bulan_p8[$kunci],
                    'harga_tawar_otc' => (float)$request->harga_tawar_otc_p8[$kunci],
                    'harga_tawar_total' => (float)$request->harga_tawar_total_p8[$kunci],
                    'harga_nego_otc' => (float)$request->harga_nego_otc_p8[$kunci],
                    'harga_nego_total' => (float)$request->harga_nego_total_p8[$kunci],
                    'harga_kerja_otc' => (float)$request->harga_kerja_otc_p8[$kunci],
                    'harga_kerja_total' => (float)$request->harga_kerja_total_p8[$kunci]
                  ]);
                }
              }
              if($request->detail_item_sp && count($request->detail_item_sp) > 0){
                array_push($arr_lampiran_sebelum,'SP');
                foreach($request->detail_item_sp as $kunci => $nilai){
                  array_push($arr_lampiran_baru,[
                    'obl_id' => $request->obl_id,
                    'tipe_form' => 'SP',
                    'detail_item' => $nilai,
                    'jumlah' => $request->jumlah_sp[$kunci],
                    'satuan' => $request->satuan_sp[$kunci],
                    'periode_bulan' => $request->periode_bulan_sp[$kunci],
                    'harga_tawar_otc' => (float)$request->harga_tawar_otc_sp[$kunci],
                    'harga_tawar_total' => (float)$request->harga_tawar_total_sp[$kunci],
                    'harga_nego_otc' => (float)$request->harga_nego_otc_sp[$kunci],
                    'harga_nego_total' => (float)$request->harga_nego_total_sp[$kunci],
                    'harga_kerja_otc' => (float)$request->harga_kerja_otc_sp[$kunci],
                    'harga_kerja_total' => (float)$request->harga_kerja_total_sp[$kunci]
                  ]);
                }
              }
              if($request->detail_item_wo && count($request->detail_item_wo) > 0){
                array_push($arr_lampiran_sebelum,'WO');
                foreach($request->detail_item_wo as $kunci => $nilai){
                  array_push($arr_lampiran_baru,[
                    'obl_id' => $request->obl_id,
                    'tipe_form' => 'WO',
                    'detail_item' => $nilai,
                    'jumlah' => $request->jumlah_wo[$kunci],
                    'satuan' => $request->satuan_wo[$kunci],
                    'periode_bulan' => $request->periode_bulan_wo[$kunci],
                    'harga_tawar_otc' => (float)$request->harga_tawar_otc_wo[$kunci],
                    'harga_tawar_total' => (float)$request->harga_tawar_total_wo[$kunci],
                    'harga_nego_otc' => (float)$request->harga_nego_otc_wo[$kunci],
                    'harga_nego_total' => (float)$request->harga_nego_total_wo[$kunci],
                    'harga_kerja_otc' => (float)$request->harga_kerja_otc_wo[$kunci],
                    'harga_kerja_total' => (float)$request->harga_kerja_total_wo[$kunci]
                  ]);
                }
              }
              if($request->detail_item_kl && count($request->detail_item_kl) > 0){
                array_push($arr_lampiran_sebelum,'KL');
                foreach($request->detail_item_kl as $kunci => $nilai){
                  array_push($arr_lampiran_baru,[
                    'obl_id' => $request->obl_id,
                    'tipe_form' => 'KL',
                    'detail_item' => $nilai,
                    'jumlah' => $request->jumlah_kl[$kunci],
                    'satuan' => $request->satuan_kl[$kunci],
                    'periode_bulan' => $request->periode_bulan_kl[$kunci],
                    'harga_tawar_otc' => (float)$request->harga_tawar_otc_kl[$kunci],
                    'harga_tawar_total' => (float)$request->harga_tawar_total_kl[$kunci],
                    'harga_nego_otc' => (float)$request->harga_nego_otc_kl[$kunci],
                    'harga_nego_total' => (float)$request->harga_nego_total_kl[$kunci],
                    'harga_kerja_otc' => (float)$request->harga_kerja_otc_kl[$kunci],
                    'harga_kerja_total' => (float)$request->harga_kerja_total_kl[$kunci]
                  ]);
                }
              }

              DB::connection('pgsql')->table('form_lampiran')->where('obl_id',$request->obl_id)->whereIn('tipe_form',$arr_lampiran_sebelum)->delete();
              DB::connection('pgsql')->table('form_lampiran')->insert($arr_lampiran_baru);
              return redirect('obl-tables')->with('status', 'Sukses Simpan Data Lampiran');

            }
            catch(Throwable $e){
              return redirect('obl-tables')->with('status','Oops! Gagal Simpan Data Lampiran.');
            }
          }
          else{ return redirect('obl-tables')->with('status', 'Oops! ID OBL Terkait Gagal Dicek.'); }
        }
        else{ return redirect('obl-tables')->with('status', 'Oops! Wrong Routing.'); }
      }
      else{ return redirect('obl-tables')->with('status', 'Oops! Wrong Routing.'); }
    }
}
