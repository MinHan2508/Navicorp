<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quy_trinh_xu_ly_chung_tu', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_huong');             // Hướng chứng từ (Đến, Đi, Nội bộ...)
            $table->unsignedBigInteger('id_tu_trang_thai');     // Trạng thái hiện tại
            $table->unsignedBigInteger('id_den_trang_thai');    // Trạng thái kế tiếp hợp lệ
            $table->integer('thu_tu')->nullable();              // Thứ tự hiển thị nếu cần
            $table->text('mo_ta')->nullable();                  // Ghi chú bổ sung
            $table->timestamps();

            // FOREIGN KEYS
            $table->foreign('id_huong')->references('id')->on('huong_chung_tus')->onDelete('cascade');
            $table->foreign('id_tu_trang_thai')->references('id')->on('trang_thai_chung_tus')->onDelete('cascade');
            $table->foreign('id_den_trang_thai')->references('id')->on('trang_thai_chung_tus')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('quy_trinh_xu_ly_chung_tu');
    }
};
