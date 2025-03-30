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
        Schema::create('doi_tacs', function (Blueprint $table) {
            $table->id(); // ID_DoiTac
            $table->string('ten_doi_tac');
            $table->string('dia_chi')->nullable();
            $table->string('sdt', 20)->nullable()->unique();
            $table->string('email', 100)->nullable()->unique();
            $table->enum('loai_doi_tac', ['Cá nhân', 'Tổ chức']);
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
        Schema::dropIfExists('doi_tacs');
    }
};
