<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
use App\Http\Controllers\QuyTrinhXuLyChungTuController;
use App\Http\Controllers\LichSuChungTuController;
use App\Http\Controllers\QuyenHanController;
use App\Http\Controllers\VaiTroQuyenHanController;
use App\Http\Controllers\NguoiNhanChungTuController;

Route::get('/', function () {
    return view('welcome');
});

// Hệ thống đăng nhập/đăng ký mặc định của Laravel
Auth::routes();

// Trang sau khi đăng nhập
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//test mail
Route::get('/test-mail', function () {
    Mail::raw('Đây là nội dung test gửi mail thành công.', function ($message) {
        $message->to('nguyendinhminhkhang045@gmail.com') // Email người nhận
            ->subject('🎯 Test gửi mail từ NAVICORP');
    });

    return '✅ Đã gửi thử mail! Kiểm tra hộp thư đi.';
});
 //tải file đính kèm đã mã hóa
 Route::get('/chungtu/download-signed/{chungTu}', [ChungTuController::class, 'downloadSigned'])
 ->name('chungtu.download.signed')
 ->middleware('signed'); // Rất quan trọng: bắt buộc có chữ ký

// Tất cả các route bắt buộc phải đăng nhập mới được dùng
Route::middleware(['auth'])->group(function () {

    // Upload
    Route::post('/upload', [UploadController::class, 'upload'])->name('upload');

    // User
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/import-excel', [UserController::class, 'importExcel'])->name('users.importExcel');
    Route::get('/users/import', [UserController::class, 'showExcelImportForm'])->name('users.excel');

    Route::put('/users/profile', [UserController::class, 'update'])->name('users.profile.update');
    Route::delete('/users/profile', [UserController::class, 'destroy'])->name('users.profile.delete');
    Route::get('/user/profile', [UserController::class, 'show'])->name('user.profile');
    Route::get('/users/profile', [UserController::class, 'show'])->name('users.profile');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/change-password', [UserController::class, 'changePassword'])->name('profile.change-password');

    Route::get('/chungtu/tao-moi/di', [ChungTuController::class, 'createDi'])->name('chungtu.create.di');
    Route::get('/chungtu/tao-moi/noi-bo', [ChungTuController::class, 'createNoiBo'])->name('chungtu.create.noi_bo');
    Route::get('/chungtu/tiep-nhan/den', [ChungTuController::class, 'createDen'])->name('chungtu.create.den');


   


    


    Route::prefix('nguoinhanchungtu')->group(function () {
        Route::get('create/{idChungTu}', [NguoiNhanChungTuController::class, 'create'])->name('nguoinhanchungtu.create');
        Route::post('store/{idChungTu}', [NguoiNhanChungTuController::class, 'store'])->name('nguoinhanchungtu.store');
        Route::get('chung-tu/{id}/da-gui', [NguoiNhanChungTuController::class, 'showDaGui'])
        ->name('nguoinhanchungtu.showDaGui');
    });
   


    // Các route danh sách chứng từ theo hướng:
    Route::get('/chung-tu-di', [ChungTuController::class, 'indexDi'])->name('chungtu.index.di');
    Route::get('/chung-tu-noi-bo', [ChungTuController::class, 'indexNoiBo'])->name('chungtu.index.noi_bo');
    Route::get('/chung-tu-den', [ChungTuController::class, 'indexDen'])->name('chungtu.index.den');


    Route::get('/avatar/{filename}', function ($filename) {
        $path = storage_path('app/img/anhthe/' . $filename);
        if (!file_exists($path)) {
            abort(404);
        }
        return response()->file($path);
    })->name('user.avatar');


    // Chứng từ
    Route::resource('chungtu', ChungTuController::class);
    Route::match(['get', 'post'], '/chung-tu/{chungTu}/xu-ly', [ChungTuController::class, 'xuLyChungTu'])->name('chungtu.xuly');
    Route::get('/chungtu/view-file/{id}', [ChungTuController::class, 'viewFile'])->name('chungtu.viewFile');
    // Đối tác
    Route::resource('doitac', DoiTacController::class);
    //Quy trình xử lý chứng từ
    Route::resource('quytrinh', QuyTrinhXuLyChungTuController::class);

    // Nhân viên
    Route::prefix('nhanvien')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('nhanvien.index');
        Route::get('/create', [UserController::class, 'edit'])->name('nhanvien.edit');
    });



    Route::middleware(['auth', 'is_admin'])->group(function () {


        // Phòng ban
        Route::resource('phongban', PhongBanController::class);

        // Loại chứng từ
        Route::resource('loaichungtu', LoaiChungTuController::class);


        // Trạng thái chứng từ
        Route::resource('trangthaichungtu', TrangThaiChungTuController::class);



        // Vai trò
        Route::resource('vaitro', VaiTroController::class);

        // Hướng chứng từ
        Route::resource('huongchungtu', HuongChungTuController::class);



        //quyền hạn
        Route::resource('quyenhan', QuyenHanController::class);



        //vai trò quyền hạn
        Route::prefix('phanquyen')->group(function () {
            Route::get('/', [VaiTroQuyenHanController::class, 'index'])->name('vaitro_quyenhan.index');
            Route::get('/{id}/edit', [VaiTroQuyenHanController::class, 'edit'])->name('vaitro_quyenhan.edit');
            Route::put('/{id}', [VaiTroQuyenHanController::class, 'update'])->name('vaitro_quyenhan.update');
        });


    });




});
