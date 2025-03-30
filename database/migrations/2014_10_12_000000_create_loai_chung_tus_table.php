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
        Schema::create('loai_chung_tus', function (Blueprint $table) {
            $table->id(); // ID_LoaiChungTu
            $table->string('ma_loai_chung_tu')->unique();
            $table->string('ten_loai_chung_tu')->unique();
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
        Schema::dropIfExists('loai_chung_tus');
    }
};
