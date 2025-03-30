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
        Schema::create('lich_su_chung_tus', function (Blueprint $table) {
            $table->id(); // ID_LichSu
         
            // Khóa ngoại: Mã chứng từ
            $table->unsignedBigInteger('chung_tu_id');
            $table->foreign('chung_tu_id')->references('id')->on('chung_tus')->onDelete('cascade');

            // Khóa ngoại: Người thay đổi trạng thái
            $table->unsignedBigInteger('nguoi_thay_doi_id');
            $table->foreign('nguoi_thay_doi_id')->references('id')->on('users')->onDelete('cascade');

            // Khóa ngoại: Trạng thái mới của chứng từ
            $table->unsignedBigInteger('trang_thai_moi_id');
            $table->foreign('trang_thai_moi_id')->references('id')->on('trang_thai_chung_tus')->onDelete('cascade');


            $table->text('ghi_chu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lich_su_chung_tus');
    }
};
