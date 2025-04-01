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
            $table->unsignedBigInteger('chung_tu_id');
            $table->foreign('chung_tu_id')->references('id')->on('chung_tus')->onDelete('cascade');

            // Khóa ngoại: Người nhận chứng từ (nếu là nhân viên nội bộ)
            $table->unsignedBigInteger('nguoi_nhan_id')->nullable();
            $table->foreign('nguoi_nhan_id')->references('id')->on('users')->onDelete('cascade');

            // Khóa ngoại: Người nhận chứng từ (nếu là đối tác bên ngoài)
            $table->unsignedBigInteger('doi_tac_id')->nullable();
            $table->foreign('doi_tac_id')->references('id')->on('doi_tacs')->onDelete('cascade');

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
