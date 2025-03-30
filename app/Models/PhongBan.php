<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhongBan extends Model
{
    protected $fillable = ['ma_phong_ban', 'ten_phong_ban'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'phan_congs', 'phongban_id', 'user_id');
    }
    
    use HasFactory;
}
