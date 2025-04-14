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
        Schema::create('vai_tro_quyen_han', function (Blueprint $table) {
            $table->unsignedBigInteger('id_vaitro');
            $table->unsignedBigInteger('id_quyenhan');

            // ✅ Khóa ngoại đúng bảng và cột
            $table->foreign('id_vaitro')->references('id')->on('vai_tros')->onDelete('cascade');
            $table->foreign('id_quyenhan')->references('id')->on('quyen_hans')->onDelete('cascade');

            $table->primary(['id_vaitro', 'id_quyenhan']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vai_tro_quyen_han');
    }
};
