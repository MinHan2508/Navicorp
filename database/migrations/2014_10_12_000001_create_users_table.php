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
            $table->string('vaitro')->default('nv');
            $table->string('sdt', 20)->nullable()->unique();
            $table->string('dia_chi')->nullable();
            $table->string('gioi_tinh')->default('nam');
            $table->string('anh')->nullable();
            $table->enum('trang_thai', ['Hoạt động', 'Khóa'])->default('Hoạt động');
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
