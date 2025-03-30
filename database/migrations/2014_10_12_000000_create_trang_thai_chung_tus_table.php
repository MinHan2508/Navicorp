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
        Schema::create('trang_thai_chung_tus', function (Blueprint $table) {
            $table->id(); // ID_TrangThaiChungTu
            
            $table->string('ma_trang_thai')->unique();
            $table->string('ten_trang_thai')->unique();
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
        Schema::dropIfExists('trang_thai_chung_tus');
    }
};
