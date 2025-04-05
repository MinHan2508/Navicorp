<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nguoi_nhan_chung_tus', function (Blueprint $table) {
            $table->id(); // ID - Khóa chính, tự động tăng

            // Khóa ngoại: Mã chứng từ
            $table->unsignedBigInteger('id_chung_tu');
            $table->foreign('id_chung_tu')->references('id')->on('chung_tus')->onDelete('cascade');

            // Khóa ngoại: Người nhận chứng từ (nếu là nhân viên nội bộ)
            $table->unsignedBigInteger('id_nguoi_nhan')->nullable();
            $table->foreign('id_nguoi_nhan')->references('id')->on('users')->onDelete('cascade');

            // Khóa ngoại: Người nhận chứng từ (nếu là đối tác bên ngoài)
            $table->unsignedBigInteger('id_doi_tac')->nullable();
            $table->foreign('id_doi_tac')->references('id')->on('doi_tacs')->onDelete('cascade');

            // Ghi chú
            $table->text('ghi_chu')->nullable();
         
            $table->timestamps(); // Tự động thêm created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nguoi_nhan_chung_tus');
    }
};
