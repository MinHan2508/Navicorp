<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PhongBanController;
use App\Http\Controllers\PhanCongController;
use App\Http\Controllers\LoaiChungTuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ChungTuController;
use App\Http\Controllers\TrangThaiChungTuController;
use App\Http\Controllers\DoiTacController;
use App\Http\Controllers\VaiTroController;
use App\Http\Controllers\HuongChungTuController;

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

Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');

Route::put('/profile/change-password', [UserController::class, 'changePassword'])->name('profile.change-password');

//Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
//Route::get('/users/import', [UserController::class, 'showImportForm'])->name('users.import.form');
//Route::post('/users/import', [UserController::class, 'import'])->name('users.import');

//khai báo đường dẫn ảnh thẻ
Route::get('/avatar/{filename}', function ($filename) {
    $path = storage_path('app/img/anhthe/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path); // hoặc ->download($path)
})->name('user.avatar');



//phongban
Route::get('/phongban', [PhongBanController::class, 'index'])->name('phongban.index');
Route::get('/phongban/create', [PhongBanController::class, 'create'])->name('phongban.create');
Route::post('/phongban', [PhongBanController::class, 'store'])->name('phongban.store');
Route::get('/phongban/{phongban}/edit', [PhongBanController::class, 'edit'])->name('phongban.edit');
Route::put('/phongban/{phongban}', [PhongBanController::class, 'update'])->name('phongban.update');
Route::delete('/phongban/{phongban}', [PhongBanController::class, 'destroy'])->name('phongban.destroy');   
Route::get('/phongban/{phongban}', [PhongBanController::class, 'show'])->name('phongban.show');

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

// routes/web.php
Route::match(['get', 'post'], '/chung-tu/{chungTu}/xu-ly', [ChungTuController::class, 'xuLyChungTu'])
    ->name('chungtu.xuly');


// routes/web.php

// xem thông tin file
Route::get('/chungtu/view-file/{id}', [\App\Http\Controllers\ChungTuController::class, 'viewFile'])
    ->name('chungtu.viewFile');


//trangthaitrungtu

Route::get('/trangthaichungtu', [TrangThaiChungTuController::class, 'index'])->name('trangthaichungtu.index');
Route::get('/trangthaichungtu/create', [TrangThaiChungTuController::class, 'create'])->name('trangthaichungtu.create');
Route::post('/trangthaichungtu', [TrangThaiChungTuController::class, 'store'])->name('trangthaichungtu.store');
Route::get('/trangthaichungtu/{trangthaichungtu}/edit', [TrangThaiChungTuController::class, 'edit'])->name('trangthaichungtu.edit');
Route::put('/trangthaichungtu/{trangthaichungtu}', [TrangThaiChungTuController::class, 'update'])->name('trangthaichungtu.update');
Route::delete('/trangthaichungtu/{trangthaichungtu}', [TrangThaiChungTuController::class, 'destroy'])->name('trangthaichungtu.destroy');
Route::get('/trangthaichungtu/{trangthaichungtu}', [TrangThaiChungTuController::class, 'show'])->name('trangthaichungtu.show');


//doitac
Route::get('/doitac', [\App\Http\Controllers\DoiTacController::class, 'index'])->name('doitac.index');
Route::get('/doitac/create', [\App\Http\Controllers\DoiTacController::class, 'create'])->name('doitac.create');
Route::post('/doitac', [\App\Http\Controllers\DoiTacController::class, 'store'])->name('doitac.store');
Route::get('/doitac/{doitac}/edit', [\App\Http\Controllers\DoiTacController::class, 'edit'])->name('doitac.edit');
Route::put('/doitac/{doitac}', [\App\Http\Controllers\DoiTacController::class, 'update'])->name('doitac.update');
Route::delete('/doitac/{doitac}', [\App\Http\Controllers\DoiTacController::class, 'destroy'])->name('doitac.destroy');
Route::get('/doitac/{doitac}', [\App\Http\Controllers\DoiTacController::class, 'show'])->name('doitac.show');
//Route::get('/doitac/{doitac}', [\App\Http\Controllers\DoiTacController::class, 'show'])->name('doitac.show');



//Vai trò
Route::get('/vaitro', [\App\Http\Controllers\VaiTroController::class, 'index'])->name('vaitro.index');
Route::get('/vaitro/create', [\App\Http\Controllers\VaiTroController::class, 'create'])->name('vaitro.create');
Route::post('/vaitro', [\App\Http\Controllers\VaiTroController::class, 'store'])->name('vaitro.store');
Route::get('/vaitro/{vaitro}/edit', [\App\Http\Controllers\VaiTroController::class, 'edit'])->name('vaitro.edit');
Route::put('/vaitro/{vaitro}', [\App\Http\Controllers\VaiTroController::class, 'update'])->name('vaitro.update');
Route::delete('/vaitro/{vaitro}', [\App\Http\Controllers\VaiTroController::class, 'destroy'])->name('vaitro.destroy');
Route::get('/vaitro/{vaitro}', [\App\Http\Controllers\VaiTroController::class, 'show'])->name('vaitro.show');

//Hướng chứng từ
Route::get('/huongchungtu', [\App\Http\Controllers\HuongChungTuController::class, 'index'])->name('huongchungtu.index');
Route::get('/huongchungtu/create', [\App\Http\Controllers\HuongChungTuController::class, 'create'])->name('huongchungtu.create');
Route::post('/huongchungtu', [\App\Http\Controllers\HuongChungTuController::class, 'store'])->name('huongchungtu.store');
Route::get('/huongchungtu/{huongchungtu}/edit', [\App\Http\Controllers\HuongChungTuController::class, 'edit'])->name('huongchungtu.edit');
Route::put('/huongchungtu/{huongchungtu}', [\App\Http\Controllers\HuongChungTuController::class, 'update'])->name('huongchungtu.update');
Route::delete('/huongchungtu/{huongchungtu}', [\App\Http\Controllers\HuongChungTuController::class, 'destroy'])->name('huongchungtu.destroy');
Route::get('/huongchungtu/{huongchungtu}', [\App\Http\Controllers\HuongChungTuController::class, 'show'])->name('huongchungtu.show');


//nhanvien
Route::prefix('nhanvien')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('nhanvien.index');
    Route::get('/create', [UserController::class, 'edit'])->name('nhanvien.edit');
});