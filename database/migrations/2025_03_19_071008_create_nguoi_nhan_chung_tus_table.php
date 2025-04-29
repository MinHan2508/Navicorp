<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('nguoi_nhan_chung_tus', function (Blueprint $table) {
            $table->id();

            // Chứng từ được gửi
            $table->unsignedBigInteger('id_chung_tu');
            $table->foreign('id_chung_tu')->references('id')->on('chung_tus')->onDelete('cascade');

            // Người nhận là user
            $table->unsignedBigInteger('id_nguoi_nhan')->nullable();
            $table->foreign('id_nguoi_nhan')->references('id')->on('users')->onDelete('cascade');

            // Người nhận là phòng ban
            $table->unsignedBigInteger('id_phong_ban')->nullable();
            $table->foreign('id_phong_ban')->references('id')->on('phong_bans')->onDelete('cascade');

            // Người nhận là đối tác bên ngoài
            $table->unsignedBigInteger('id_doi_tac')->nullable();
            $table->foreign('id_doi_tac')->references('id')->on('doi_tacs')->onDelete('cascade');

            // Loại người nhận (user/phong_ban/doi_tac)
            $table->enum('loai_nguoi_nhan', ['user', 'phong_ban', 'doi_tac'])->nullable();

            // Trạng thái xem chứng từ
            $table->boolean('da_xem')->default(false);

            // Thời điểm người nhận đã xem chứng từ (nếu có)
            $table->timestamp('thoi_gian_xem')->nullable();

            // Ghi chú cá nhân hóa
            $table->text('ghi_chu')->nullable();

            $table->timestamps();
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('nguoi_nhan_chung_tus');
    }
};
