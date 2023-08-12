<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\Handler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\Word2007;
use App\Models\User;
use App\Models\DocObl;
use Carbon\Carbon;
use DataTables;

class TestingController extends Controller
{
    public function index(Request $request)
    {

      // dd( storage_path('app/public') );

      $phpWord = new PhpWord();
        // Setting various styles to be used
        $phpWord->addParagraphStyle('p1Style', array('align'=>'both', 'spaceAfter'=>0, 'spaceBefore'=>0));
        $phpWord->addParagraphStyle('p2Style', array('align'=>'both'));
        $phpWord->addParagraphStyle('p3Style', array('align'=>'right', 'spaceAfter'=>0, 'spaceBefore'=>0));
        $phpWord->addFontStyle('f1Style', array('name' => 'Calibri', 'size'=>12));
        $phpWord->addFontStyle('f2Style', array('name' => 'Calibri','bold'=>true, 'size'=>12));
        $company = "ABC (Private) Limited";
        // Defining data. For simplicity we're using hardcoded data; practically they will be fetched from database.
        $no_of_banks = 3;
        $branches = ["Clifton Branch","Defence Branch","15th Street Branch"];
        $begin = Carbon::parse("1/1/2020");
        $end = Carbon::parse("12/31/2020");
        $year = $end->year;
        $str = "first Monday of July {$year}";
        $date = new Carbon($str);
        // Getting first characters from company name for generating reference
        $name = str_replace(["(",")"],"",$company);
        $words = preg_split("/[\s,_-]+/", $name);
        $acronym = "";
        $count = 1;
        foreach ($words as $w) {
            $acronym .= $w[0];
        }
        // Generating letter for each branch
        for($i=0;$i<count($branches);$i++) {
            $section = $phpWord->addSection();

            $textrun = $section->addTextRun();
            $section->addTextBreak(2);

            $ref = "MZ-BCONF/".$acronym."/".$year."/".$count++;
            $section->addText($ref, 'f2Style', 'p1Style');

            $textrun = $section->addTextRun();
            $section->addTextBreak(1);

            $section->addText($date->format('F j, Y'), 'f2Style', 'p1Style');

            $textrun = $section->addTextRun();
            $section->addTextBreak(0);

            $section->addText('The Manager,','f1Style','p1Style');
            $section->addText($branches[$i],'f1Style','p1Style');

            $textrun = $section->addTextRun();
            $section->addTextBreak(0);
            $section->addText('Dear Sir,','f1Style','p2Style');

            $textrun = $section->addTextRun();
            $section->addTextBreak(0);

            $textrun = $section->addTextRun('p2Style');
            $textrun->addText('Subject: ', 'f1Style');
            $textrun->addText('Bank Report for Audit Purpose of ', 'f2Style');
            $textrun->addText($company, 'f2Style');

            $textrun = $section->addTextRun();
            $section->addTextBreak(0);

            $textrun = $section->addTextRun('p2Style');
            $textrun->addText(
                "In accordance with your above named customer’s instructions given hereon, please send DIRECT to us at the below address, as auditors of your customer, the following information relating to their affairs at your branch as at the close of business on ",
                'f1Style',
            );
            $textrun->addText($end->format('F j, Y'), 'f2Style');
            $textrun->addText(
                " and, in the case of items 2, 4 and 9, during the period since ",
                'f1Style',
            );
            $textrun->addText($begin->format('F j, Y'), 'f2Style');

            $textrun = $section->addTextRun();
            $section->addTextBreak(0);

            $textrun = $section->addTextRun();
            $textrun->addText(
                "Please state against each item any factors which may limit the completeness of your reply; if there is nothing to report, state ‘NONE’.",
                'f1Style', 'p2Style'
            );

            $textrun = $section->addTextRun();
            $section->addTextBreak(0);

            $textrun = $section->addTextRun();
            $textrun->addText(
                "It is understood that any replies given are in strict confidence, for the purposes of audit.",
                'f1Style', 'p2Style'
            );

            $textrun = $section->addTextRun();
            $section->addTextBreak(0);

            $textrun = $section->addTextRun();
            $textrun->addText(
                "Yours truly,",
                'f1Style', 'p2Style'
            );

            $section->addText(
                "Disclosure  Authorized",
                'f2Style', 'p3Style'
            );

            $section->addText(
                "For  and  on  behalf  of",
                'f2Style', 'p3Style'
            );

            $textrun = $section->addTextRun();
            $section->addTextBreak(1);

            $textrun = $section->addTextRun();
            $textrun->addText(
                "Chartered Accountants                                                                                  ___________________",
                'f2Style', 'p2Style'
            );

            $textrun = $section->addTextRun();
            $section->addTextBreak(0);

            $textrun = $section->addTextRun();
            $textrun->addText(
                "Enclosures:",
                'f1Style', 'p2Style'
            );

        }

        $writer = new Word2007($phpWord);
        $file_path = public_path().'/temp_saved_docs';
        $writer->save($file_path.'/saved_letter.docx');
        // Storage::put(storage_path('app/public').'/storage/temp_saved_docs/saved_letter.docx',file_get_contents($writer));
        $headers = array(
            'Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        );
        return response()->download( $file_path . '/saved_letter.docx', 'download_letter.docx', $headers);


      // $insert_user_db = [
      //     [ 'nama_lengkap'=>'Permata Sari Sugianto'	,'username'=>'adminpermata', 'email'=>'adminpermata@material.com'	, 'password'=>'zakypandaungu' ],
      //     [ 'nama_lengkap'=>'Pertiwi Mega Reformasintia'	,'username'=>'adminpertiwi', 'email'=>'adminpertiwi@material.com'	, 'password'=>'adminobl2' ],
      //     [ 'nama_lengkap'=>'Puspa Ramadhani'	,'username'=>'adminpuspa', 'email'=>'adminpuspa@material.com'	, 'password'=>'adminobl3' ],
      //     [ 'nama_lengkap'=>'Domas Indri Lestari'	,'username'=>'admindomas', 'email'=>'admindomas@material.com'	, 'password'=>'adminobl4' ],
      //     [ 'nama_lengkap'=>'Chaeril'	,'username'=>'adminchaeril', 'email'=>'adminchaeril@material.com'	, 'password'=>'adminobl5' ],
      //     [ 'nama_lengkap'=>'Dinul Qoyimah'	,'username'=>'admindinul', 'email'=>'admindinul@material.com'	, 'password'=>'adminpjm1' ],
      //     [ 'nama_lengkap'=>'Sthevy Simak Lando'	,'username'=>'adminsthevy', 'email'=>'adminsthevy@material.com'	, 'password'=>'adminpjm2' ],
      //     [ 'nama_lengkap'=>'Witel Balikpapan'	,'username'=>'witelbpp', 'email'=>'witelbpp@material.com'	, 'password'=>'akunwitelbpp' ],
      //     [ 'nama_lengkap'=>'Witel Samarinda'	,'username'=>'witelsmd', 'email'=>'witelsmd@material.com'	, 'password'=>'akunwitelsmd' ],
      //     [ 'nama_lengkap'=>'Witel Kalbar'	,'username'=>'witelkalbar', 'email'=>'witelkalbar@material.com'	, 'password'=>'akunwitelkalbar' ],
      //     [ 'nama_lengkap'=>'Witel Kalsel'	,'username'=>'witelkalsel', 'email'=>'witelkalsel@material.com'	, 'password'=>'akunwitelkalsel' ],
      //     [ 'nama_lengkap'=>'Witel Kalteng'	,'username'=>'witelkalteng', 'email'=>'witelkalteng@material.com'	, 'password'=>'akunwitelkalteng' ],
      //     [ 'nama_lengkap'=>'Witel Kaltara'	,'username'=>'witelkaltara', 'email'=>'witelkaltara@material.com'	, 'password'=>'akunwitelkaltara' ],
      //     [ 'nama_lengkap'=>'TELKOMSAT'	,'username'=>'mitratelkomsat', 'email'=>'mitratelkomsat@material.com'	, 'password'=>'akunmitratelkomsat' ],
      //     [ 'nama_lengkap'=>'KOPEGTEL BANJARMASIN'	,'username'=>'mitrakopegtel', 'email'=>'mitrakopegtel@material.com'	, 'password'=>'akunmitrakopegtel' ],
      //     [ 'nama_lengkap'=>'INFOMEDIA NUSANTARA'	,'username'=>'mitrainfomedia', 'email'=>'mitrainfomedia@material.com'	, 'password'=>'akunmitrainfomedia' ],
      //     [ 'nama_lengkap'=>'MD MEDIA'	,'username'=>'mitramd', 'email'=>'mitramd@material.com'	, 'password'=>'akunmitramd' ],
      //     [ 'nama_lengkap'=>'SIGMA'	,'username'=>'mitrasigma', 'email'=>'mitrasigma@material.com'	, 'password'=>'akunmitrasigma' ],
      //     [ 'nama_lengkap'=>'KOPKAR SMART MEDIA'	,'username'=>'mitrakopkar', 'email'=>'mitrakopkar@material.com'	, 'password'=>'akunmitrakopkar' ],
      //     [ 'nama_lengkap'=>'WAVECOMINDO'	,'username'=>'mitrawavecomindo', 'email'=>'mitrawavecomindo@material.com'	, 'password'=>'akunmitrawavecomindo' ],
      //     [ 'nama_lengkap'=>'SUMBER SOLUSINDO HITECH'	,'username'=>'mitrasumber', 'email'=>'mitrasumber@material.com'	, 'password'=>'akunmitrasumber' ],
      //     [ 'nama_lengkap'=>'CEMITEL'	,'username'=>'mitracemitel', 'email'=>'mitracemitel@material.com'	, 'password'=>'akunmitracemitel' ],
      //     [ 'nama_lengkap'=>'MITRATEL'	,'username'=>'mitramitratel', 'email'=>'mitramitratel@material.com'	, 'password'=>'akunmitramitratel' ],
      //     [ 'nama_lengkap'=>'PUTRA BISTEL'	,'username'=>'mitraputra', 'email'=>'mitraputra@material.com'	, 'password'=>'akunmitraputra' ],
      //     [ 'nama_lengkap'=>'INDOSAT'	,'username'=>'mitraindosat', 'email'=>'mitraindosat@material.com'	, 'password'=>'akunmitraindosat' ],
      //     [ 'nama_lengkap'=>'SISTELINDO'	,'username'=>'mitrasistelindo', 'email'=>'mitrasistelindo@material.com'	, 'password'=>'akunmitrasistelindo' ],
      //     [ 'nama_lengkap'=>'TPCC'	,'username'=>'mitratpcc', 'email'=>'mitratpcc@material.com'	, 'password'=>'akunmitratpcc' ],
      //     [ 'nama_lengkap'=>'PINS'	,'username'=>'mitrapins', 'email'=>'mitrapins@material.com'	, 'password'=>'akunmitrapins' ],
      //     [ 'nama_lengkap'=>'MINOVA'	,'username'=>'mitraminova', 'email'=>'mitraminova@material.com'	, 'password'=>'akunmitraminova' ],
      //     [ 'nama_lengkap'=>'SYPUMA'	,'username'=>'mitrasypuma', 'email'=>'mitrasypuma@material.com'	, 'password'=>'akunmitrasypuma' ],
      //     [ 'nama_lengkap'=>'SYNETCOM'	,'username'=>'mitrasynetcom', 'email'=>'mitrasynetcom@material.com'	, 'password'=>'akunmitrasynetcom' ],
      //     [ 'nama_lengkap'=>'COMTECH AGUNG'	,'username'=>'mitracomtech', 'email'=>'mitracomtech@material.com'	, 'password'=>'akunmitracomtech' ],
      //     [ 'nama_lengkap'=>'NUTECH'	,'username'=>'mitranutech', 'email'=>'mitranutech@material.com'	, 'password'=>'akunmitranutech' ],
      //     [ 'nama_lengkap'=>'POINTER'	,'username'=>'mitrapointer', 'email'=>'mitrapointer@material.com'	, 'password'=>'akunmitrapointer' ],
      //     [ 'nama_lengkap'=>'TELKOM AKSES'	,'username'=>'mitratelkom', 'email'=>'mitratelkom@material.com'	, 'password'=>'akunmitratelkom' ],
      //     [ 'nama_lengkap'=>'METRANET'	,'username'=>'mitrametranet', 'email'=>'mitrametranet@material.com'	, 'password'=>'akunmitrametranet' ],
      //     [ 'nama_lengkap'=>'ISH'	,'username'=>'mitraish', 'email'=>'mitraish@material.com'	, 'password'=>'akunmitraish' ],
      //     [ 'nama_lengkap'=>'Rio Wibisono'	,'username'=>'adminrio', 'email'=>'adminrio@material.com'	, 'password'=>'adminpjm' ],
      //     [ 'nama_lengkap'=>'Septian Zakaria'	,'username'=>'adminseptian', 'email'=>'adminseptian@material.com'	, 'password'=>'septianz' ],
      //     [ 'nama_lengkap'=>'Andhy Panca Saputra'	,'username'=>'adminandhy', 'email'=>'adminandhy@material.com'	, 'password'=>'adminobl6' ],
      //     [ 'nama_lengkap'=>'Taufik'	,'username'=>'admintaufik', 'email'=>'admintaufik@material.com'	, 'password'=>'adminobl7' ],
      //     [ 'nama_lengkap'=>'Yayan Nuryana'	,'username'=>'adminyayan', 'email'=>'adminyayan@material.com'	, 'password'=>'adminobl8' ],
      //     [ 'nama_lengkap'=>'Witel Balikpapan'	,'username'=>'balikpapan', 'email'=>'balikpapan@material.com'	, 'password'=>'akunmgrwitelbpp' ],
      //     [ 'nama_lengkap'=>'Witel Samarinda'	,'username'=>'samarinda', 'email'=>'samarinda@material.com'	, 'password'=>'akunmgrwitelsmd' ],
      //     [ 'nama_lengkap'=>'Manager Witel Kalbar'	,'username'=>'kalbar', 'email'=>'kalbar@material.com'	, 'password'=>'akunmgrwitelkalbar' ],
      //     [ 'nama_lengkap'=>'Witel Kalsel'	,'username'=>'kalsel', 'email'=>'kalsel@material.com'	, 'password'=>'akunmgrwitelkalsel' ],
      //     [ 'nama_lengkap'=>'Witel Kaltara'	,'username'=>'kaltara', 'email'=>'kaltara@material.com'	, 'password'=>'akunmgrwitelkaltara' ],
      //     [ 'nama_lengkap'=>'Witel Kalteng'	,'username'=>'kalteng', 'email'=>'kalteng@material.com'	, 'password'=>'akunmgrwitelkalteng' ],
      //     [ 'nama_lengkap'=>'TESTER'	,'username'=>'tester', 'email'=>'tester@material.com'	, 'password'=>'akuntester' ],
      //     [ 'nama_lengkap'=>'PT TELKOM  SATELIT INDONESIA'	,'username'=>'mitrapt', 'email'=>'mitrapt@material.com'	, 'password'=>'akunmitrapt' ],
      //     [ 'nama_lengkap'=>'Cahaya'	,'username'=>'admincahaya', 'email'=>'admincahaya@material.com'	, 'password'=>'mamadedeh' ],
      //     [ 'nama_lengkap'=>'SSH'	,'username'=>'mitrassh', 'email'=>'mitrassh@material.com'	, 'password'=>'akunmitrassh' ],
      //     [ 'nama_lengkap'=>'Haris Solution'	,'username'=>'harissolution', 'email'=>'harissolution@material.com'	, 'password'=>'harissolution' ],
      //     [ 'nama_lengkap'=>'Satria Solution'	,'username'=>'satriasolution', 'email'=>'satriasolution@material.com'	, 'password'=>'satriasolution' ],
      //     [ 'nama_lengkap'=>'Titis Yulinar'	,'username'=>'titissolution', 'email'=>'titissolution@material.com'	, 'password'=>'titissolution' ],
      //     [ 'nama_lengkap'=>'Novi'	,'username'=>'adminnovi', 'email'=>'adminnovi@material.com'	, 'password'=>'adminobl9' ],
      //     [ 'nama_lengkap'=>'Eva'	,'username'=>'evasolution', 'email'=>'evasolution@material.com'	, 'password'=>'evasolution1' ],
      //     [ 'nama_lengkap'=>'Risa'	,'username'=>'adminrisa', 'email'=>'adminrisa@material.com'	, 'password'=>'adminobl10' ],
      //     [ 'nama_lengkap'=>'Adel'	,'username'=>'adminadel', 'email'=>'adminadel@material.com'	, 'password'=>'adminobl11' ],
      //     [ 'nama_lengkap'=>'Akbar'	,'username'=>'adminakbar', 'email'=>'adminakbar@material.com'	, 'password'=>'adminobl12' ]
      //   ];
      //   $insert_user_db_1 = [];
      //   foreach($insert_user_db as $key => $value){
      //     array_push($insert_user_db_1,
      //       [
      //         'nama_lengkap'=>$value['nama_lengkap'],
      //         'username'=>$value['username'],
      //         'email'=>$value['email'],
      //         'password'=>bcrypt($value['password'])
      //       ]
      //     );
      //   }
      //   // dd($insert_user_db_1);
      //   $return_hasil = DB::connection('pgsql')->table('users')->insert($insert_user_db_1);
      //
      //   dd($return_hasil);
    }
}
