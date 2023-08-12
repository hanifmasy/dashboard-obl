<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\InputsController;
use App\Http\Controllers\DrafsController;
use App\Http\Controllers\TableOblController;
use App\Http\Controllers\WitelsController;
use App\Http\Controllers\LampiransController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\TestingController;
use Illuminate\Support\Facades\DB;
use App\Models\MitraVendor;
use App\Models\DocObl;


// AUTH USER PROCESSES
Route::get('/', function () {return redirect('sign-in');})->middleware('guest');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
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
// Route::get('profile', [ProfileController::class, 'create'])->middleware('auth')->name('profile');
Route::post('sign-out', [SessionsController::class, 'destroy'])->middleware('auth')->name('logout');

// GET VIEW ( PAGES )
Route::group(['middleware' => 'auth'], function () {
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
			//dd($list_nomor_kb);
		$mitra_vendor = MitraVendor::get()->toArray();
		return view('pages.inputs',compact('mitra_vendor','list_nomor_kb')); })->name('inputs');
	Route::get('witels', function () { $mitra_vendor = MitraVendor::get()->toArray(); return view('pages.witels',compact('mitra_vendor')); })->name('witels');
	// CUSTOME ERROR PAGE
	Route::get('page-404', function () { return view('failed_routes.page_404'); })->name('page_404');
	Route::get('page-500', function () { return view('failed_routes.page_500'); })->name('page_500');
});

// GET VIEW WITH METHOD
// Route::get('obl-drafs', [DrafsController::class, 'drafs'])->middleware('auth')->name('obl.drafs');
Route::get('obl-tables', [TableOblController::class, 'tables'])->middleware('auth')->name('obl.tables');
Route::get('testing', [TestingController::class, 'index'])->middleware('auth')->name('testing.index');

// POST METHOD ( PAGES )
Route::post('inputs/create', [InputsController::class, 'create'])->middleware('auth')->name('inputs.create');
Route::post('witels/create', [WitelsController::class, 'create'])->middleware('auth')->name('witels.create');

// Route::post('obl-drafs/edit', [DrafsController::class, 'edit'])->middleware('auth')->name('obl.drafs.edit');
// Route::post('obl-drafs/edit/update', [DrafsController::class, 'update'])->middleware('auth')->name('obl.drafs.edit.update');
// Route::post('obl-drafs/delete', [DrafsController::class, 'delete'])->middleware('auth')->name('obl.drafs.delete');

Route::post('obl-tables/delete', [TableOblController::class, 'delete'])->middleware('auth')->name('obl.tables.delete');
Route::post('obl-tables/multidelete', [TableOblController::class, 'multidelete'])->middleware('auth')->name('obl.tables.multidelete');
Route::post('obl-tables/excel', [TableOblController::class, 'excel'])->middleware('auth')->name('obl.tables.excel');
Route::post('obl-tables/edit', [TableOblController::class, 'edit'])->middleware('auth')->name('obl.tables.edit');
Route::post('obl-tables/ketdoc', [TableOblController::class, 'ketdoc'])->middleware('auth')->name('obl.tables.ketdoc');
Route::post('obl-tables/edit/update', [TableOblController::class, 'update'])->middleware('auth')->name('obl.tables.edit.update');

Route::post('obl-lampiran', [LampiransController::class, 'index'])->middleware('auth')->name('obl.lampiran.index');
Route::post('obl-lampiran/create', [LampiransController::class, 'create'])->middleware('auth')->name('obl.lampiran.create');

Route::post('obl-print', [PrintController::class, 'index'])->middleware('auth')->name('obl.print.index');
Route::post('obl-print/create', [PrintController::class, 'create'])->middleware('auth')->name('obl.print.create');

Route::get('obl-upload', [UploadController::class, 'index'])->middleware('auth')->name('obl.upload.index');
Route::post('obl-tables/upload', [UploadController::class, 'tableUpload'])->middleware('auth')->name('obl.tables.upload');
