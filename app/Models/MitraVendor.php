<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MitraVendor extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';
    protected $table = 'mitras';


    public const NamaVendor = [
      [ 'kode_vendor'=>'','nama_vendor'=>'PT PUTRA BISTEL SOLUSINDO'],
      [ 'kode_vendor'=>'','nama_vendor'=>'CEMITEL'],
      [ 'kode_vendor'=>'','nama_vendor'=>'COMTECH AGUNG'],
      [ 'kode_vendor'=>'','nama_vendor'=>'INDOSAT'],
      [ 'kode_vendor'=>'','nama_vendor'=>'INFOMEDIA NUSANTARA'],
      [ 'kode_vendor'=>'','nama_vendor'=>'ISH'],
      [ 'kode_vendor'=>'','nama_vendor'=>'JAYANTARA'],
      [ 'kode_vendor'=>'','nama_vendor'=>'KOMET'],
      [ 'kode_vendor'=>'','nama_vendor'=>'KOPEG BJM'],
      [ 'kode_vendor'=>'','nama_vendor'=>'KOPEGTEL BALIKPAPAN'],
      [ 'kode_vendor'=>'','nama_vendor'=>'KOPEGTEL BANJARMASIN'],
      [ 'kode_vendor'=>'','nama_vendor'=>'Kopegtel Banjarmsin'],
      [ 'kode_vendor'=>'','nama_vendor'=>'KOPEGTEL PONTIANAK'],
      [ 'kode_vendor'=>'','nama_vendor'=>'Koperasi Metropolitan'],
      [ 'kode_vendor'=>'','nama_vendor'=>'KOPKAR SMART MEDIA'],
      [ 'kode_vendor'=>'','nama_vendor'=>'MD MEDIA'],
      [ 'kode_vendor'=>'','nama_vendor'=>'METRANET'],
      [ 'kode_vendor'=>'','nama_vendor'=>'MINOVA'],
      [ 'kode_vendor'=>'','nama_vendor'=>'MITRATEL'],
      [ 'kode_vendor'=>'','nama_vendor'=>'NUTECH'],
      [ 'kode_vendor'=>'','nama_vendor'=>'PINS'],
      [ 'kode_vendor'=>'','nama_vendor'=>'POINTER'],
      [ 'kode_vendor'=>'','nama_vendor'=>'PT Dayamitra Telekomunikasi'],
      [ 'kode_vendor'=>'','nama_vendor'=>'PT Dayamitra Telekomunikasi, tbk'],
      [ 'kode_vendor'=>'','nama_vendor'=>'PT Graha Sarana Duta'],
      [ 'kode_vendor'=>'','nama_vendor'=>'PT Graha Sarana Duta Area VI Kalimantan'],
      [ 'kode_vendor'=>'','nama_vendor'=>'PT INFOMEDIA NUSANTARA'],
      [ 'kode_vendor'=>'','nama_vendor'=>'PT Mitra Inovasi Jayantara'],
      [ 'kode_vendor'=>'','nama_vendor'=>'PT Sigma Cipta Caraka'],
      [ 'kode_vendor'=>'','nama_vendor'=>'PT Sumbersolusindo Hitech'],
      [ 'kode_vendor'=>'','nama_vendor'=>'PT TELKOM  SATELIT INDONESIA'],
      [ 'kode_vendor'=>'','nama_vendor'=>'PT Telkom Prima Cipta Certfia'],
      [ 'kode_vendor'=>'','nama_vendor'=>'PT Telkom Satelit Indonesia'],
      [ 'kode_vendor'=>'','nama_vendor'=>'PT WAVE COMMUNICATION INDONESIA'],
      [ 'kode_vendor'=>'','nama_vendor'=>'PT. Jalin Mayantara Indonesia'],
      [ 'kode_vendor'=>'','nama_vendor'=>'PT. SIGMA CIPTA CARAKA'],
      [ 'kode_vendor'=>'','nama_vendor'=>'PT. Sumber Solusindo Hitech'],
      [ 'kode_vendor'=>'','nama_vendor'=>'PT.WAVECOMINDO'],
      [ 'kode_vendor'=>'','nama_vendor'=>'PUTRA BISTEL'],
      [ 'kode_vendor'=>'','nama_vendor'=>'SIGMA'],
      [ 'kode_vendor'=>'','nama_vendor'=>'SISTELINDO'],
      [ 'kode_vendor'=>'','nama_vendor'=>'SSH'],
      [ 'kode_vendor'=>'','nama_vendor'=>'SUMBER SOLUSINDO'],
      [ 'kode_vendor'=>'','nama_vendor'=>'SUMBER SOLUSINDO HITECH'],
      [ 'kode_vendor'=>'','nama_vendor'=>'Sumbersolusindo Hitech'],
      [ 'kode_vendor'=>'','nama_vendor'=>'SYNETCOM'],
      [ 'kode_vendor'=>'','nama_vendor'=>'TEKOMSAT'],
      [ 'kode_vendor'=>'','nama_vendor'=>'TELKOM AKSES'],
      [ 'kode_vendor'=>'','nama_vendor'=>'TELKOMSAT'],
      [ 'kode_vendor'=>'','nama_vendor'=>'TPCC'],
      [ 'kode_vendor'=>'','nama_vendor'=>'WAVECOMINDO']
    ];

    public static function getNamaVendor()
    {
        $nama_vendor = [];
        foreach (self::NamaVendor as $key => $status) {
            $nama_vendor[$key] = __($status['nama_vendor']);
        }

        return $nama_vendor;
    }

}
