<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lich_su_chung_tus', function (Blueprint $table) {
            $table->id(); // ID lịch sử chứng từ

            // 🔁 Khóa ngoại: chứng từ thay đổi
            $table->unsignedBigInteger('id_chung_tu');
            $table->foreign('id_chung_tu')->references('id')->on('chung_tus')->onDelete('cascade');

            // 🔁 Người thay đổi trạng thái (user)
            $table->unsignedBigInteger('id_nguoi_thay_doi');
            $table->foreign('id_nguoi_thay_doi')->references('id')->on('users')->onDelete('cascade');

            // 🔁 Trạng thái mới
            $table->unsignedBigInteger('id_trang_thai_moi');
            $table->foreign('id_trang_thai_moi')->references('id')->on('trang_thai_chung_tus')->onDelete('cascade');

            // Ghi chú
            $table->text('ghi_chu')->nullable();

            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('lich_su_chung_tus');
    }
};
