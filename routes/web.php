<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PhongBanController;
use App\Http\Controllers\PhanCongController;
use App\Http\Controllers\LoaiChungTuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ChungTuController;
use App\Http\Controllers\TrangThaiChungTuController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::post('/upload', [UploadController::class, 'upload'])->name('upload');



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//user
Route::get('/users', [UserController::class, 'index'])->name('users.index'); 
Route::get('/users/create', [UserController::class, 'create'])->name('users.create'); 
Route::post('/users', [UserController::class, 'store'])->name('users.store'); 
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');



Route::put('/users/profile', [UserController::class, 'update'])->name('users.profile.update');
Route::delete('/users/profile', [UserController::class, 'destroy'])->name('users.profile.delete');
Route::get('/user/profile', [UserController::class, 'show'])->name('user.profile')->middleware('auth');
Route::get('/user/profile', [UserController::class, 'show'])->name('user.profile');
Route::get('/users/profile', [UserController::class, 'show'])->name('users.profile');
//Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
//Route::get('/users/import', [UserController::class, 'showImportForm'])->name('users.import.form');
//Route::post('/users/import', [UserController::class, 'import'])->name('users.import');
//phongban
Route::get('/phongban', [PhongBanController::class, 'index'])->name('phongban.index');
Route::get('/phongban/create', [PhongBanController::class, 'create'])->name('phongban.create');
Route::post('/phongban', [PhongBanController::class, 'store'])->name('phongban.store');
Route::get('/phongban/{phongban}/edit', [PhongBanController::class, 'edit'])->name('phongban.edit');
Route::put('/phongban/{phongban}', [PhongBanController::class, 'update'])->name('phongban.update');
Route::delete('/phongban/{phongban}', [PhongBanController::class, 'destroy'])->name('phongban.destroy');   
Route::get('/phongban/{phongban}', [PhongBanController::class, 'show'])->name('phongban.show');

//phancong
Route::get('/phancong', [PhanCongController::class, 'index'])->name('phancong.index');
Route::get('/phancong/create', [PhanCongController::class, 'create'])->name('phancong.create');
Route::post('/phancong', [PhanCongController::class, 'store'])->name('phancong.store');
Route::get('/phancong/{phancong}/edit', [PhanCongController::class, 'edit'])->name('phancong.edit');
Route::put('/phancong/{phancong}', [PhanCongController::class, 'update'])->name('phancong.update');
Route::delete('/phancong/{phancong}', [PhanCongController::class, 'destroy'])->name('phancong.destroy');
Route::get('/phancong/{phancong}', [PhanCongController::class, 'show'])->name('phancong.show');

//loaichungtu
Route::get('/loaichungtu', [LoaiChungTuController::class, 'index'])->name('loaichungtu.index');
Route::get('/loaichungtu/create', [LoaiChungTuController::class, 'create'])->name('loaichungtu.create');
Route::post('/loaichungtu', [LoaiChungTuController::class, 'store'])->name('loaichungtu.store');
Route::get('/loaichungtu/{loaichungtu}/edit', [LoaiChungTuController::class, 'edit'])->name('loaichungtu.edit');
Route::put('/loaichungtu/{loaichungtu}', [LoaiChungTuController::class, 'update'])->name('loaichungtu.update');
Route::delete('/loaichungtu/{loaichungtu}', [LoaiChungTuController::class, 'destroy'])->name('loaichungtu.destroy');
Route::get('/loaichungtu/{loaichungtu}', [LoaiChungTuController::class, 'show'])->name('loaichungtu.show'); 

//chung tu
Route::get('/chungtu', [ChungTuController::class, 'index'])->name('chungtu.index');
Route::get('/chungtu/create', [ChungTuController::class, 'create'])->name('chungtu.create');
Route::post('/chungtu', [ChungTuController::class, 'store'])->name('chungtu.store');
Route::get('/chungtu/{chungtu}/edit', [ChungTuController::class, 'edit'])->name('chungtu.edit');
Route::put('/chungtu/{chungtu}', [ChungTuController::class, 'update'])->name('chungtu.update');
Route::delete('/chungtu/{chungtu}', [ChungTuController::class, 'destroy'])->name('chungtu.destroy');
Route::get('/chungtu/{chungtu}', [ChungTuController::class, 'show'])->name('chungtu.show');


//trangthaitrungtu

Route::get('/trangthaichungtu', [TrangThaiChungTuController::class, 'index'])->name('trangthaichungtu.index');
Route::get('/trangthaichungtu/create', [TrangThaiChungTuController::class, 'create'])->name('trangthaichungtu.create');
Route::post('/trangthaichungtu', [TrangThaiChungTuController::class, 'store'])->name('trangthaichungtu.store');
Route::get('/trangthaichungtu/{trangthaichungtu}/edit', [TrangThaiChungTuController::class, 'edit'])->name('trangthaichungtu.edit');
Route::put('/trangthaichungtu/{trangthaichungtu}', [TrangThaiChungTuController::class, 'update'])->name('trangthaichungtu.update');
Route::delete('/trangthaichungtu/{trangthaichungtu}', [TrangThaiChungTuController::class, 'destroy'])->name('trangthaichungtu.destroy');
Route::get('/trangthaichungtu/{trangthaichungtu}', [TrangThaiChungTuController::class, 'show'])->name('trangthaichungtu.show');





//nhanvien
Route::prefix('nhanvien')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('nhanvien.index');
    Route::get('/create', [UserController::class, 'edit'])->name('nhanvien.edit');
});