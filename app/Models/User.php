<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'id_vaitro',
        'sdt',
        'dia_chi',
        'gioi_tinh',
        'ngay_sinh',
        'anh',
        'id_phongban',
        'trang_thai',
        'ghi_chu',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 🔗 Quan hệ với vai trò
    public function vaiTro()
    {
        return $this->belongsTo(VaiTro::class, 'id_vaitro');
    }

    // 🔗 Quan hệ với phòng ban
    public function phongBan()
    {
        return $this->belongsTo(\App\Models\PhongBan::class, 'id_phongban');
    }

    // ✅ Nếu cần custom view cho hồ sơ cá nhân
    public function profile()
    {
        return view('user.profile');
    }
}
