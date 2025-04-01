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
            $table->unsignedBigInteger('vaitro_id');
            $table->unsignedBigInteger('quyen_id');
        
            $table->foreign('vaitro_id')->references('id')->on('vai_tros')->onDelete('cascade');
            $table->foreign('quyen_id')->references('id')->on('quyen_hans')->onDelete('cascade');
        
            $table->primary(['vaitro_id', 'quyen_id']); // khoá chính kép
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
