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
        Schema::create('chung_tus', function (Blueprint $table) {
            $table->id(); // PRIMARY KEY, AUTO_INCREMENT
            $table->string('ma_chung_tu', 255)->unique()->notNull(); // UNIQUE, NOT NULL
            $table->string('tieu_de', 255)->notNull(); // Tiêu đề chứng từ, NOT NULL
          
            $table->string('duong_dan', 255)->notNull(); // Đường dẫn lưu trữ tệp, NOT NULL
            $table->text('ghi_chu')->nullable(); // Ghi chú, NULLABLE

            // Khóa ngoại: Loại chứng từ
            $table->unsignedBigInteger('id_loai_chung_tu');
            $table->foreign('id_loai_chung_tu')->references('id')->on('loai_chung_tus')->onDelete('cascade');

            // Khóa ngoại: Người tạo chứng từ (nếu là nhân viên nội bộ)
            $table->unsignedBigInteger('nguoi_tao_id')->nullable();
            $table->foreign('nguoi_tao_id')->references('id')->on('users')->onDelete('cascade');

            // Khóa ngoại: Người gửi chứng từ (nếu là đối tác bên ngoài)
            $table->unsignedBigInteger('nguoi_gui_doi_tac_id')->nullable();
            $table->foreign('nguoi_gui_doi_tac_id')->references('id')->on('doi_tacs')->onDelete('cascade');

            // Khóa ngoại: Trạng thái chứng từ
            $table->unsignedBigInteger('trang_thai_id');
            $table->foreign('trang_thai_id')->references('id')->on('trang_thai_chung_tus')->onDelete('cascade');


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
        Schema::dropIfExists('chung_tus');
    }
};
