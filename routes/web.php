<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\InputsController;
use App\Http\Controllers\TableOblController;
use App\Http\Controllers\WitelsController;
use App\Http\Controllers\LampiransController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\SolutionController;
use App\Http\Controllers\ProsesOblController;
use App\Http\Controllers\TestingController;
use Illuminate\Support\Facades\DB;
use App\Models\MitraVendor;
use App\Models\DocObl;


// AUTH USER PROCESSES
Route::get('/', function () {return redirect('sign-in');})->middleware('guest');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth','cbd'])->name('dashboard');
Route::get('sign-up', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('sign-up', [RegisterController::class, 'store'])->middleware('guest');
Route::get('sign-in', [SessionsController::class, 'create'])->middleware('guest');
Route::post('sign-in', [SessionsController::class, 'store'])->middleware('guest')->name('login');
Route::post('verify', [SessionsController::class, 'show'])->middleware('guest');
Route::post('reset-password', [SessionsController::class, 'update'])->middleware('guest')->name('password.update');
Route::get('verify', function () {
	return view('sessions.password.verify');
})->middleware('guest')->name('verify');
Route::get('/reset-password/{token}', function ($token) {
	return view('sessions.password.reset', ['token' => $token]);
})->middleware('guest')->name('password.reset');
Route::get('user-profile', [ProfileController::class, 'create'])->middleware('auth')->name('user-profile');
Route::post('user-profile', [ProfileController::class, 'update'])->middleware('auth');
Route::post('sign-out', [SessionsController::class, 'destroy'])->middleware('auth')->name('logout');


// GET VIEW ( PAGES )
Route::group(['middleware' => 'auth'], function () {
	Route::get('page-404', function () { return view('failed_routes.page_404'); })->name('page_404');
	Route::get('page-500', function () { return view('failed_routes.page_500'); })->name('page_500');
});


// GET VIEW WITH METHODS
Route::get('obl-tables', [TableOblController::class, 'tables'])->middleware('auth')->name('obl.tables');
Route::get('obl-files', [UploadController::class, 'index'])->middleware(['auth','role_files'])->name('obl.upload.index');
Route::get('inputs', function () {
	$list_nomor_kb = DocObl::select(
			DB::raw("
			case
				when (kl_nomor_kb is not null and kl_nomor_kb <> '') and f1_jenis_spk = 'KL' then kl_nomor_kb
				when (sp_nomor_kb is not null and sp_nomor_kb <> '') and f1_jenis_spk = 'SP' then sp_nomor_kb
				when (wo_nomor_kb is not null and wo_nomor_kb <> '') and f1_jenis_spk = 'WO' then wo_nomor_kb
				else ''
			end as nomor_kb
			"),
			'f1_jenis_spk',
			'f1_nama_plggn'
		)->get()->toArray();
	$mitra_vendor = MitraVendor::get()->toArray();
	return view('pages.inputs',compact('mitra_vendor','list_nomor_kb')); })->middleware(['auth','role_obl'])->name('inputs');
Route::get('witels', function () { $mitra_vendor = MitraVendor::get()->toArray(); return view('pages.witels',compact('mitra_vendor')); })->middleware(['auth','role_witel'])->name('witels');
Route::get('testing', [TestingController::class, 'index'])->middleware(['auth','role_super'])->name('testing.index');


// POST METHOD ( PAGES )
Route::post('inputs/create', [InputsController::class, 'create'])->middleware(['auth','role_obl_non_view'])->name('inputs.create');

Route::post('witels/create', [WitelsController::class, 'create'])->middleware(['auth','role_witel'])->name('witels.create');
Route::post('witels/edit', [WitelsController::class, 'edit'])->middleware(['auth','role_witel'])->name('witels.edit');
Route::post('witels/forms', [WitelsController::class, 'forms'])->middleware(['auth','role_witel'])->name('witels.forms');
Route::post('witels/forms/create', [WitelsController::class, 'formsCreate'])->middleware(['auth','role_witel'])->name('witels.forms.create');
Route::post('witels/files', [WitelsController::class, 'files'])->middleware(['auth','role_witel'])->name('witels.files');
Route::post('witels/files/upload', [WitelsController::class, 'upload'])->middleware(['auth','role_witel'])->name('witels.files.upload');

Route::post('obl-tables/edit', [TableOblController::class, 'edit'])->middleware(['auth','role_files_upload'])->name('obl.tables.edit');
Route::post('obl-tables/excel', [TableOblController::class, 'excel'])->middleware('auth')->name('obl.tables.excel');
Route::post('obl-tables/ketdoc', [TableOblController::class, 'ketdoc'])->middleware('auth')->name('obl.tables.ketdoc');
Route::post('obl-tables/delete', [TableOblController::class, 'delete'])->middleware(['auth','role_delete_doc'])->name('obl.tables.delete');
Route::post('obl-tables/multidelete', [TableOblController::class, 'multidelete'])->middleware(['auth','role_obl_non_view'])->name('obl.tables.multidelete');
Route::post('obl-tables/edit/update', [TableOblController::class, 'update'])->middleware(['auth','role_files_upload'])->name('obl.tables.edit.update');

Route::post('obl-tables/kembali-witel', [SolutionController::class, 'kembaliWitel'])->middleware(['auth','role_solution'])->name('obl.tables.kembali_witel');
Route::post('obl-tables/lanjut-obl', [SolutionController::class, 'lanjutObl'])->middleware(['auth','role_solution'])->name('obl.tables.lanjut_obl');

 Route::post('obl-tables/proses-witel', [ProsesOblController::class, 'prosesWitel'])->middleware(['auth','role_obl_non_view'])->name('obl.tables.proses_witel');
 Route::post('obl-tables/proses-obl', [ProsesOblController::class, 'prosesObl'])->middleware(['auth','role_obl_non_view'])->name('obl.tables.proses_obl');
 Route::post('obl-tables/legal-obl', [ProsesOblController::class, 'legalObl'])->middleware(['auth','role_obl_non_view'])->name('obl.tables.legal_obl');
 Route::post('obl-tables/mitra-obl', [ProsesOblController::class, 'mitraObl'])->middleware(['auth','role_obl_non_view'])->name('obl.tables.mitra_obl');
 Route::post('obl-tables/closesm-obl', [ProsesOblController::class, 'closesmObl'])->middleware(['auth','role_obl_non_view'])->name('obl.tables.closesm_obl');
 Route::post('obl-tables/done-obl', [ProsesOblController::class, 'doneObl'])->middleware(['auth','role_obl_non_view'])->name('obl.tables.done_obl');
 Route::post('obl-tables/cancel-obl', [ProsesOblController::class, 'cancelObl'])->middleware(['auth','role_obl_non_view'])->name('obl.tables.cancel_obl');

Route::post('obl-lampiran', [LampiransController::class, 'index'])->middleware(['auth','role_obl_non_view'])->name('obl.lampiran.index');
Route::post('obl-lampiran/create', [LampiransController::class, 'create'])->middleware(['auth','role_obl_non_view'])->name('obl.lampiran.create');

Route::post('obl-print', [PrintController::class, 'index'])->middleware(['auth','role_files_upload'])->name('obl.print.index');
Route::post('obl-print/create', [PrintController::class, 'create'])->middleware(['auth','role_files_upload'])->name('obl.print.create');

Route::post('obl-files/cari', [UploadController::class, 'cari'])->middleware(['auth','role_files'])->name('obl.upload.cari');
Route::post('obl-tables/files', [UploadController::class, 'tableUpload'])->middleware(['auth','role_table_files'])->name('obl.tables.upload');
Route::post('obl-files/create', [UploadController::class, 'create'])->middleware(['auth','role_files_upload'])->name('obl.upload.create');

Route::get('download', [FilesController::class, 'download'])->middleware(['auth','role_table_files'])->name('obl.files.download');
Route::get('visibility', [FilesController::class, 'visibility'])->middleware(['auth','role_table_files'])->name('obl.files.visibility');
