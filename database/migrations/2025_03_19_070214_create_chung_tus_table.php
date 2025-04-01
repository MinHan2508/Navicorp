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
            $table->id(); // PRIMARY KEY
        
                 

            $table->string('ma_chung_tu', 255)->unique(); // Mã chứng từ
            $table->string('tieu_de', 255); // Tiêu đề
            $table->string('so_hieu')->nullable(); // Số hiệu văn bản
            $table->string('duong_dan', 255); // Đường dẫn tệp
            $table->text('trich_yeu')->nullable(); // Trích yếu nội dung
            

            $table->string('noi_ban_hanh')->nullable(); // Nơi phát hành
            $table->date('ngay_ban_hanh')->nullable(); // Ngày phát hành
            $table->date('ngay_hieu_luc')->nullable(); // Ngày có hiệu lực
            $table->date('ngay_het_hieu_luc')->nullable(); // Ngày hết hiệu lực
            $table->boolean('ky_so')->default(false); // Đã ký số chưa

            $table->text('ghi_chu')->nullable(); // Ghi chú

            // Liên kết hướng chứng từ
            $table->unsignedBigInteger('id_huong')->nullable(); // ID hướng chứng từ
            $table->foreign('id_huong')->references('id')->on('huong_chung_tus')->onDelete('set null');

            // Liên kết trạng thái hiện tại của chứng từ
            $table->unsignedBigInteger('id_trang_thai_hien_tai')->nullable(); // ID trạng thái hiện tại
            $table->foreign('id_trang_thai_hien_tai')->references('id')->on('trang_thai_chung_tus')->onDelete('set null');


            // Liên kết loại chứng từ
            $table->unsignedBigInteger('id_loai_chung_tu');
            $table->foreign('id_loai_chung_tu')
                ->references('id')->on('loai_chung_tus')
                ->onDelete('cascade');
        
            // Người gửi chứng từ (đối tác)
            $table->unsignedBigInteger('id_nguoi_gui_doi_tac')->nullable();
            $table->foreign('id_nguoi_gui_doi_tac')
                ->references('id')->on('doi_tacs')
                ->onDelete('cascade');
        
           
        
            $table->timestamps(); // created_at & updated_at
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
