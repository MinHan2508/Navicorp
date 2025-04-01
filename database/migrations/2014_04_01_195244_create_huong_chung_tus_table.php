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
        Schema::create('huong_chung_tus', function (Blueprint $table) {
            $table->id();
            $table->string('ma_huong_chung_tu')->unique(); // Mã ví dụ: DEN, DI, NOI_BO
            $table->string('ten_huong_chung_tu');          // Tên ví dụ: Văn bản đến
            $table->text('ghi_chu')->nullable();    // Mô tả chi tiết
            $table->timestamps();                 // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('huong_chung_tus');
    }
};
