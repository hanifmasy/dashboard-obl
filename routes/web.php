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
use App\Http\Controllers\TestingController;
use App\Models\MitraVendor;


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
	Route::get('inputs', function () { return view('pages.inputs'); })->name('inputs');
	Route::get('witels', function () { $mitra_vendor = MitraVendor::getNamaVendor(); return view('pages.witels',compact('mitra_vendor')); })->name('witels');
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
Route::post('obl-tables/edit', [TableOblController::class, 'edit'])->middleware('auth')->name('obl.tables.edit');
Route::post('obl-tables/edit/update', [TableOblController::class, 'update'])->middleware('auth')->name('obl.tables.edit.update');
