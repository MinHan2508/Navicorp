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
        Schema::create('users', function (Blueprint $table) {
            $table->id();// ID_TaiKhoan
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedBigInteger('id_vaitro')->nullable();
            $table->foreign('id_vaitro')->references('id')->on('vai_tros')->onDelete('set null');
            $table->string('sdt', 20)->nullable()->unique();
            $table->string('dia_chi')->nullable();
            $table->enum('gioi_tinh', ['Nam', 'Nữ', 'Khác'])->default('Nam');
            $table->date('ngay_sinh')->nullable();
            $table->string('anh')->nullable();
            $table->unsignedBigInteger('id_phongban')->nullable();
            $table->foreign('id_phongban')->references('id')->on('phong_bans')->onDelete('set null');

            $table->enum('trang_thai', ['Hoạt động', 'Khóa', 'Khác'])->default('Hoạt động');
            $table->string('ghi_chu')->nullable();

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }



};
