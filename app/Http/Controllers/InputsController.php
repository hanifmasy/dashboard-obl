<?php

namespace App\Http\Controllers;

Use Str;
Use Hash;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;

class InputsController extends Controller
{
    public function create(Request $request){
        // input form
        $collection = collect($request->all());
        $filtered = $collection->except([
            '_token',
            'lampiran_layanan_barang',
            'lampiran_spesifikasi',
            'lampiran_merek',
            'lampiran_volume',
            'lampiran_satuan',
            'lampiran_harga_satuan',
            'lampiran_harga_total'
        ]);
        $id = DB::connection('pgsql')->table('form_p2kl')
        ->insertGetId(
            $filtered->all()
        );
        // input lampiran
        if($request->lampiran_layanan_barang){
            $array_insert = [];
            foreach($request->lampiran_layanan_barang as $key => $value){
                array_push(
                    $array_insert,
                    [
                        'kontrak_id' => $id,
                        'lampiran_layanan_barang' => $value,
                        'lampiran_spesifikasi' => '',
                        'lampiran_merek' => '',
                        'lampiran_volume' => '',
                        'lampiran_satuan' => '',
                        'lampiran_harga_satuan' => '',
                        'lampiran_harga_total' => ''
                    ]
                );
            }

            foreach($request->lampiran_spesifikasi as $key => $value){
                $array_insert[$key]['lampiran_spesifikasi'] = $value;
            }

            foreach($request->lampiran_merek as $key => $value){
                $array_insert[$key]['lampiran_merek'] = $value;
            }

            foreach($request->lampiran_volume as $key => $value){
                $array_insert[$key]['lampiran_volume'] = $value;
            }

            foreach($request->lampiran_satuan as $key => $value){
                $array_insert[$key]['lampiran_satuan'] = $value;
            }

            foreach($request->lampiran_harga_satuan as $key => $value){
                $array_insert[$key]['lampiran_harga_satuan'] = $value;
            }

            foreach($request->lampiran_harga_total as $key => $value){
                $array_insert[$key]['lampiran_harga_total'] = $value;
            }

            DB::connection('pgsql')->table('lampiran_p2kl')
            ->insert(
                $array_insert
            );
        }

        return redirect('inputs')->with('status', 'Data inserted!');

    }
}
