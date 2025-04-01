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
            $table->unsignedBigInteger('chung_tu_id');
            $table->foreign('chung_tu_id')->references('id')->on('chung_tus')->onDelete('cascade');

            // 🔁 Người thay đổi trạng thái (user)
            $table->unsignedBigInteger('nguoi_thay_doi_id');
            $table->foreign('nguoi_thay_doi_id')->references('id')->on('users')->onDelete('cascade');

            // 🔁 Trạng thái mới
            $table->unsignedBigInteger('trang_thai_moi_id');
            $table->foreign('trang_thai_moi_id')->references('id')->on('trang_thai_chung_tus')->onDelete('cascade');

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
